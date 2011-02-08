<?php
/**
 * site.class.php
 * 
 * @author Patrick Emond <emondpd@mcmaster.ca>
 * @package sabretooth\database
 * @filesource
 */

namespace sabretooth\database;

/**
 * site: active record
 *
 * @package sabretooth\database
 */
class site extends active_record
{
  /**
   * Select a number of records.
   * 
   * This method overrides its parent method by adding functionality to sort the list by elements
   * outside of the site's table columns.
   * Currently sites can be ordered by: activity.date
   * @author Patrick Emond <emondpd@mcmaster.ca>
   * @param int $count The number of records to return
   * @param int $offset The 0-based index of the first record to start selecting from
   * @param string $sort_column Which column to sort by during the select.
   * @param boolean $descending Whether to sort descending or ascending.
   * @param array $restrictions And array of restrictions to add to the were clause of the select.
   * @return array( active_record )
   * @static
   * @access public
   */
  public static function select(
    $count = 0, $offset = 0, $sort_column = NULL, $descending = false, $restrictions = NULL )
  {
    // no need to override the basic functionality
    if( 'activity.date' != $sort_column )
    {
      return parent::select( $count, $offset, $sort_column, $descending, $restrictions );
    }

    // create special sql that sorts by the foreign column association
    $records = array();

    // build the where
    $where = '';
    if( is_array( $restrictions ) && 0 < count( $restrictions ) )
    {
      $first = true;
      $where = 'WHERE ';
      foreach( $restrictions as $column => $value )
      {
        $where .= sprintf( '%s %s = %d',
                           $first ? '' : 'AND',
                           $column,
                           self::format_string( $value ) );
        $first = false;
      }
    }
    
    // build the order
    $order = '';
    if( !is_null( $sort_column ) )
    {
      $order = sprintf( 'ORDER BY %s %s',
                        $sort_column,
                        $descending ? 'DESC' : '' );
    }
   
    // build the limit
    $limit = '';
    if( 0 < $count )
    {
      $limit = sprintf( 'LIMIT %d OFFSET %d',
                        $count,
                        $offset );
    }

    // sort by activity date
    if( 'activity.date' == $sort_column )
    {
      $id_list = self::get_col(
        sprintf( 'SELECT site.id '.
                 'FROM %s '.
                 'LEFT JOIN site_last_activity '.
                 'ON site.id = site_last_activity.site_id '.
                 'LEFT JOIN activity '.
                 'ON site_last_activity.activity_id = activity.id '.
                 '%s %s %s',
                 self::get_table_name(),
                 $where,
                 $order,
                 $limit ) );
    }

    foreach( $id_list as $id )
    {
      array_push( $records, new static( $id ) );
    }

    return $records;
  }

  /**
   * Returns the most recent activity performed to this site.
   * 
   * @author Patrick Emond <emondpd@mcmaster.ca>
   * @return database\activity
   * @access public
   */
  public function get_last_activity()
  {
    $activity_id = self::get_one(
      sprintf( 'SELECT activity_id FROM site_last_activity WHERE site_id = %s',
               self::format_string( $this->id ) ) );

    return is_null( $activity_id ) ? NULL : new activity( $activity_id );
  }

  /**
   * Get the number of activity entries for this site.
   * 
   * @author Patrick Emond <emondpd@mcmaster.ca>
   * @return int
   * @access public
   */
  public function get_activity_count()
  {
    if( is_null( $this->id ) )
    {
      \sabretooth\log::warning( 'Tried to query site record with no id.' );
      return 0;
    }

    return self::get_one(
      sprintf( 'SELECT COUNT( DISTINCT id ) FROM activity WHERE site_id = %s',
               self::format_string( $this->id ) ) );
  }

  /**
   * Get an activity list for this site.
   * 
   * @author Patrick Emond <emondpd@mcmaster.ca>
   * @param int $count The number of activities to return
   * @param int $offset The number of activities to offset the selection by.
   * @param string $sort_column The name of a column to sort by.
   * @param boolean $descending Whether to sort in descending order.
   * @return array( database\activity )
   * @access public
   */
  public function get_activity_list( $count = 0, $offset = 0, $sort_column = NULL, $descending = false )
  {
    $activity_list = array();
    if( is_null( $this->id ) )
    {
      \sabretooth\log::warning( 'Tried to query site record with no id.' );
      return $activity_list;
    }

    // build the order
    $order = '';
    if( !is_null( $sort_column ) )
    {
      $order = sprintf( 'ORDER BY %s %s',
                        $sort_column,
                        $descending ? 'DESC' : '' );
    }
   
    // build the limit
    $limit = '';
    if( 0 < $count )
    {
      $limit = sprintf( 'LIMIT %d OFFSET %d',
                        $count,
                        $offset );
    }

    $ids = self::get_col(
      sprintf( 'SELECT activity.id '.
               'FROM activity, user, site, role, operation '.
               'WHERE activity.user_id = user.id '.
               'AND activity.site_id = site.id '.
               'AND activity.role_id = role.id '.
               'AND activity.operation_id = operation.id '.
               'AND activity.site_id = %s '.
               '%s %s',
               self::format_string( $this->id ),
               $order,
               $limit ) );

    foreach( $ids as $id ) array_push( $activity_list, new activity( $id ) );
    return $activity_list;
  }

  /**
   * Get the number of users that have access to this site.
   * 
   * @author Patrick Emond <emondpd@mcmaster.ca>
   * @return int
   * @access public
   */
  public function get_user_count()
  {
    if( is_null( $this->id ) )
    {
      \sabretooth\log::warning( 'Tried to query site record with no id.' );
      return 0;
    }

    return self::get_one(
      sprintf( 'SELECT COUNT( DISTINCT user_id ) FROM user_access WHERE site_id = %s',
               self::format_string( $this->id ) ) );
  }

  /**
   * Get a list of users that have access to this site.
   * 
   * @author Patrick Emond <emondpd@mcmaster.ca>
   * @param int $count The number of users to return
   * @param int $offset The number of users to offset the selection by.
   * @param string $sort_column The name of a column to sort by.
   * @param boolean $descending Whether to sort in descending order.
   * @return array( database\user )
   * @access public
   */
  public function get_user_list( $count = 0, $offset = 0, $sort_column = NULL, $descending = false )
  {
    $users = array();
    if( is_null( $this->id ) )
    {
      \sabretooth\log::warning( 'Tried to query site record with no id.' );
      return $users;
    }

    // build the order
    $order = '';
    if( !is_null( $sort_column ) )
    {
      $order = sprintf( 'ORDER BY %s %s',
                        $sort_column,
                        $descending ? 'DESC' : '' );
    }
   
    // build the limit
    $limit = '';
    if( 0 < $count )
    {
      $limit = sprintf( 'LIMIT %d OFFSET %d',
                        $count,
                        $offset );
    }

    $ids = self::get_col(
      sprintf( 'SELECT user_access.user_id '.
               'FROM user_access, user '.
               'LEFT JOIN user_last_activity '.
               'ON user.id = user_last_activity.user_id '.
               'LEFT JOIN activity '.
               'ON user_last_activity.activity_id = activity.id '.
               'WHERE user_access.user_id = user.id '.
               'AND user_access.site_id = %s '.
               'GROUP BY user_access.user_id '.
               '%s %s',
               self::format_string( $this->id ),
               $order,
               $limit ) );

    foreach( $ids as $id ) array_push( $users, new user( $id ) );
    return $users;
  }
}
?>
