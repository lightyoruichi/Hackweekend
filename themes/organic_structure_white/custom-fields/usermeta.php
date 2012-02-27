<?php
class JwCustomUserMeta {
 
    function __construct(){
        add_action( 'show_user_profile', array($this, 'jw_add_custom_user_profile_fields') );
        add_action( 'edit_user_profile', array($this, 'jw_add_custom_user_profile_fields') );
        add_action( 'personal_options_update', array($this, 'jw_save_custom_user_profile_fields')  );
        add_action( 'edit_user_profile_update', array($this, 'jw_save_custom_user_profile_fields')  );
    }
 
    function jw_add_custom_user_profile_fields( $user ) {
    ?>
<h3><?php _e('Extra Profile Information', 'your_textdomain'); ?></h3>
<table class="form-table">
<tbody><tr>
<th>
                    <label for="jw_title"><?php _e('Title', 'your_textdomain'); ?></label>
                </th>
<td>
<input name="jw_title" id="jw_title" value="<?php echo esc_attr( get_the_author_meta( 'jw_title', $user->ID ) ); ?>" class="regular-text" type="text">
                    <span class="description"><?php _e('Please enter your work title.', 'your_textdomain'); ?></span>
                </td>
</tr>
<tr>
<th>
                    <label for="jw_phone"><!--?php _e('Phone', 'your_textdomain'); ?--></label>
                </th>
<td>
<input name="jw_phone" id="jw_phone" value="<?php echo esc_attr( get_the_author_meta( 'jw_phone', $user->ID ) ); ?>" class="regular-text" type="text">
                    <span class="description"><?php _e('Please enter your phone number.', 'your_textdomain'); ?></span>
                </td>
</tr>
</tbody></table>
 
    <?php }
 
    function jw_save_custom_user_profile_fields( $user_id ) {
        if ( !current_user_can( 'edit_user', $user_id ) )
            return FALSE;
        update_usermeta( $user_id, 'jw_title', $_POST['jw_title'] );
        update_usermeta( $user_id, 'jw_phone', $_POST['jw_phone'] );
    }
} ?>