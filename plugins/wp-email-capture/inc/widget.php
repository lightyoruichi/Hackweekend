<?php

function wp_email_capture_widget_init() {



	// Check to see required Widget API functions are defined...

	if ( !function_exists('register_sidebar_widget') || !function_exists('register_widget_control') )

		return; // ...and if not, exit gracefully from the script.



	// This function prints the sidebar widget--the cool stuff!

	function wp_email_capture_widget($args) {



		// $args is an array of strings which help your widget

		// conform to the active theme: before_widget, before_title,

		// after_widget, and after_title are the array keys.

		extract($args);



		// Collect our widget's options, or define their defaults.

		$options = get_option('wp_email_capture_widget');

		$title = empty($options['title']) ? 'Subscribe!' : $options['title'];

		$text = empty($options['text']) ? 'Subscribe to my blog for updates' : $options['text'];



 		// It's important to use the $before_widget, $before_title,

 		// $after_title and $after_widget variables in your output.

		echo $before_widget;

		echo $before_title . $title . $after_title;

		echo $text;

		wp_email_capture_form();

		echo $after_widget;

	}



	// This is the function that outputs the form to let users edit

	// the widget's title and so on. It's an optional feature, but

	// we'll use it because we can!

	function wp_email_capture_widget_control() {



		// Collect our widget's options.

		$options = get_option('wp_email_capture_widget');
	
		$newoptions = get_option('wp_email_capture_widget');

		// This is for handing the control form submission.

		if ( $_POST['wp-email-capture-submit'] ) {

			// Clean up control form submission options

			$newoptions['title'] = strip_tags(stripslashes($_POST['wp-email-capture-title']));

			$newoptions['text'] = strip_tags(stripslashes($_POST['wp-email-capture-text']));

		}



		// If original widget options do not match control form

		// submission options, update them.

		if ( $options != $newoptions ) {

			$options = $newoptions;

			update_option('wp_email_capture_widget', $options);

		}



		// Format options as valid HTML. Hey, why not.

		$title = htmlspecialchars($options['title'], ENT_QUOTES);

		$text = htmlspecialchars($options['text'], ENT_QUOTES);



// The HTML below is the control form for editing options.

?>

		<div>

		<label for="wp-email-capture-title" style="line-height:35px;display:block;">Widget title: <input type="text" id="wp-email-capture-title" name="wp-email-capture-title" value="<?php echo $title; ?>" /></label>

		<label for="wp-email-capture-text" style="line-height:35px;display:block;">Widget text: <input type="text" id="wp-email-capture-text" name="wp-email-capture-text" value="<?php echo $text; ?>" /></label>

		<input type="hidden" name="wp-email-capture-submit" id="wp-email-capture-submit" value="1" />

		</div>

	<?php

	// end of widget_mywidget_control()

	}



	// This registers the widget. About time.

	wp_register_sidebar_widget('wpemailcapture','WP Email Capture', 'wp_email_capture_widget');



	// This registers the (optional!) widget control form.

	wp_register_widget_control('wpemailcapture','WP Email Capture', 'wp_email_capture_widget_control');

}



// Delays plugin execution until Dynamic Sidebar has loaded first.

add_action('plugins_loaded', 'wp_email_capture_widget_init');



?>