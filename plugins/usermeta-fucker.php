<?php
/*
Plugin Name: Usermeta fucker
Plugin URI: http://hack.weekend.my
Description: Allows users to configure some random extra meta value.
Author: Harinder Singh
Version: 0.02
Author URI: http://lightyoruichi.com/
 
Use of the frontend as get_the_author_meta('something') or the_author_meta('something')
*/
 
class hari_user_meta {
 
 function hari_user_meta() {
 if ( is_admin() )
 {
 add_action('show_user_profile', array(&$this,'action_show_user_profile'));
 add_action('edit_user_profile', array(&$this,'action_show_user_profile'));
 add_action('personal_options_update', array(&$this,'action_process_option_update'));
 add_action('edit_user_profile_update', array(&$this,'action_process_option_update'));
 }
 
 }
 
 function action_show_user_profile($user)
 {
 ?>
 <h3><?php _e('Other Contact Info') ?></h3>
 
 <table>
 <tr>
 <th><label for="hwkl1"><?php _e('Hackweekend 1'); ?></label></th>
 <td><input type="text" name="hwkl" id="hwkl" value="<?php echo esc_attr(get_the_author_meta('hwkl', $user->ID) ); ?>" /></td>
 </tr>
  <tr>
 <th><label for="hwkl2"><?php _e('Hackweekend 2'); ?></label></th>
 <td><input type="text" name="hwkl" id="hwkl2" value="<?php echo esc_attr(get_the_author_meta('hwkl2', $user->ID) ); ?>" /></td>
 </tr>
  <tr>
 <th><label for="hwkl3"><?php _e('Hackweekend 3'); ?></label></th>
 <td><input type="text" name="hwkl3" id="hwkl3" value="<?php echo esc_attr(get_the_author_meta('hwkl3', $user->ID) ); ?>" /></td>
 </tr>
  <tr>
 <th><label for="hwkl4"><?php _e('Hackweekend 4'); ?></label></th>
 <td><input type="text" name="hwkl4" id="hwkl4" value="<?php echo esc_attr(get_the_author_meta('hwkl4', $user->ID) ); ?>" /></td>
 </tr>
 </table>
 <?php
 }
 
 function action_process_option_update($user_id)
 {
 update_usermeta($user_id, 'hwkl', ( isset($_POST['hwkl']) ? $_POST['hwkl'] : '' ) );
 }
}
/* Initialise outselves */
add_action('plugins_loaded', create_function('','global $hari_user_meta_instance; $hari_user_meta_instance = new hari_user_meta();'));
?>