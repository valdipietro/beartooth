<?php
/**
 * queue_list.class.php
 * 
 * @author Patrick Emond <emondpd@mcmaster.ca>
 * @filesource
 */

namespace beartooth\ui\widget;
use cenozo\lib, cenozo\log, beartooth\util;

/**
 * widget queue list
 */
class queue_list extends \cenozo\ui\widget\base_list
{
  /**
   * Constructor
   * 
   * Defines all variables required by the queue list.
   * @author Patrick Emond <emondpd@mcmaster.ca>
   * @param array $args An associative array of arguments to be processed by the widget
   * @access public
   */
  public function __construct( $args )
  {
    parent::__construct( 'queue', $args );
  }

  /**
   * Processes arguments, preparing them for the operation.
   * 
   * @author Patrick Emond <emondpd@mcmaster.ca>
   * @throws exception\notice
   * @access protected
   */
  protected function prepare()
  {
    parent::prepare();

    // make sure to display all queues on the same page
    $this->set_items_per_page( 1000 );
    
    $restrict_site_id = $this->get_argument( 'restrict_site_id', 0 );

    $this->add_column( 'rank', 'number', 'Rank', true );
    if( $restrict_site_id )
      $this->add_column( 'enabled', 'boolean', 'Enabled', false );
    $this->add_column( 'participant_count', 'number', 'Participants', false );
    $this->add_column( 'description', 'text', 'Description', true, true, 'left' );
    $session = lib::create( 'business\session' );
    if( 3 != $session->get_role()->tier )
      $this->set_heading(
        sprintf( '%s %s for %s',
                 $this->get_subject(),
                 $this->get_name(),
                 $session->get_site()->name ) );
  }

  /**
   * Sets up the operation with any pre-execution instructions that may be necessary.
   * 
   * @author Patrick Emond <emondpd@mcmaster.ca>
   * @access protected
   */
  protected function setup()
  {
    parent::setup();
    
    $site_class_name = lib::get_class_name( 'database\site' );
    $qnaire_class_name = lib::get_class_name( 'database\qnaire' );
    $queue_class_name = lib::get_class_name( 'database\queue' );
    $participant_class_name = lib::get_class_name( 'database\participant' );

    $session = lib::create( 'business\session' );
    $is_top_tier = 3 == $session->get_role()->tier;
    
    // if this is a top tier role, give them a list of sites to choose from
    if( $is_top_tier )
    {
      $sites = array();
      foreach( $site_class_name::select() as $db_site )
        $sites[$db_site->id] = $db_site->name;
      $this->set_variable( 'sites', $sites );
    }

    $restrict_site_id = $this->get_argument( 'restrict_site_id', 0 );
    $this->set_variable( 'restrict_site_id', $restrict_site_id );
    $db_restrict_site = $restrict_site_id
                      ? lib::create( 'database\site', $restrict_site_id )
                      : NULL;

    $qnaires = array();
    foreach( $qnaire_class_name::select() as $db_qnaire )
      $qnaires[$db_qnaire->id] = $db_qnaire->name;
    $this->set_variable( 'qnaires', $qnaires );
    
    $restrict_qnaire_id = $this->get_argument( 'restrict_qnaire_id', 0 );
    $this->set_variable( 'restrict_qnaire_id', $restrict_qnaire_id );
    $db_restrict_qnaire = $restrict_qnaire_id
                        ? lib::create( 'database\qnaire', $restrict_qnaire_id )
                        : NULL;
    
    $languages = array( 'any' );
    foreach( $participant_class_name::get_enum_values( 'language' ) as $language )
      $languages[] = $language;
    $this->set_variable( 'languages', $languages );
    
    $restrict_language = $this->get_argument( 'restrict_language', 'any' );
    $this->set_variable( 'restrict_language', $restrict_language );

    $current_date = util::get_datetime_object()->format( 'Y-m-d' );
    $this->set_variable( 'current_date', $current_date );
    $viewing_date = $this->get_argument( 'viewing_date', 'current' );
    if( $current_date == $viewing_date ) $viewing_date = 'current';
    $this->set_variable( 'viewing_date', $viewing_date );

    // set the viewing date if it is not "current"
    if( 'current' != $viewing_date ) $queue_class_name::set_viewing_date( $viewing_date );

    $setting_manager = lib::create( 'business\setting_manager' );
    foreach( $this->get_record_list() as $record )
    {
      // restrict queue based on user's role
      if( $is_top_tier )
      {
        if( !is_null( $db_restrict_site ) ) $record->set_site( $db_restrict_site );
      }
      else $record->set_site( $session->get_site() );
      
      // restrict to the current qnaire
      $record->set_qnaire( $db_restrict_qnaire );

      // restrict by language
      $modifier = lib::create( 'database\modifier' );
      if( 'any' != $restrict_language )
      {
        // english is default, so if the language is english allow null values
        if( 'en' == $restrict_language )
        {
          $modifier->where_bracket( true );
          $modifier->where( 'participant_language', '=', $restrict_language );
          $modifier->or_where( 'participant_language', '=', NULL );
          $modifier->where_bracket( false );
        }
        else $modifier->where( 'participant_language', '=', $restrict_language );
      }

      $this->add_row( $record->id,
        array( 'rank' => $record->rank,
               'enabled' => $setting_manager->get_setting(
                 'queue state', $record->name, $db_restrict_site ),
               'participant_count' => $record->get_participant_count( $modifier ),
               // I hate to put html here, but the alternative is to implement code in the
               // parent class for this ONLY instance of where we need this functionality.
               'description' => '<div class="title">'.$record->title.'</div>'.
                                '<div>'.$record->description.'</div>' ) );
    }
  }
  
  /**
   * Overrides the parent class method to only include ranked queues
   * 
   * @author Patrick Emond <emondpd@mcmaster.ca>
   * @param database\modifier $modifier Modifications to the list.
   * @return int
   * @access protected
   */
  public function determine_record_count( $modifier = NULL )
  {
    if( NULL == $modifier ) $modifier = lib::create( 'database\modifier' );
    $modifier->where( 'rank', '!=', NULL );
    $modifier->order( 'rank' );

    return parent::determine_record_count( $modifier );
  }
  
  /**
   * Overrides the parent class method since the record list depends on the active role.
   * 
   * @author Patrick Emond <emondpd@mcmaster.ca>
   * @param database\modifier $modifier Modifications to the list.
   * @return array( record )
   * @access protected
   */
  public function determine_record_list( $modifier = NULL )
  {
    if( NULL == $modifier ) $modifier = lib::create( 'database\modifier' );
    $modifier->where( 'rank', '!=', NULL );
    $modifier->order( 'rank' );

    return parent::determine_record_list( $modifier );
  }
}
?>
