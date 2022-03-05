<?php
	/**
	 * 
	 */
	class Post_Announcement_List extends WP_List_Table
	{
		
		function __construct()
		{
			 parent::__construct( array(
		      'singular'=> 'wp_list_text_link', //Singular label
		      'plural' => 'wp_list_test_links', //plural label, also this well be one of the table css class
		      'ajax'   => false //We won't support Ajax for this table
		      ) );
		}

		/**
		 * Define the columns that are going to be used in the table
		 * @return array $columns, the array of columns to use with the table
		 */
		function get_columns() {
		   return $columns= array(
		      'col_ad_name'=>__('Name'),
		      'col_ad_content'=>__('Announcement'),
		      'col_ad_startdate'=>__('Start Date'),
		      'col_ad_enddate'=>__('End date'),
		      'col_ad_isactive'=>__('Is Active')
		   );
		}
	}
?>