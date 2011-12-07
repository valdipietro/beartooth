<?php
/**
 * assignment_end.class.php
 * 
 * @author Patrick Emond <emondpd@mcmaster.ca>
 * @package beartooth\ui
 * @filesource
 */

namespace beartooth\ui\push;
use beartooth\log, beartooth\util;
use beartooth\business as bus;
use beartooth\database as db;
use beartooth\exception as exc;

/**
 * push: assignment end
 *
 * Assigns a participant to an assignment.
 * @package beartooth\ui
 */
class assignment_end extends \beartooth\ui\push
{
  /**
   * Constructor.
   * @author Patrick Emond <emondpd@mcmaster.ca>
   * @param array $args Push arguments
   * @access public
   */
  public function __construct( $args )
  {
    parent::__construct( 'assignment', 'end', $args );
  }

  /**
   * Executes the push.
   * @author Patrick Emond <emondpd@mcmaster.ca>
   * @access public
   */
  public function finish()
  {
    $session = util::create( 'business\session' );
    $db_assignment = $session->get_current_assignment();
    if( !is_null( $db_assignment ) )
    {
      // make sure the interviewer isn't on call
      if( !is_null( $session->get_current_phone_call() ) )
        throw util::create( 'exception\notice',
          'An assignment cannot be ended while in a call.', __METHOD__ );
      
      // if there is an appointment associated with this assignment, set the status
      $appointment_list = $db_assignment->get_appointment_list();
      if( 0 < count( $appointment_list ) )
      {
        // there should always only be one appointment per assignment
        if( 1 < count( $appointment_list ) )
          log::crit(
            sprintf( 'Assignment %d has more than one associated appointment!',
                     $db_assignment->id ) );

        $db_appointment = current( $appointment_list );

        // set the appointment status based on whether any calls reached the participant
        $modifier = util::create( 'database\modifier' );
        $modifier->where( 'status', '=', 'contacted' );
        $db_appointment->reached = 0 < $db_assignment->get_phone_call_count( $modifier );
        $db_appointment->save();
      }

      // save the assignment's end time
      $date_obj = util::get_datetime_object();
      $db_assignment->end_datetime = $date_obj->format( 'Y-m-d H:i:s' );
      $db_assignment->save();
    }
  }
}
?>
