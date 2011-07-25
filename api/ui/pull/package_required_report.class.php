<?php
/**
 * package_required_report.class.php
 * 
 * @author Dean Inglis <inglisd@mcmaster.ca>
 * @package sabretooth\ui
 * @filesource
 */

namespace sabretooth\ui\pull;
use sabretooth\log, sabretooth\util;
use sabretooth\business as bus;
use sabretooth\database as db;
use sabretooth\exception as exc;

/**
 * Package required report data.
 * 
 * @abstract
 * @package sabretooth\ui
 */
class package_required_report extends base_report
{
  /**
   * Constructor
   * 
   * @author Dean Inglis <inglisd@mcmaster.ca>
   * @param array $args Pull arguments.
   * @access public
   */
  public function __construct( $args )
  {
    parent::__construct( 'package_required', $args );
  }

  public function finish()
  {
    $restrict_site_id = $this->get_argument( 'restrict_site_id', 0);

    $title = 'New Package Required Report';
    if( $restrict_site_id )
    {
      $db_site = new db\site( $restrict_site_id );
      $title = $title.' for '.$db_site->name;
    }

    // TODO: Change this to the title/code of the limesurvey question to check
    // (this should be the consent form question)
    $question_code = 'A';

    $this->add_title(
      'A list of participant\'s who have indicated they require a new information package' );
    
    $contents = array();

    // loop through every participant searching for those who have no written consent
    foreach( db\participant::select() as $db_participant )
    {
      $done = false;

      $consent_mod = new db\modifier();
      $consent_mod->where( 'event', '=', 'written accept' );
      $consent_mod->or_where( 'event', '=', 'written deny' );
      $consent_mod->or_where( 'event', '=', 'retract' );
      $consent_mod->or_where( 'event', '=', 'withdraw' );
      if( 0 == count( $db_participant->get_consent_list( $consent_mod ) ) )
      {
        // now go through their interviews until the consent question code is found
        foreach( $db_participant->get_interview_list() as $db_interview )
        {
          foreach( $db_interview->get_qnaire()->get_phase_list() as $db_phase )
          {
            // figure out the token
            $token = db\limesurvey\record::get_token( $db_interview, $db_phase );

            // determine if the participant answered yes to the consent question
            $survey_mod = new db\modifier();
            if( $db_phase->repeated )
            {
              // replace the token's 0 with a database % wildcard
              $token = substr( $token, 0, -1 ).'%';
              $survey_mod->where( 'token', 'LIKE', $token );
            }
            else $survey_mod->where( 'token', '=', $token );

            db\limesurvey\survey::$table_sid = $db_phase->sid;
            foreach( db\limesurvey\survey::select( $survey_mod ) as $db_survey )
            {
              if( $db_survey && 'Y' == $db_survey->get_response( $question_code ) )
              {
                $db_address = $db_participant->get_first_address();
                $db_region = $db_address->get_region();
                $db_last_phone_call = $db_participant->get_last_contacted_phone_call();

                $contents[] = array(
                  $db_participant->uid,
                  $db_interview->completed ? 'Yes' : 'No',
                  $db_last_phone_call ? $db_last_phone_call()->start_datetime : 'never',
                  $db_participant->first_name,
                  $db_participant->last_name,
                  $db_address->address1." ".$db_address->address2,
                  $db_address->city,
                  $db_region->abbreviation,
                  $db_region->country,
                  $db_address->postcode );

                $done = true;
              }
              if( $done ) break; // stop searching if we're done
            }
            if( $done ) break; // stop searching if we're done
          }
          if( $done ) break; // stop searching if we're done
        }
      }
    }
    
    $header = array(
      "UID",
      "Interview\nComplete",
      "Last Contact",
      "First Name",
      "Last Name",
      "Address",
      "City",
      "Prov/State",
      "Country",
      "Postcode" );
    
    $this->add_table( NULL, $header, $contents, NULL );

    return parent::finish();
  }
}
?>
