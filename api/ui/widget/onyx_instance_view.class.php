<?php
/**
 * onyx_instance_view.class.php
 * 
 * @author Patrick Emond <emondpd@mcmaster.ca>
 * @package beartooth\ui
 * @filesource
 */

namespace beartooth\ui\widget;
use beartooth\log, beartooth\util;
use beartooth\business as bus;
use beartooth\database as db;
use beartooth\exception as exc;

/**
 * widget onyx_instance view
 * 
 * @package beartooth\ui
 */
class onyx_instance_view extends base_view
{
  /**
   * Constructor
   * 
   * Defines all variables which need to be set for the associated template.
   * @author Patrick Emond <emondpd@mcmaster.ca>
   * @param array $args An associative array of arguments to be processed by the widget
   * @access public
   */
  public function __construct( $args )
  {
    parent::__construct( 'onyx_instance', 'view', $args );

    // define all columns defining this record

    $this->add_item( 'site', 'constant', 'Site' );
    $this->add_item( 'interviewer_user_id', 'enum', 'Instance' );

    try
    {
      $this->user_view = util::create( 'ui\widget\user_view',
        array( 'user_view' => array( 'id' => $this->get_record()->user_id ) ) );
      $this->user_view->set_parent( $this );
      $this->user_view->set_heading( '' );
      $this->user_view->set_removable( false );
      $this->user_view->allow_reset_password( false );
      $this->user_view->allow_set_password( true );
    }
    catch( exc\permission $e )
    {
      $this->user_view = NULL;
    }
  }

  /**
   * Finish setting the variables in a widget.
   * 
   * @author Patrick Emond <emondpd@mcmaster.ca>
   * @access public
   */
  public function finish()
  {
    parent::finish();
    $session = util::create( 'business\session' );

    $db_role = db\role::get_unique_record( 'name', 'interviewer' );

    $user_mod = util::create( 'database\modifier' );
    $user_mod->where( 'site_id', '=', $this->get_record()->site_id );
    $user_mod->where( 'role_id', '=', $db_role->id );
    $interviewers = array( 'NULL' => 'site' );
    foreach( db\user::select( $user_mod ) as $db_user )
      $interviewers[$db_user->id] = $db_user->name;

    // set the view's items
    $this->set_item( 'site', $this->get_record()->get_site()->name );
    $this->set_item(
      'interviewer_user_id', $this->get_record()->interviewer_user_id, true, $interviewers );

    $this->finish_setting_items();

    if( !is_null( $this->user_view ) )
    {
      $this->user_view->finish();
      $this->set_variable( 'user_view', $this->user_view->get_variables() );
    }
  }
}
?>
