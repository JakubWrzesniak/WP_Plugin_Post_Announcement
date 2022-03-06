<?php
/**
 * Fired during plugin activation
 *
 * @link       https://github.com/JakubWrzesniak
 * @since      1.0.0
 *
 * @package    Post_Announcement
 * @subpackage Post_Announcement/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to manage database;
 *
 * @since      1.0.0
 * @package    Post_Announcement
 * @subpackage Post_Announcement/includes
 * @author     Jakub <Wrześniak>
 */
class Post_Announcement_Database_Access {
	public static $base_table_name = "postAnnouncement";

	public static function create_table()
	{
		global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        $table_name = Post_Announcement_Database_Access::get_table_name();
	        $sql = "CREATE TABLE $table_name ( 
	            id mediumint(9) NOT NULL AUTO_INCREMENT,
	            title varchar(40) NOT NULL,
	            content varchar(400) NOT NULL,
	            startdate datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
	            enddate datetime,
	            isactive tinyint(1) ZEROFILL NOT NULL,
	            PRIMARY KEY  (id)
	            ) $charset_collate;";
	            
	        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	        dbDelta( $sql );
	}

	public static function insert_data($title = 'New Ad', $content = 'Your first announcement', $start_date = NULL, $end_date = NULL, $isactive = 0){
		global $wpdb;
		$start_date = $start_date ? $start_date : current_time( 'mysql' );
		$table_name = Post_Announcement_Database_Access::get_table_name();
        $res = $wpdb->insert($table_name, array(
            'title' => $title,
            'content' => $content,
            'startdate' => $start_date,
            'enddate' => $end_date,
            'isactive' => $isactive,
        ));
	}

	public static function get_table_name(){
		global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        $table_name = $wpdb->prefix . Post_Announcement_Database_Access::$base_table_name;
        return $table_name;
	}

	public static function get_table_rows($orderby = NULL, $order = NULL){
		global $wpdb;
		$table_name = Post_Announcement_Database_Access::get_table_name();
		$sql = "SELECT * FROM $table_name";

		if(!empty($orderby) & !empty($order)){
			$sql.=' ORDER BY '.$orderby.' '.$order; 
		}
		return $wpdb->get_results($sql, ARRAY_A);
	}

	public static function get_number_of_rows(){
		global $wpdb;
		$table_name = Post_Announcement_Database_Access::get_table_name();
		$sql = "SELECT * FROM $table_name";
		return $wpdb->query($sql);
	}
}
?>