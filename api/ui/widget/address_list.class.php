<?php
/**
 * address_list.class.php
 * 
 * @author Patrick Emond <emondpd@mcmaster.ca>
 * @package beartooth\ui
 * @filesource
 */

namespace beartooth\ui\widget;
use cenozo\lib, cenozo\log, beartooth\util;

/**
 * widget address list
 * 
 * @package beartooth\ui
 */
class address_list extends \cenozo\ui\widget\base_list
{
  /**
   * Constructor
   * 
   * Defines all variables required by the address list.
   * @author Patrick Emond <emondpd@mcmaster.ca>
   * @param array $args An associative array of arguments to be processed by the widget
   * @access public
   */
  public function __construct( $args )
  {
    parent::__construct( 'address', $args );
    
    $this->add_column( 'active', 'boolean', 'Active', true );
    $this->add_column( 'available', 'boolean', 'Available', false );
    $this->add_column( 'rank', 'number', 'Rank', true );
    $this->add_column( 'city', 'string', 'City', false );
  }
  
  /**
   * Set the rows array needed by the template.
   * 
   * @author Patrick Emond <emondpd@mcmaster.ca>
   * @access public
   */
  public function finish()
  {
    parent::finish();
    
    foreach( $this->get_record_list() as $record )
    {
      // check if the address is available this month
      $month = strtolower( util::get_datetime_object( NULL, true )->format( 'F' ) );

      $db_region = $record->get_region();
      $this->add_row( $record->id,
        array( 'active' => $record->active,
               'available' => $record->$month,
               'rank' => $record->rank,
               'city' => $record->city.', '.$db_region->name ) );
    }

    $this->finish_setting_rows();
  }
}
?>
