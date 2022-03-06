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
<?php 
    if( current_user_can( 'edit_users' ) ) {    
    $announcement_add_nonce = wp_create_nonce( 'announcement_form_nonce' ); 
?>
    <!-- This file should primarily consist of HTML with a little bit of PHP. -->
    <div class="wrap">    
        <h2><?php _e('Add new announcement', $this->plugin_text_domain); ?></h2>
            <div id="post-announcement-list-table">           
                <div id="post-announcement-post-body">   
                    <table>
                        <tbody> 
                            <form id="new-announcement-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post"> 
                                <input type="hidden" name="<?php echo "pa"; ?>[id]" id="an_id" disabled>
                                <input type="hidden" name="action" value="announcement_form_response">
                                <input type="hidden" name="announcement_add_nonce" value="<?php echo $announcement_add_nonce ?>" />    
                                <tr>
                                    <td><label for="title">Name: </label></td>
                                    <td><input required type="text" name="<?php echo "pa"; ?>[title]" id="title"></td>
                                </tr>
                                <tr>
                                    <td><label for="content">Content: </label></td>
                                    <td><textarea name="<?php echo "pa"; ?>[content]" id="content" rows="3" cols="50"> </textarea></td>
                                </tr>
                                <tr>
                                    <td><label for="startdate">Start Date: </label></td>
                                    <td><input required type="datetime-local" name="<?php echo "pa"; ?>[startdate]" id="startdate"></td>
                                </tr>
                                <tr>
                                    <td><label for="enddate">End date: </label></td>
                                    <td><input type="datetime-local" name="<?php echo "pa"; ?>[enddate]" id="enddate"></td>    
                                </tr>   
                                <tr>
                                    <td/>
                                    <td><input id="submit" class="button button-primary" type="submit" name="submit"></td>  
                                </tr> 
                            </form>
                        </tbody>
                    </table>
                    <br/><br/>
                    <div id="nds_form_feedback"></div>
                    <br/><br/>
                </div>          
            </div>
    </div>
<?php    
}
else {  
?>
    <p> <?php __("You are not authorized to perform this operation.", $this->plugin_name) ?> </p>
<?php   
}