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
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Post_Announcement
 * @subpackage Post_Announcement/includes
 * @author     Jakub <Wrześniak>
 */
class Post_Announcement_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
        require_once plugin_dir_path( __FILE__ ) . 'class-post-announcement-databse-access.php';
        
        global $wpdb;
        $table_name = Post_Announcement_Database_Access::get_table_name();
        
        if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
            Post_Announcement_Activator::install_table();
            Post_Announcement_Activator::install_data();
        }
    }

    public static function install_table(){
        require_once plugin_dir_path( __FILE__ ) . 'class-post-announcement-databse-access.php';
        Post_Announcement_Database_Access::create_table();
    }

    public static function install_data(){
        require_once plugin_dir_path( __FILE__ ) . 'class-post-announcement-databse-access.php';
        Post_Announcement_Database_Access::insert_data();
    }

}