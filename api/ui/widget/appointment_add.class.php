<?php
/**
 * appointment_add.class.php
 * 
 * @author Patrick Emond <emondpd@mcmaster.ca>
 * @package beartooth\ui
 * @filesource
 */

namespace beartooth\ui\widget;
use cenozo\lib, cenozo\log, beartooth\util;

/**
 * widget appointment add
 * 
 * @package beartooth\ui
 */
class appointment_add extends base_appointment_view
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
    parent::__construct( 'add', $args );

    // only interviewers should select addresses
    $this->select_address = 'interviewer' == lib::create( 'business\session' )->get_role()->name;
    
    // add items to the view
    $this->add_item( 'participant_id', 'hidden' );
    if( $this->select_address ) $this->add_item( 'address_id', 'enum', 'Address' );
    $this->add_item( 'datetime', 'datetime', 'Date' );
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
    
    // this widget must have a parent, and it's subject must be a participant
    if( is_null( $this->parent ) || 'participant' != $this->parent->get_subject() )
      throw lib::create( 'exception\runtime',
        'Appointment widget must have a parent with participant as the subject.', __METHOD__ );

    $session = lib::create( 'business\session' );
    $is_interviewer = 'interviewer' == $session->get_role()->name;
    $db_participant = lib::create( 'database\participant', $this->parent->get_record()->id );
    
    // create enum arrays
    $modifier = lib::create( 'database\modifier' );
    $modifier->where( 'active', '=', true );
    $modifier->order( 'rank' );

    if( $is_interviewer )
      foreach( $db_participant->get_address_list( $modifier ) as $db_address )
        $address_list[$db_address->id] = sprintf(
          '%s, %s, %s, %s',
          $db_address->address2 ? $db_address->address1.', '.$db_address->address2
                                : $db_address->address1,
          $db_address->city,
          $db_address->get_region()->abbreviation,
          $db_address->postcode );
    
    // create the min datetime array
    $start_qnaire_date = $this->parent->get_record()->start_qnaire_date;
    $datetime_limits = !is_null( $start_qnaire_date )
                     ? array( 'min_date' => substr( $start_qnaire_date, 0, -9 ) )
                     : NULL;

    // set the view's items
    $this->set_item( 'participant_id', $this->parent->get_record()->id );
    if( $this->select_address )
      $this->set_item( 'address_id', key( $address_list ), true, $address_list, true );
    $this->set_item( 'datetime', '', true, $datetime_limits );
    
    $this->set_variable( 'is_mid_tier', 2 == $session->get_role()->tier );

    $this->finish_setting_items();
  }
  
  /**
   * Determines whether to allow the user to select an address for the appointment.
   * @var boolean $select_address
   * @access protected
   */
  protected $select_address = false;
}
?>
