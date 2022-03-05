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

        if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
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
	}

	public static function insert_data($title = 'New Ad', $content = 'Your first announcement', $start_date = NULL){
		global $wpdb;
		$start_date = $start_date ? $start_date : current_time( 'mysql' );
		$table_name = Post_Announcement_Database_Access::get_table_name();
        $res = $wpdb->insert($table_name, array(
            'title' => $title,
            'content' => $content,
            'startdate' => $start_date,
            'isactive' => 0,
        ));
	}

	public static function get_table_name(){
		global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        $table_name = $wpdb->prefix . Post_Announcement_Database_Access::$base_table_name;
        return $table_name;
	}
}
?>