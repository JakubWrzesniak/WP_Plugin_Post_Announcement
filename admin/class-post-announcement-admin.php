<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/JakubWrzesniak
 * @since      1.0.0
 *
 * @package    Post_Announcement
 * @subpackage Post_Announcement/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Post_Announcement
 * @subpackage Post_Announcement/admin
 * @author     Jakub <Wrześniak>
 */
class Post_Announcement_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Post_Announcement_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Post_Announcement_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		if ( 'tools_page_post_announcement' != $hook ) {
			return;
		}
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/post-announcement-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Post_Announcement_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Post_Announcement_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		if ( 'tools_page_post_announcement' != $hook ) {
			return;
		}
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/post-announcement-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register the settings page for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function register_management_page() {
		// Create our setup page.
		add_menu_page( 'Post Announcement Page', 'Announcement', 'manage_options', 'post-announcement', array( $this, 'display_management_page') );
	}

	/**
	 * Display the settings page content for the page we have created.
	 *
	 * @since    1.0.0
	 */
	public function display_management_page() {

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/post-announcement-admin-display.php';

	}

}
