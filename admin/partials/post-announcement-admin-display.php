<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/JakubWrzesniak
 * @since      1.0.0
 *
 * @package    Post_Announcement
 * @subpackage Post_Announcement/admin/partials
 */
?>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">    
    <h2><?php _e('Post Announcement', $this->plugin_text_domain); ?></h2>
        <div id="post-announcement-list-table">           
            <div id="post-announcement-post-body">        
                <form id="post-announcement-list-form" method="get"> 
                <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />                
                    <?php 
                        $this->announcement_list_table->search_box( __( 'Find', $this->plugin_text_domain ), 'post-announcement-find');
                        $this->announcement_list_table->display(); 
                    ?>                 
                </form>
            </div>          
        </div>
</div>