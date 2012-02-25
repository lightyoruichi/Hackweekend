<?php 

/*

Plugin Name: WP Email Capture

Plugin URI: http://www.gospelrhys.co.uk/plugins/wordpress-plugins/wordpress-email-capture-plugin

Description: Captures email addresses for insertion into software such as <a href="http://www.gospelrhys.co.uk/go/aweber.php" title="Email Marketing">Aweber</a> or <a href="http://www.gospelrhys.co.uk/go/mailchimp.php">Mailchimp</a>

Version: 2.0.1

Author: Rhys Wynne

Author URI: http://www.gospelrhys.co.uk/

*/

global $wp_email_capture_db_version;

$wp_email_capture_db_version = "1.0";

define(WP_EMAIL_CAPTURE_PATH, dirname(__FILE__));

require_once(WP_EMAIL_CAPTURE_PATH . '/inc/core.php');



if ( is_admin() ){ // admin actions

  add_action('admin_menu', 'wp_email_capture_menus');

  add_action( 'admin_init', 'wp_email_capture_options_process' );

  add_action('wp_dashboard_setup', 'wp_email_capture_add_dashboard_widgets' );

} else {

  add_action('init','wp_email_capture_process');

  add_filter ( 'the_content', 'wp_email_capture_display_form_in_post');

}



register_activation_hook(__FILE__,'wp_email_capture_install');





?>