<?php
/**
 * participant_withdraw.class.php
 * 
 * @author Patrick Emond <emondpd@mcmaster.ca>
 * @filesource
 */

namespace beartooth\ui\push;
use cenozo\lib, cenozo\log, beartooth\util;

/**
 * push: participant withdraw
 *
 * Edit a participant.
 */
class participant_withdraw extends \cenozo\ui\push\base_record
{
  /**
   * Constructor.
   * @author Patrick Emond <emondpd@mcmaster.ca>
   * @param array $args Push arguments
   * @access public
   */
  public function __construct( $args )
  {
    parent::__construct( 'participant', 'withdraw', $args );
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

    if( $this->get_argument( 'cancel', false ) )
    { // if the most recent consent is a withdraw, remove it
      $consent_mod = lib::create( 'database\modifier' );
      $consent_mod->order_desc( 'date' );
      $consent_mod->limit( 1 );
      $db_consent = current( $this->get_record()->get_consent_list( $consent_mod ) );
      if( $db_consent && 'withdraw' == $db_consent->event )
      {
        // apply the change using an operation (so that Mastodon is also updated)
        $operation = lib::create( 'ui\push\consent_delete', array( 'id' => $db_consent->id ) );
        $operation->process();
      }
      else throw lib::create( 'exception\runtime',
        sprintf( 'Trying to cancel withdraw for participant id %d but most recent consent is not '.
                 'a withdraw.', $this->get_record()->id ), __METHOD__ );
    }
    else
    { // add a new withdraw consent to the participant
      // apply the change using an operation (so that Mastodon is also updated)
      $args = array(
        'columns' => array(
          'participant_id' => $this->get_record()->id,
          'event' => 'withdraw',
          'date' => util::get_datetime_object()->format( 'Y-m-d' ),
          'note' => 'Automatically added by the "withdraw" button.' ) );
      $operation = lib::create( 'ui\push\consent_new', $args );
      $operation->process();
    }
  }
}
?>
