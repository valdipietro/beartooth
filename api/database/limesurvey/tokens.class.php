<?php
/**
 * tokens.class.php
 * 
 * @author Patrick Emond <emondpd@mcmaster.ca>
 * @filesource
 */

namespace beartooth\database\limesurvey;
use cenozo\lib, cenozo\log, beartooth\util;

/**
 * Access to limesurvey's tokens_SID tables.
 */
class tokens extends sid_record
{
  /**
   * Updates the token attributes with current values from Mastodon
   * 
   * @author Patrick Emond <emondpd@mcmaster.ca>
   * @param database\participant $db_participant The record of the participant linked to this token.
   * @param boolean $extended Whether or not to included extended parameters.
   * @access public
   */
  public function update_attributes( $db_participant )
  {
    $session = lib::create( 'business\session' );
    $mastodon_manager = lib::create( 'business\cenozo_manager', MASTODON_URL );
    $db_user = $session->get_user();
    $db_site = $session->get_site();

    // determine the first part of the token
    $db_interview = $session->get_current_assignment()->get_interview();
    $token_part = substr( static::determine_token_string( $db_interview ), 0, -1 );
    
    // try getting the attributes from mastodon or beartooth
    $participant_info = new \stdClass();
    if( $mastodon_manager->is_enabled() )
    {
      $participant_info = $mastodon_manager->pull(
        'participant', 'primary', array( 'uid' => $db_participant->uid ) );
      $consent_info = $mastodon_manager->pull(
        'participant', 'list_consent', array( 'uid' => $db_participant->uid ) );
      $alternate_info = $mastodon_manager->pull(
        'participant', 'list_alternate', array( 'uid' => $db_participant->uid ) );
      
      // written consent received
      $written_consent = false;
      foreach( $consent_info->data as $consent )
      {
        if( 'written' == substr( $consent->event, 0, 7 ) )
        {
          $written_consent = true;
          break;
        }
      }
    }
    else
    {
      $db_address = $db_participant->get_primary_address();
      if( is_null( $db_address ) )
      {
        $participant_info->data->street = "";
        $participant_info->data->city = "";
        $participant_info->data->region = "";
        $participant_info->data->postcode = "";
      }
      else
      {
        $participant_info->data->street = $db_address->address1;
        if( !is_null( $db_address->address2 ) )
          $participant_info->data->street .= ' '.$db_address->address2;
        $participant_info->data->city = $db_address->city;
        $participant_info->data->region = $db_address->get_region()->name;
        $participant_info->data->postcode = $db_address->postcode;
      }

      // written consent received
      $consent_mod = lib::create( 'database\modifier' );
      $consent_mod->where( 'event', 'like', 'written %' );
      $written_consent = 0 < $db_participant->get_consent_count( $consent_mod );

      // beartooth doesn't track the following information
      $participant_info->data->date_of_birth = "";
      $participant_info->data->email = "";
      $participant_info->data->hin_access = "";
      $participant_info->data->prior_contact_date = "";
      $alternate_info->data = array();
    }
    
    // determine the attributes from the survey with the same ID
    $db_surveys = lib::create( 'database\limesurvey\surveys', static::$table_sid );

    foreach( explode( "\n", $db_surveys->attributedescriptions ) as $attribute )
    {
      if( 10 < strlen( $attribute ) )
      {
        $key = 'attribute_'.substr( $attribute, 10, strpos( $attribute, '=' ) - 10 );
        $value = substr( $attribute, strpos( $attribute, '=' ) + 1 );
        $matches = array(); // for pregs below
        
        // now get the info based on the attribute name
        if( 'address street' == $value )
        {
          $this->$key = $participant_info->data->street;
        }
        else if( 'address city' == $value )
        {
          $this->$key = $participant_info->data->city;
        }
        else if( 'address province' == $value )
        {
          $this->$key = $participant_info->data->region;
        }
        else if( 'address postal code' == $value )
        {
          $this->$key = $participant_info->data->postcode;
        }
        else if( 'age' == $value )
        {
          $this->$key = strlen( $participant_info->data->date_of_birth )
                      ? util::get_interval(
                          util::get_datetime_object( $participant_info->data->date_of_birth ) )->y
                      : "";
        }
        else if( 'written consent received' == $value )
        {
          $this->$key = $written_consent ? "1" : "0";
        }
        else if( 'consented to provide HIN' == $value )
        {
          $this->$key = true == $participant_info->data->hin_access ? "1" : "0";
        }
        else if( 'INCL_2e' == $value )
        {
          // TODO: This is a custom token attribute which refers to a specific question in the
          // introduction survey.  This code is not generic and needs to eventually be made
          // generic.
          $survey_class_name = lib::get_class_name( 'database\limesurvey\survey' );
          
          $db_interview = lib::create( 'business\session')->get_current_assignment()->get_interview();
          $phase_mod = lib::create( 'database\modifier' );
          $phase_mod->where( 'rank', '=', 1 );
          $phase_list = $db_interview->get_qnaire()->get_phase_list( $phase_mod );

          // determine the SID of the first phase of the questionnaire (where the question is asked)
          if( 1 == count( $phase_list ) )
          {
            $db_phase = current( $phase_list );
            $survey_class_name::set_sid( $db_phase->sid );

            $survey_mod = lib::create( 'database\modifier' );
            $survey_mod->where( 'token', 'LIKE', $token_part.'%' );
            $survey_mod->order_desc( 'datestamp' );
            $survey_list = $survey_class_name::select( $survey_mod );

            $found = false;
            foreach( $survey_list as $db_survey )
            { // loop through all surveys until an answer is found
              try
              {
                $this->$key = $db_survey->get_response( $value );
                // match any NON NULL response
                if( !is_null( $this->$key ) ) $found = true;
              }
              catch( \cenozo\exception\runtime $e )
              {
                // ignore the error and continue without setting the attribute
              }
              
              if( $found ) break;
            }
          }
        }
        else if( 'interviewer first_name' == $value )
        {
          $this->$key = $db_user->first_name;
        }
        else if( 'interviewer last_name' == $value )
        {
          $this->$key = $db_user->last_name;
        }
        else if( 'participant_source' == $value )
        {
          $db_source = $db_participant->get_source();
          $this->$key = is_null( $db_source ) ? '(none)' : $db_source->name;
        }
        else if( 'previous CCHS contact date' == $value )
        {
          $this->$key = $participant_info->data->prior_contact_date;
        }
        else if( 'number of alternate contacts' == $value )
        {
          $this->$key = count( $alternate_info->data );
        }
        else if( 'dcs phone_number' == $value )
        {
          $this->$key = $db_site->phone_number;
        }
        else if( 'dcs address street' == $value )
        {
          $this->$key =
            $db_site->address1.( is_null( $db_site->address2 ) ? '' : ', '.$db_site->address2 );
        }
        else if( 'dcs address city' == $value )
        {
          $this->$key = $db_site->city;
        }
        else if( 'dcs address province' == $value )
        {
          $this->$key = $db_site->get_region()->name;
        }
        else if( 'dcs address postal code' == $value )
        {
          $this->$key = $db_site->postcode;
        }
        else if(
          preg_match( '/alternate([0-9]+) (first_name|last_name|phone)/', $value, $matches ) )
        {
          $alt_number = intval( $matches[1] );
          $aspect = $matches[2];

          if( 'phone' == $aspect )
          {
            $phone_list = $alternate_info->data[$alt_number - 1]->phone_list;
            $this->$key = $alt_number <= count( $alternate_info->data )
                        ? ( is_array( $phone_list ) ? $phone_list[0]->number : '' )
                        : '';
          }
          else
          {
            $this->$key = $alt_number <= count( $alternate_info->data )
                        ? $alternate_info->data[$alt_number - 1]->$aspect
                        : "";
          }
        }
        else if( 'previously completed' == $value )
        {
          // no need to set the token sid since it should already be set before calling this method
          $tokens_mod = lib::create( 'database\modifier' );
          $tokens_mod->where( 'token', 'like', $token_part.'%' );
          $tokens_mod->where( 'completed', '!=', 'N' );
          $this->$key = static::count( $tokens_mod );
        }
      }
    }
  }

  /**
   * Returns the token name for a particular interview.
   * If the survey's phase is repeated then the assignment must also be provided.
   * @author Patrick Emond <emondpd@mcmaster.ca>
   * @param database\interview $db_interview 
   * @param database\interview $db_assignment (only used if the phase is repeated)
   * @static
   * @access public
   */
  public static function determine_token_string( $db_interview, $db_assignment = NULL )
  {
    return sprintf( '%s_%s',
                    $db_interview->id,
                    is_null( $db_assignment ) ? 0 : $db_assignment->id );
  }

  /**
   * The name of the table's primary key column.
   * @var string
   * @access protected
   */
  protected static $primary_key_name = 'tid';
}
?>
