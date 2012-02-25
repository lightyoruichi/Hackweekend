<?php



function wp_email_capture_dashboard_widget() {

	// Display whatever it is you want to show

	wp_email_capture_writetable(3, "<strong>Last Three Members To Join</strong><br/><br/>");

	$tempemails = wp_email_capture_count_temp();	

	echo '<br/><br/><a name="list"></a><strong>Export</strong>';

  	echo '<form name="wp_email_capture_export" action="'. esc_url($_SERVER["REQUEST_URI"]) . '#list" method="post">';

	echo '<label>Use the button below to export your list as a CSV to use in software such as <a href="http://www.gospelrhys.co.uk/go/aweber.php" title="Email Marketing">Aweber</a>.</label>';

	echo '<input type="hidden" name="wp_email_capture_export" />';

	echo '<div class="submit"><input type="submit" value="Export List" /></div>';

	echo "</form><br/><br/";

	$tempemails = wp_email_capture_count_temp();

	echo "<a name='truncate'></a><strong>Temporary e-mails</strong>\n";

	echo '<form name="wp_email_capture_truncate" action="'. esc_url($_SERVER["REQUEST_URI"]) . '#truncate" method="post">';

	echo '<label>There are '. $tempemails . ' e-mail addresses that have been unconfirmed. Delete them to save space below.</label>';

	echo '<input type="hidden" name="wp_email_capture_truncate"/>';

	echo '<div class="submit"><input type="submit" value="Delete Unconfirmed e-mail Addresses" /></div>';

	echo "</form>";



} 



function wp_email_capture_add_dashboard_widgets() {

	wp_add_dashboard_widget('wp_email_capture_dashboard_widget', 'WP Email Capture - At A Glance', 'wp_email_capture_dashboard_widget');	

} 





?>