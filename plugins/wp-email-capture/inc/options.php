<?php 

function wp_email_capture_menus() {

  add_options_page('WP Email Capture Options', 'WP Email Capture', 8, 'wpemailcaptureoptions', 'wp_email_capture_options');

}



function wp_email_capture_options() {

  echo '<div class="wrap">';

  echo '<h2>WP Email Capture Options</h2>';

  ?>

  <h3>Recommendations</h3>

  <p>We recommend <a href="http://www.gospelrhys.co.uk/offto/aweber" title="Email Marketing">Aweber</a> to run your email campaigns. We have tested this plugin with it.

  </p>

  <table width="75%"  border="0">

    <tr>

      <td><div style="text-align:center;">

<a href="http://www.gospelrhys.co.uk/offto/aweber" title="Email Marketing">

<img src="http://www.aweber.com/banners/email_marketing_easy/726x90.gif" alt="AWeber - Email Marketing Made Easy" style="border:none;" /></a>

</div></td>

    </tr>

  </table>
  <p>    

    <?php

  

  echo '<h3>Options</h3>';

  ?>

      

</p>

  <form method="post" action="options.php">

  <?php wp_nonce_field('update-options'); ?>

  <?php settings_fields( 'wp-email-capture-group' ); ?>

  <table class="form-table">

  <tbody>

<tr valign="top">

  <th scope="row" style="width:400px">Page to redirect to on sign up (full web address ie: http://www.domain.com/this-page/)</th>

  <td><input type="text" name="wp_email_capture_signup" class="regular-text code" value="<?php echo get_option('wp_email_capture_signup'); ?>" /></td>

</tr>

<tr valign="top">

<th scope="row" style="width:400px"><label>Page to redirect to on confirmation of email address  (full web address ie: http://www.domain.com/this-other-page/)</label></th>

<td><input type="text" name="wp_email_capture_redirection" class="regular-text code" value="<?php echo get_option('wp_email_capture_redirection'); ?>" /></td>

</tr>

<tr valign="top">

<th scope="row" style="width:400px"><label>From Which Email Address</label></th>

<td><input type="text" name="wp_email_capture_from" class="regular-text code"  value="<?php echo get_option('wp_email_capture_from'); ?>" /></td>

</tr>

<tr valign="top">

<th scope="row" style="width:400px"><label>From Which Name</label></th>

<td><input type="text" name="wp_email_capture_from_name" class="regular-text code"  value="<?php echo get_option('wp_email_capture_from_name'); ?>" /></td>

</tr>

<tr valign="top">

  <th scope="row" style="width:400px">Subject of Email</th>

  <td><input type="text" name="wp_email_capture_subject" class="regular-text code"  value="<?php echo get_option('wp_email_capture_subject'); ?>" /></td>

</tr>

<tr valign="top">

<th scope="row" style="width:400px"><label>Body of Email<br> 
(use %NAME% to use the form's &quot;Name&quot; field in their welcome email) </label></th>

<td><textarea name="wp_email_capture_body" style="width: 25em;"><?php echo get_option('wp_email_capture_body'); ?></textarea></td>

</tr>

<tr valign="top">

<th scope="row" style="width:400px"><label>Link to us (optional, but appreciated)</label></th>

<td><input type="checkbox" name="wp_email_capture_link" value="1"

<?php 

if (get_option('wp_email_capture_link') == 1) { echo "checked"; } ?>

></td>

</tr>

  </tbody>

</table>



<input type="hidden" name="action" value="update" />

<input type="hidden" name="page_options" value="wp_email_capture_redirection,wp_email_capture_from,wp_email_capture_subject,wp_email_capture_signup,wp_email_capture_body,wp_email_capture_from_name,wp_email_capture_link" />

<p class="submit">

<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />

</p>

</form>



  <?php 

  wp_email_capture_writetable();

   echo '<a name="list"></a><h3>Export</h3>';

  	echo '<form name="wp_email_capture_export" action="'. esc_url($_SERVER["REQUEST_URI"]) . '#list" method="post">';

	echo '<label>Use the button below to export your list as a CSV to use in software such as <a href="http://www.gospelrhys.co.uk/go/aweber.php" title="Email Marketing">Aweber</a> or <a href="http://www.gospelrhys.co.uk/go/mailchimp.php">Mailchimp</a></label>';

	echo '<input type="hidden" name="wp_email_capture_export" />';

	echo '<div class="submit"><input type="submit" value="Export List" /></div>';

	echo "</form>";

	$tempemails = wp_email_capture_count_temp();

	echo "<a name='truncate'></a><h3>Temporary e-mails</h3>\n";

	echo '<form name="wp_email_capture_truncate" action="'. esc_url($_SERVER["REQUEST_URI"]) . '#truncate" method="post">';

	echo '<label>There are '. $tempemails . ' e-mail addresses that have been unconfirmed. Delete them to save space below.</label>';

	echo '<input type="hidden" name="wp_email_capture_truncate"/>';

	echo '<div class="submit"><input type="submit" value="Delete Unconfirmed e-mail Addresses" /></div>';

	echo "</form>";

echo "<a name='emptyallemails'></a><h3>Delete Current List</h3>\n";

	echo '<form name="wp_email_capture_delete" action="'. esc_url($_SERVER["REQUEST_URI"]) . '#delete" method="post">';

	echo '<label>Want to delete the entire list? Click the link below. <strong>WARNING: </strong> this will delete all confirmed emails, so make sure you have a backup.</label>';

	echo '<input type="hidden" name="wp_email_capture_delete"/>';

	echo '<div class="submit"><input type="submit" value="Delete Confirmed e-mail Addresses" /></div>';

	echo "</form>";

  echo '</div>';
?>
<h3>Donations</h3>

<p>If you like this plugin, please consider a small donation to help with future versions &amp; plugins. Donators are thanked on each specific plugin page!</p>

<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="8590914">
<input type="image" src="https://www.paypal.com/en_US/GB/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online.">
<img alt="" border="0" src="https://www.paypal.com/en_GB/i/scr/pixel.gif" width="1" height="1">
</form>



<?php }



function wp_email_capture_options_process() { // whitelist options

  register_setting( 'wp-email-capture-group', 'wp_email_capture_signup' );

  register_setting( 'wp-email-capture-group', 'wp_email_capture_redirection' );

  register_setting( 'wp-email-capture-group', 'wp_email_capture_from' );

  register_setting( 'wp-email-capture-group', 'wp_email_capture_subject' );

  register_setting( 'wp-email-capture-group', 'wp_email_capture_body' );

  register_setting( 'wp-email-capture-group', 'wp_email_capture_link');

  register_setting( 'wp-email-capture-group', 'wp_email_capture_from_name' );

  if(isset($_REQUEST['wp_email_capture_export'])) {

  	wp_email_capture_export();

  }


   if(isset($_REQUEST['wp_email_capture_deleteid'])) {
	$wpemaildeleteid = $_POST['wp_email_capture_deleteid'];
  	wp_email_capture_deleteid($wpemaildeleteid);
  }
  

  if(isset($_REQUEST['wp_email_capture_truncate'])) {

  	

  	wp_email_capture_truncate();

  }

  if(isset($_REQUEST['wp_email_capture_delete'])) {

  	

  	wp_email_capture_delete();

  }

}

?>