<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/JakubWrzesniak
 * @since      1.0.0
 *
 * @package    Post_Announcement
 * @subpackage Post_Announcement/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Post_Announcement
 * @subpackage Post_Announcement/public
 * @author     Jakub <Wrześniak>
 */
class Post_Announcement_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/post-announcement-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/post-announcement-public.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name.'_ap', plugin_dir_url( __FILE__ ) . 'js/post-announcement-public-ap-container.js', array( 'jquery' ), $this->version, true );
		$this->load_announcement();
	}


	public function load_announcement(){
		if('post' == get_post_type()){
			require_once plugin_dir_path( __FILE__ ) . '/../includes/class-post-announcement-databse-access.php';
			$res = Post_Announcement_Database_Access::get_active_announcement_in_date( current_time( 'mysql' ) );
			if(!empty($res)){
				shuffle($res);
				$announce = $res[0];
				wp_localize_script( $this->plugin_name.'_ap', 'php_vars', 
				  	array( 
						'pa_title' => $announce['title'],
						'pa_content' => $announce['content'],
					) 
				 );
			}
		}
	}	

}
