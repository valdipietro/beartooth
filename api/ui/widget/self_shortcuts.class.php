<?php
/**
 * self_shortcuts.class.php
 * 
 * @author Patrick Emond <emondpd@mcmaster.ca>
 * @filesource
 */

namespace beartooth\ui\widget;
use cenozo\lib, cenozo\log, beartooth\util;

/**
 * widget self shortcuts
 */
class self_shortcuts extends \cenozo\ui\widget\self_shortcuts
{
  /**
   * Sets up the operation with any pre-execution instructions that may be necessary.
   * 
   * @author Patrick Emond <emondpd@mcmaster.ca>
   * @access protected
   */
  protected function setup()
  {
    parent::setup();

    $setting_manager = lib::create( 'business\setting_manager' );
    $voip_manager = lib::create( 'business\voip_manager' );
    
    $voip_enabled = $setting_manager->get_setting( 'voip', 'enabled' );
    
    // get the xor key and make sure it is at least as long as the password
    $xor_key = $setting_manager->get_setting( 'voip', 'xor_key' );
    $password = $_SERVER['PHP_AUTH_PW'];

    // avoid infinite loops by using a counter
    $counter = 0;
    while( strlen( $xor_key ) < strlen( $password ) )
    {
      $xor_key .= $xor_key;
      if( 1000 < $counter++ ) break;
    }
    
    $this->set_variable( 'webphone_parameters', sprintf(
      'username=%s&password=%s',
      $_SERVER['PHP_AUTH_USER'],
      base64_encode( $password ^ $xor_key ) ) );
    $this->set_variable( 'webphone', $voip_enabled && !$voip_manager->get_sip_enabled() );
    $this->set_variable( 'dialpad', !is_null( $voip_manager->get_call() ) );
    $this->set_variable( 'calculator', true );
    $this->set_variable( 'timezone_calculator', true );
  }
}
?>
