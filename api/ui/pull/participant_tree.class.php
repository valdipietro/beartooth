<?php
/**
 * participant_tree.class.php
 * 
 * @author Patrick Emond <emondpd@mcmaster.ca>
 * @filesource
 */

namespace beartooth\ui\pull;
use cenozo\lib, cenozo\log, beartooth\util;

/**
 * pull participant tree
 */
class participant_tree extends \cenozo\ui\pull
{
  /**
   * Constructor
   * 
   * @author Patrick Emond <emondpd@mcmaster.ca>
   * @param array $args An associative array of arguments to be processed by the pull
   * @access public
   */
  public function __construct( $args )
  {
    parent::__construct( 'participant', 'tree', $args );
  }

  /**
   * This method executes the operation's purpose.
   * 
   * @author Patrick Emond <emondpd@mcmaster.ca>
   * @access protected
   */
  protected function execute()
  {
    parent::execute();

    $session = lib::create( 'business\session' );
    $is_top_tier = 3 == $session->get_role()->tier;
    $is_interviewer = 'interviewer' == $session->get_role()->name;
    
    if( $is_top_tier )
    {
      $site_id = $this->get_argument( "site_id", 0 );
      $db_site = $site_id ? lib::create( 'database\site', $site_id ) : NULL;
    }
    
    $restrict_language = $this->get_argument( 'restrict_language', 'any' );

    $current_date = util::get_datetime_object()->format( 'Y-m-d' );
    $viewing_date = $this->get_argument( 'viewing_date', 'current' );
    if( $current_date == $viewing_date ) $viewing_date = 'current';

    // set the viewing date if it is not "current"
    $queue_class_name = lib::get_class_name( 'database\queue' );
    $qnaire_class_name = lib::get_class_name( 'database\qnaire' );
    if( 'current' != $viewing_date ) $queue_class_name::set_viewing_date( $viewing_date );

    // get the participant count for every node in the tree
    $this->data = array();
    foreach( $queue_class_name::select() as $db_queue )
    {
      // restrict by language
      // Note: a new queue mod needs to be created for every iteration of the loop
      $participant_mod = lib::create( 'database\modifier' );
      if( 'any' != $restrict_language )
      {
        // english is default, so if the language is english allow null values
        if( 'en' == $restrict_language )
        {
          $participant_mod->where_bracket( true );
          $participant_mod->where( 'participant_language', '=', $restrict_language );
          $participant_mod->or_where( 'participant_language', '=', NULL );
          $participant_mod->where_bracket( false );
        }
        else $participant_mod->where( 'participant_language', '=', $restrict_language );
      }

      // restrict queue based on user's role
      if( !$is_top_tier ) $db_queue->set_site( $session->get_site() );
      else if( !is_null( $db_site ) ) $db_queue->set_site( $db_site );
      
      // handle queues which are not qnaire specific
      if( !$db_queue->qnaire_specific )
      {
        $index = sprintf( '%d_%d', 0, $db_queue->id );
        $this->data[$index] = $db_queue->get_participant_count( $participant_mod );
      }
      else // handle queues which are qnaire specific
      {
        foreach( $qnaire_class_name::select() as $db_qnaire )
        {
          $db_queue->set_qnaire( $db_qnaire );
          $index = sprintf( '%d_%d', $db_qnaire->id, $db_queue->id );
          $this->data[$index] = $db_queue->get_participant_count( $participant_mod );
        }
      }
    }
  }

  /**
   * Sets the data type.
   * 
   * @author Patrick Emond <emondpd@mcmaster.ca>
   * @return string
   * @access public
   */
  public function get_data_type() { return "json"; }
}
?>
