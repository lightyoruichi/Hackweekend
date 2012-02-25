<?php 



function wp_email_capture_form($error = 0)

{

$url = get_option('home');
$url = addLastCharacter($url);

 ?> <div id="wp_email_capture"><form name="wp_email_capture" method="post" action="<?php echo $url; ?>">

 	<?php if (isset($_GET["wp_email_capture_error"])) {

		$error = sanitize($_GET["wp_email_capture_error"]);

		echo "<div style='width:80%;background-color: #FFCCCC; margin: 5px;font-weight'>Error: ". $error ."</div>";

	} ?>

	<input name="wp-email-capture-name" placeholder="Name" type="text" class="wp-email-capture-name"><br/>

	<input name="wp-email-capture-email" placeholder="Email" type="text" class="wp-email-capture-email"><br/>

	<input type="hidden" name="wp_capture_action" value="1">

<input name="Submit" type="submit" value="Submit" class="wp-email-capture-submit">

</form>

</div>

<?php if (get_option("wp_email_capture_link") == 1) {

		echo "<p style='font-size:10px;'>Powered by <a href='http://www.gospelrhys.co.uk/plugins/wordpress-plugins/wordpress-email-capture-plugin' target='_blank'>WP Email Capture</a></p>\n";

	}

}



function wp_email_capture_form_page($error = 0)

{

$url = get_option('home');
$url = addLastCharacter($url);

 $display .= "<div id='wp_email_capture_2'><form name='wp_email_capture_display' method='post' action='" . $url ."'>\n";

 	if (isset($_GET["wp_email_capture_error"])) {

		$error = sanitize($_GET["wp_email_capture_error"]);

		$display .= "<div style='width:80%;background-color: #FFCCCC; margin: 5px;font-weight'>Error: ". $error ."</div>\n";

	} 

	$display .= "<label class='wp-email-capture-name'>Name:</label> <input name='wp-email-capture-name' type='text' class='wp-email-capture-name'><br/>\n";

	$display .= "<label class='wp-email-capture-email'>Email:</label> <input name='wp-email-capture-email' type='text' class='wp-email-capture-email'><br/>\n";

	$display .= "<input type='hidden' name='wp_capture_action' value='1'>\n";

	$display .= "<input name='Submit' type='submit' value='Submit' class='wp-email-capture-submit'></form></div>\n";

	if (get_option("wp_email_capture_link") == 1) {

		$display .= "<p style='font-size:10px;'>Powered by <a href='http://www.gospelrhys.co.uk/plugins/wordpress-plugins/wordpress-email-capture-plugin' target='_blank'>WP Email Capture</a></p>\n";
	} 



	return $display;

}



function wp_email_capture_display_form_in_post($content)

{

	$get_form = wp_email_capture_form_page();

	$content = str_replace("[wp_email_capture_form]", $get_form, $content);

	return $content;

}





?>