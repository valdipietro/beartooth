<?php
/**
 * user_add.class.php
 * 
 * @author Patrick Emond <emondpd@mcmaster.ca>
 * @package beartooth\ui
 * @filesource
 */

namespace beartooth\ui\widget;
use cenozo\lib, cenozo\log, beartooth\util;

/**
 * widget user add
 * 
 * @package beartooth\ui
 */
class user_add extends \cenozo\ui\widget\user_add
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
    
    $session = lib::create( 'business\session' );
    $is_top_tier = 3 == $session->get_role()->tier;

    // create enum arrays
    $modifier = lib::create( 'database\modifier' );
    $modifier->where( 'name', '!=', 'onyx' );
    $modifier->where( 'tier', '<=', $session->get_role()->tier );
    $roles = array();
    $class_name = lib::get_class_name( 'database\role' );
    foreach( $class_name::select( $modifier ) as $db_role ) $roles[$db_role->id] = $db_role->name;
    
    // set the view's items
    $this->set_item( 'role_id', array_search( 'interviewer', $roles ), true, $roles );
  }
}
?>
