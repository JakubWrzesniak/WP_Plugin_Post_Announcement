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
<h1>Manage Posts Annoncement</h1>
<div>
    <?php
            require_once( plugin_dir_path( __FILE__ ) . '/../class-post-announcement-admin-list.php' );
            $wp_list_table = new Post_Announcement_List();
            //$wp_list_table->prepare_items();
            $wp_list_table->display();
    ?>
</div>
<div>
    <?php 
        $editor_id = 'postaneditor';
        $uploaded_csv = get_post_meta( $post->ID, 'custom_editor_box', true);
        wp_editor( $uploaded_csv, $editor_id, array( 'theme_advanced_buttons1' => 'bold, italic, ul, pH, pH_min', "media_buttons" => false, "textarea_rows" => 3, "tabindex" => 4 ) );
        submit_button( 'Save content' );
    ?>
</div>