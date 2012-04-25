<?php
/**
 * assignment_end.class.php
 * 
 * @author Patrick Emond <emondpd@mcmaster.ca>
 * @package beartooth\ui
 * @filesource
 */

namespace beartooth\ui\push;
use cenozo\lib, cenozo\log, beartooth\util;

/**
 * push: assignment end
 *
 * Ends the user's current assignment.
 * @package beartooth\ui
 */
class assignment_end extends \cenozo\ui\push
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
    $session = lib::create( 'business\session' );
    $db_assignment = $session->get_current_assignment();
    if( !is_null( $db_assignment ) )
    {
      // make sure the interviewer isn't on call
      if( !is_null( $session->get_current_phone_call() ) )
        throw lib::create( 'exception\notice',
          'An assignment cannot be ended while in a call.', __METHOD__ );
      
      // if no call was made then delete the assignment
      if( 0 == $db_assignment->get_phone_call_count() )
      {
        foreach( $db_assignment->get_assignment_note_list() as $db_assignment_note )
          $db_assignment_note->delete();
        $db_assignment->delete();
      }
      else
      {
        // save the assignment's end time
        $date_obj = util::get_datetime_object();
        $db_assignment->end_datetime = $date_obj->format( 'Y-m-d H:i:s' );
        $db_assignment->save();
      }
    }
  }
}
?>
