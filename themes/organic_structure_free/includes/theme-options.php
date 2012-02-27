<?php
$settings = get_current_theme().'-options'; // do not change!

$defaults = array( // define our defaults
		'hp_top_cat' => 1,
		'hp_feature_cat' => 1,
		'hp_mid_cat' => 1,
		'hp_mid_num' => 1,
		'hp_side_cat' => 1,
		'hp_side_num' => 3,
		'blog_cat' => 1,
		'blog_cat_num' => 5,
		'tracking' => '<!--tracking code goes here-->' // <-- no comma after the last option
);

//	push the defaults to the options database,
//	if options don't yet exist there.
add_option($settings, $defaults, '', 'yes');

//	this function registers our settings in the db
add_action('admin_init', 'register_theme_settings');
function register_theme_settings() {
	global $settings;
	register_setting($settings, $settings);
}
//	this function adds the settings page to the menu
add_action('admin_menu', 'add_theme_options_menu');
function add_theme_options_menu() {
	add_menu_page("Organic Themes", "Organic Themes", 'edit_themes', basename(__FILE__), 'theme_settings_admin', "http://www.organicthemes.com/optionsicon.ico");
}

function theme_settings_admin() { ?>
<?php theme_options_css_js(); ?>
<div class="wrap">
<?php
	// display the proper notification if Saved/Reset
	global $settings, $defaults;
	if(ot_option('reset')) {
		echo '<div class="updated fade" id="message"><p>Theme Options <strong>RESET TO DEFAULTS</strong></p></div>';
		update_option($settings, $defaults);
	} elseif($_REQUEST['updated'] == 'true') {
		echo '<div class="updated fade" id="message"><p>Theme Options <strong>SAVED</strong></p></div>';
	}
	// display icon next to page title
	screen_icon('options-general');
?>
	<h2><?php echo get_current_theme() . ' '; _e('Theme Options'); ?></h2>
	<form method="post" action="options.php">
	<?php settings_fields($settings); // important! ?>
	
	<!--left column-->
	<div class="metabox-holder mbleft">
        
        <div class="postbox">
		<h3><?php _e("Analytics Code", 'organicthemes'); ?></h3>
			<div class="inside">
				<p>If you use a service such as <a href="http://www.google.com/analytics/">Google Analytics</a> to track analytics on your site, paste the code below (it will be inserted into the footer):</p>
				<p>
				<textarea name="<?php echo $settings; ?>[tracking]" cols=30 rows=5><?php echo stripslashes(ot_option('tracking')); ?></textarea>
				</p>
			</div>
		</div>
        
	</div>
	<!--end left column-->
	
	<!--right column-->
    
	<div class="metabox-holder mbright">
        
		<div class="postbox">
            <h3><?php _e("Home Page Featured Text", 'organicthemes'); ?></h3>
            <div class="inside">

                <p><?php _e("Select which category to display for the Home Page text banner. The Post Title will be displayed as the text banner.", 'organicthemes'); ?><br />
                <?php wp_dropdown_categories(array('selected' => ot_option('hp_top_cat'), 'name' => $settings.'[hp_top_cat]', 'orderby' => 'Name' , 'hierarchical' => 1, 'show_option_all' => __("All Categories", 'organicthemes'), 'hide_empty' => '0' )); ?></p>
                
            </div>
        </div>
        
        <div class="postbox">
            <h3><?php _e("Homepage Featured Article", 'organicthemes'); ?></h3>
            <div class="inside">
                
                <p><?php _e("Select which category to display for the Home Page featured article.", 'organicthemes'); ?><br />
                <?php wp_dropdown_categories(array('selected' => ot_option('hp_feature_cat'), 'name' => $settings.'[hp_feature_cat]', 'orderby' => 'Name' , 'hierarchical' => 1, 'show_option_all' => __("All Categories", 'organicthemes'), 'hide_empty' => '0' )); ?></p>

            </div>
        </div>
        
        <div class="postbox">
            <h3><?php _e("Home Page Middle Content", 'organicthemes'); ?></h3>
            <div class="inside">

                <p><?php _e("Select the category you wish to display within the middle column of the Home Page.", 'organicthemes'); ?><br />
                <?php wp_dropdown_categories(array('selected' => ot_option('hp_mid_cat'), 'name' => $settings.'[hp_mid_cat]', 'orderby' => 'Name' , 'hierarchical' => 1, 'show_option_all' => __("All Categories", 'organicthemes'), 'hide_empty' => '0' )); ?></p>
                
                <p><?php _e("Number of Posts to Show", 'organicthemes'); ?>:<br />
				<input type="text" name="<?php echo $settings; ?>[hp_mid_num]" value="<?php echo ot_option('hp_mid_num'); ?>" size="3" /></p>
                
            </div>
        </div>

        <div class="postbox">
            <h3><?php _e("Homepage Left Side", 'organicthemes'); ?></h3>
            <div class="inside">

                <p><?php _e("Select which <strong>category</strong> to display on the <strong>left side</strong>:", 'organicthemes'); ?><br />
                <?php wp_dropdown_categories(array('selected' => ot_option('hp_side_cat'), 'name' => $settings.'[hp_side_cat]', 'orderby' => 'Name' , 'hierarchical' => 1, 'show_option_all' => __("All Categories", 'organicthemes'), 'hide_empty' => '0' )); ?></p>
                <p><?php _e("Number of Posts to Show", 'organicthemes'); ?>:<br />
				<input type="text" name="<?php echo $settings; ?>[hp_side_num]" value="<?php echo ot_option('hp_side_num'); ?>" size="3" /></p>

            </div>
        </div>

		<p class="submit">
		<input type="submit" class="button-primary" value="<?php _e('Save Settings', 'organicthemes') ?>" />
		<input type="submit" class="button-highlighted" name="<?php echo $settings; ?>[reset]" value="<?php _e('Reset Settings', 'organicthemes'); ?>" />
		</p>

	</div>
	<!--end right column-->
	
	</form>

</div><!--end .wrap-->
<?php }

// add CSS and JS if necessary
function theme_options_css_js() {
echo <<<CSS

<style type="text/css">
	.metabox-holder { 
		float: left;
		margin: 0; padding: 0 10px 0 0;
	}
	.metabox-holder { 
		float: left;
		margin: 0; padding: 0 10px 0 0;
	}
	.metabox-holder .postbox .inside {
		padding: 0 10px;
	}
	.mbleft {
		width: 300px;
	}
	.mbright {
		width: 480px;
	}
	.catchecklist,
	.pagechecklist {
		list-style-type: none;
		margin: 0; padding: 0 0 10px 0;
	}
	.catchecklist li,
	.pagechecklist li {
		margin: 0; padding: 0;
	}
	.catchecklist ul {
		margin: 0; padding: 0 0 0 15px;
	}
	select {
		margin-top: 5px;
	}
	input {
		margin-top: 5px;
	}
	input[type="checkbox"], input[type="radio"] {
		margin-top: 1px;
	}
</style>

CSS;

echo <<<JS

<script type="text/javascript">
jQuery(document).ready(function($) {
	$(".fade").fadeIn(1000).fadeTo(1000, 1).fadeOut(1000);
});
</script>

JS;
}
?>