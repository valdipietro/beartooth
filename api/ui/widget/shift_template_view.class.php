<?php
/**
 * shift_template_view.class.php
 * 
 * @author Patrick Emond <emondpd@mcmaster.ca>
 * @filesource
 */

namespace beartooth\ui\widget;
use cenozo\lib, cenozo\log, beartooth\util;

/**
 * widget shift_template view
 */
class shift_template_view extends \cenozo\ui\widget\base_view
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
    parent::__construct( 'shift_template', 'view', $args );
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
    
    // add items to the view
    $this->add_item( 'start_time', 'time', 'Start Time' );
    $this->add_item( 'end_time', 'time', 'End Time' );
    $this->add_item( 'start_date', 'date', 'Start Date' );
    $this->add_item( 'end_date', 'date', 'End Date' );
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

    $this->set_variable( 'repeats',
      'weekly' == $this->get_record()->repeat_type ? 'weekly' : 'monthly' );
    $this->set_variable( 'repeat_by',
      'day of week' == $this->get_record()->repeat_type ? 'week' : 'month' );
    $this->set_variable( 'repeat_every', $this->get_record()->repeat_every );
    $this->set_variable( 'monday', $this->get_record()->monday );
    $this->set_variable( 'tuesday', $this->get_record()->tuesday );
    $this->set_variable( 'wednesday', $this->get_record()->wednesday );
    $this->set_variable( 'thursday', $this->get_record()->thursday );
    $this->set_variable( 'friday', $this->get_record()->friday );
    $this->set_variable( 'saturday', $this->get_record()->saturday );
    $this->set_variable( 'sunday', $this->get_record()->sunday );

    // set the view's items
    $this->set_item( 'start_time', $this->get_record()->start_time, true );
    $this->set_item( 'end_time', $this->get_record()->end_time, true );
    $this->set_item( 'start_date', $this->get_record()->start_date, true );
    $this->set_item( 'end_date', $this->get_record()->end_date, false );
  }
}
?>
