<?php
	/**
	 * 
	 */
	class Post_Announcement_List extends WP_List_Table
	{

		function __construct() {
			global $status, $page;
			parent::__construct(
			array(
				'singular'	=> 'announcement',
				'plural'	=> 'announcements',
				'ajax'		=> true
			)
		);
		
	}

		public function get_columns() {
		  	$columns= array(
		       'name'=>__('Name', $this->plugin_text_domain),
		       'content'=>__('Content', $this->plugin_text_domain),
		       'startdate'=>__('Start Date', $this->plugin_text_domain),
		       'enddate'=>__('End date', $this->plugin_text_domain),
		       'isactive'=>__('Is active', $this->plugin_text_domain),
		       'action'=>__('', $this->plugin_text_domain),
		    );

		    return $columns;
		}

		public function get_sortable_columns() {
		    return $sortable = array(
		       'name'=>'title',
		       'startdate'=>'startdate',
		       'enddate'=>'enddate',
		       'isactive'=>'isactive'
		    );
		 }

		public function no_items() {
			_e( 'No announcement avaliable.', $this->plugin_text_domain );
		}

  		public function prepare_items() {

  			$search_key = isset( $_REQUEST['s'] ) ? wp_unslash( trim( $_REQUEST['s'] ) ) : '';

  		  	$this->_column_headers = $this->get_column_info();		

  		  	$this->handle_table_actions();

  		  	$table_data = $this->fetch_table_data();

  		  	if( $search_key ) {
				$table_data = $this->filter_table_data( $table_data, $search_key );
			}	

      	    $this->items = $table_data;

      	    $announcement_per_page = $this->get_items_per_page( 'announcement_per_page' );
			$table_page = $this->get_pagenum();
			$this->items = array_slice( $table_data, ( ( $table_page - 1 ) * $announcement_per_page ), $announcement_per_page );

			$total_announcement = count( $table_data );
			$this->set_pagination_args( array (
				'total_items' => $total_announcement,
				'per_page'    => $announcement_per_page,
				'total_pages' => ceil( $total_announcement/$announcement_per_page )
			) );

  		}

  		public function fetch_table_data(){
  			 require_once plugin_dir_path( __FILE__ ) . '/../includes/class-post-announcement-databse-access.php';
		 	 $orderby = ( isset( $_GET['orderby'] ) ) ? esc_sql( $_GET['orderby'] ) : '';
       		 $order = ( isset( $_GET['order'] ) ) ? esc_sql( $_GET['order'] ) : 'ASC';
      		 return Post_Announcement_Database_Access::get_table_rows($orderby, $order);
		}

		public function column_default( $item, $column_name ) {		
		 	switch ( $column_name ) {			
		 		case 'name':
		 			return $item['title'];
		 		case 'content':
		 		case 'startdate':
		 		case 'enddate':
		 			return $item[$column_name];
		 		case 'isactive':
		 			return $item[$column_name] ? 'true' : 'false';
		 		case 'action':
		 			return column_action( $item );
		 		default:
		 		  return $item[$column_name];
		 	}
		}

		public function column_action( $item ){
			$edit_link = admin_url( 'admin.php?page=post-announcement-add&amp;action=edit&amp;id=' . $item['id']);
			$output = '';
			$actions = array(
				'edit' => '<a href="' . esc_url( $edit_link ) . '">' . esc_html__('Edit', $this->plugin_text_domain) . '</a>', 
				'delete' => '<a href="#" data-id="' . $item['id'] . '" data-nonce="' . wp_create_nonce( 'announcement_delete_nonce' ) . '" class="an-delete" >' . esc_html__('Delete', $this->plugin_text_domain) . '</a>',
			);
			$row_actions = array();
			foreach ( $actions as $action => $link ) {
           		$row_actions[] = '<span class="' . esc_attr( $action ) . '">' . $link . '</span>';
        	}
        	$output .= '<div class="row-actions">' . implode( ' | ', $row_actions ) . '</div>';
        	return $output;
		}

		public function filter_table_data( $table_data, $search_key ) {
			$filtered_table_data = array_values( array_filter( $table_data, function( $row ) use( $search_key ) {
				foreach( $row as $row_val ) {
					if( stripos( $row_val, $search_key ) !== false ) {
						return true;
					}				
				}			
			} ) );
			return $filtered_table_data;
		}
}
?>