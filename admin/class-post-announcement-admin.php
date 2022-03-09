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
		$params = array ( 'ajaxurl' => admin_url( 'admin-ajax.php' ) );
		wp_enqueue_script( 'ps_ajax_handle', plugin_dir_url( __FILE__ ) . 'js/post-announcement-admin-ajax-hendler.js', array( 'jquery' ), $this->version, false );				
		wp_localize_script( 'ps_ajax_handle', 'params', $params );

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/post-announcement-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register the settings page for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function register_management_page() {
		// Create our setup page.
		$main_page_hook = add_menu_page( 
			__( 'Post Announcement', $this->plugin_text_domain),
			__( 'Post Announcement', $this->plugin_text_domain),
			'manage_options', 
			$this->plugin_name, 
			array( $this, 'display_management_page') 
		);

		add_submenu_page(
			$this->plugin_name,
			__( 'Add new',  $this->plugin_text_domain),
			__( 'Add new',  $this->plugin_text_domain),
			'manage_options',
			$this->plugin_name.'-add',
			array( $this, 'display_new_announcement_page')
		);

		add_action( 'load-'.$main_page_hook, array( $this, 'load_announcement_list_table_screen_options' ) );
	}

	/**
	 * Display the settings page content for the page we have created.
	 *
	 * @since    1.0.0
	 */
	public function display_management_page() {
		$this->announcement_list_table->prepare_items();
		include_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/post-announcement-admin-display.php';

	}


  	public function load_announcement_list_table_screen_options() {
  		require_once plugin_dir_path( __FILE__ ) . 'class-post-announcement-admin-list.php';
		$arguments = array(
					'label'		=>	__( 'Announcement Per Page', $this->plugin_text_domain ),
					'default'	=>	5,
					'option'	=>	'announcement_per_page'
		);

		add_screen_option( 'per_page', $arguments );
		$this->announcement_list_table = new Post_Announcement_List( $this->plugin_text_domain );		
	}

	public function display_new_announcement_page(){
		include_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/post-announcement-admin-an-form.php';
	}

	public function handle_announcement_post_action(){
		if ( isset( $_POST[ 'announcement_add_nonce' ] ) && wp_verify_nonce( $_POST['announcement_add_nonce'], 'announcement_form_nonce') ) {
			$pa_id = sanitize_text_field( $_POST['pa']['id']);
			$pa_title = sanitize_text_field( $_POST['pa']['title']);
			//$pa_content = wp_kses( $_POST['pa']['content'], wp_kses_allowed_html());
			$pa_content = $_POST['pa']['content'];
			$pa_startdate = sanitize_text_field( $_POST['pa']['startdate']);
		    $pa_startdate = filter_var( $pa_startdate, FILTER_SANITIZE_STRING);
			$pa_enddate = sanitize_text_field( $_POST['pa']['enddate']);
			$pa_enddate = filter_var( $pa_enddate, FILTER_SANITIZE_STRING);
			$is_active =  isset($_POST['pa']['isactive']) ? intval($_POST['pa']['isactive']) : 0;
			require_once plugin_dir_path( __FILE__ ) . '/../includes/class-post-announcement-databse-access.php';
			if( !empty( $pa_id ) ){
				Post_Announcement_Database_Access::update_row($id = intval($pa_id), $title = $pa_title, $pa_content, $pa_startdate, $pa_enddate, $is_active);
			} else {
				Post_Announcement_Database_Access::insert_data($pa_title, $pa_content, $pa_startdate, $pa_enddate, $is_active);
			}

			$admin_notice = "success";
			//$this->custom_redirect( $admin_notice, $_POST );
			wp_redirect( '"'.home_url().'/wp-admin/admin.php?page=post-announcement"', 301 );
			exit;
		} else {
			wp_die( __( 'Invalid nonce specified', $this->plugin_name ), __( 'Error', $this->plugin_name ), array(
						'response' 	=> 403,
						'back_link' => 'admin.php?page=' . $this->plugin_name,

				) );
		}
	}

	public function handle_announcement_post_delete(){
		//$permission = check_ajax_referer( 'announcement_delete_nonce', 'nonce', false );
		//if( $permission == false ) {
		//	echo 'error';
		//}
		//else {
			require_once plugin_dir_path( __FILE__ ) . '/../includes/class-post-announcement-databse-access.php';
			Post_Announcement_Database_Access::delete_row( $_REQUEST['id'] );
			echo 'success';
		//}
		die();
	}

}
