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
		$end_date = date('Y-m-d H:i:s', strtotime("+7 days"));
		$table_name = Post_Announcement_Database_Access::get_table_name();
        $res = $wpdb->insert($table_name, array(
            'title' => $title,
            'content' => $content,
            'startdate' => $start_date,
            'enddate' => $end_date,
            'isactive' => $isactive,
        ));
	}

	public static function update_row($id, $title = NULL, $content = NULL, $start_date = NULL, $end_date = NULL, $isactive = NULL){
		global $wpdb;
		$update_array = array();
		if (isset($title)){$update_array['title'] = $title;};
		if (isset($content)){$update_array['content'] = $content;};
		if (isset($start_date)){$update_array['startdate'] = $start_date;};
		if (isset($end_date)){$update_array['enddate'] = $end_date;};
		if (isset($isactive)){$update_array['isactive'] = $isactive;};
		$table_name = Post_Announcement_Database_Access::get_table_name();
		$wpdb->update($table_name, $update_array, array('id'=>$id));
	}

	public static function delete_row($id){
		global $wpdb;
		$table_name = $wpdb->prefix . Post_Announcement_Database_Access::$base_table_name;
		return $wpdb->delete($table_name, array('id'=>$id), array( '%d' ));
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

	public static function get_row( $id ){
		global $wpdb;
		$table_name = Post_Announcement_Database_Access::get_table_name();
		$sql = "SELECT * FROM $table_name WHERE id LIKE $id";
		$res = $wpdb->get_results($sql, ARRAY_A);
		return empty($res) ? NULL : $res[0]; 
	}

	public static function get_number_of_rows(){
		global $wpdb;
		$table_name = Post_Announcement_Database_Access::get_table_name();
		$sql = "SELECT * FROM $table_name";
		return $wpdb->query($sql);
	}

	public static function get_active_announcement_in_date($date){
		global $wpdb;
		$table_name = Post_Announcement_Database_Access::get_table_name();
		$sql = "SELECT id, title, content FROM $table_name WHERE startdate < \"$date\" AND enddate > \"$date\" AND isactive LIKE 1";
		$res = $wpdb->get_results($sql, ARRAY_A);
		return $res;
	}
}
?>