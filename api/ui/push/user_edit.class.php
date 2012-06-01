<?php
/**
 * user_edit.class.php
 * 
 * @author Patrick Emond <emondpd@mcmaster.ca>
 * @package beartooth\ui
 * @filesource
 */

namespace beartooth\ui\push;
use cenozo\lib, cenozo\log, beartooth\util;

/**
 * push: user edit
 *
 * Edit a user.
 * @package beartooth\ui
 */
class user_edit extends \cenozo\ui\push\user_edit
{
  /**
   * Processes arguments, preparing them for the operation.
   * 
   * @author Patrick Emond <emondpd@mcmaster.ca>
   * @access protected
   */
  protected function prepare()
  {
    parent::prepare();

    $this->set_machine_request_enabled( true );
    $this->set_machine_request_url( MASTODON_URL );

    // don't call the parent method if the request came from mastodon
    if( 'mastodon' != $this->get_machine_application_name() ) $this->set_validate_access( false );
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

    $columns = $this->get_argument( 'columns', array() );

    // don't send information 
    if( array_key_exists( 'language', $columns ) ) 
      $this->set_machine_request_enabled( false );
  }
}
?>
