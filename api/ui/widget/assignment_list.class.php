<?php
/**
 * assignment_list.class.php
 * 
 * @author Patrick Emond <emondpd@mcmaster.ca>
 * @filesource
 */

namespace beartooth\ui\widget;
use cenozo\lib, cenozo\log, beartooth\util;

/**
 * widget assignment list
 */
class assignment_list extends site_restricted_list
{
  /**
   * Constructor
   * 
   * Defines all variables required by the assignment list.
   * @author Patrick Emond <emondpd@mcmaster.ca>
   * @param array $args An associative array of arguments to be processed by the widget
   * @access public
   */
  public function __construct( $args )
  {
    parent::__construct( 'assignment', $args );
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
    
    $interview_id = $this->get_argument( 'interview_id', NULL );

    $this->add_column( 'user.name', 'string', 'Operator', true );
    $this->add_column( 'site.name', 'string', 'Site', true );
    // only add the participant column if we are not restricting by interview
    if( is_null( $interview_id ) ) $this->add_column( 'uid', 'string', 'UID' );
    $this->add_column( 'calls', 'number', 'Calls' );
    $this->add_column( 'start_datetime', 'date', 'Date', true );
    $this->add_column( 'start_time', 'time', 'Start Time' );
    $this->add_column( 'end_time', 'time', 'End Time' );
    $this->add_column( 'status', 'string', 'Status' );
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
    
    foreach( $this->get_record_list() as $record )
    {
      $db_participant = $record->get_interview()->get_participant();
      $participant = sprintf( '%s, %s', $db_participant->last_name, $db_participant->first_name );
      
      // get the status of the last phone call for this assignment
      $modifier = lib::create( 'database\modifier' );
      $modifier->order_desc( 'end_datetime' );
      $modifier->limit( 1 );
      $phone_call_list = $record->get_phone_call_list( $modifier );
      $status = 0 == count( $phone_call_list ) ? 'no calls made' : $phone_call_list[0]->status;
      if( 0 == strlen( $status ) ) $status = 'in progress';

      // assemble the row for this record
      $this->add_row( $record->id,
        array( 'user.name' => $record->get_user()->name,
               'site.name' => $record->get_site()->name,
               'uid' => $db_participant->uid, // only used if not restricting by interview_id
               'calls' => $record->get_phone_call_count(),
               'start_datetime' => $record->start_datetime,
               'start_time' => $record->start_datetime,
               'end_time' => $record->end_datetime,
               'status' => $status,
               // note_count isn't a column, it's used for the note button
               'note_count' => $record->get_note_count() ) );
    }
  }

  /**
   * Overrides the parent class method since the record count depends on the active role
   * 
   * @author Patrick Emond <emondpd@mcmaster.ca>
   * @param database\modifier $modifier Modifications to the list.
   * @return int
   * @access protected
   */
  public function determine_record_count( $modifier = NULL )
  {
    if( !is_null( $this->parent ) )
    {
      if( 'interview_view' == $this->parent->get_class_name() )
      {
        // restrict the list to the interview's participant
        if( is_null( $modifier ) ) $modifier = lib::create( 'database\modifier' );
        $modifier->where(
          'assignment.interview_id', '=', $this->parent->get_record()->id );
      }
      else
      { // if this widget gets parented we need to address that parent here
        throw lib::create( 'exception\runtime',
                           'Invalid parent type '.$this->parent->get_class_name(),
                           __METHOD__ );
      }
    }

    // we may be restricting by interview
    $interview_id = $this->get_argument( 'interview_id', NULL );
    if( !is_null( $interview_id ) )
    {
      if( is_null( $modifier ) ) $modifier = lib::create( 'database\modifier' );
      $modifier->where( 'assignment.interview_id', '=', $interview_id );
    }
        
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
    if( !is_null( $this->parent ) )
    {
      if( 'interview_view' == $this->parent->get_class_name() )
      {
        // restrict the list to the interview's participant
        if( is_null( $modifier ) ) $modifier = lib::create( 'database\modifier' );
        $modifier->where(
          'assignment.interview_id', '=', $this->parent->get_record()->id );
      }
      else
      { // if this widget gets parented we need to address that parent here
        throw lib::create( 'exception\runtime',
                           'Invalid parent type '.$this->parent->get_class_name(),
                           __METHOD__ );
      }
    }

    // we may be restricting by interview
    $interview_id = $this->get_argument( 'interview_id', NULL );
    if( !is_null( $interview_id ) )
    {
      if( is_null( $modifier ) ) $modifier = lib::create( 'database\modifier' );
      $modifier->where( 'assignment.interview_id', '=', $interview_id );
    }

    return parent::determine_record_list( $modifier );
  }
}
?>
