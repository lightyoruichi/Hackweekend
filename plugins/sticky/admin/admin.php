<?php

if (!class_exists("wpStickyNotes_custom_post_type")) {
class wpStickyNotes_custom_post_type
{
	var $pagehook = "";
	private $colors;
	public $main;
	
	function wpStickyNotes_custom_post_type($mainClass){$this->__construct($mainClass);}
	function __construct($mainClass)
	{
		$this->main = $mainClass;
		$this->colors = $mainClass->colors;
		$labels = array(
			'name' => __( 'Sticky Notes' ),
			'singular_name' => __( 'Sticky Note' ),
			'add_new' => __( 'Add New' ),
			'add_new_item' => __( 'Add New Sticky Note' ),
			'edit' => __( 'Edit' ),
			'edit_item' => __( 'Edit Sticky Note' ),
			'new_item' => __( 'New Sticky Note' ),
			'view' => __( 'View Sticky Note' ),
			'view_item' => __( 'View Sticky Note' ),
			'search_items' => __( 'Search Sticky Notes' ),
			'not_found' => __( 'No sticky notes found' ),
			'not_found_in_trash' => __( 'No sticky notes found in Trash' ),
			'parent' => __( 'Parent Sticky Note' ),
		);
		register_post_type('stickynote', array(
			'labels' => $labels,
			'public' => true,
			'menu_icon' => WPSTICKY_PLUGIN_URL.'/images/icon.png',
			'show_ui' => true, // UI in admin panel
			'capability_type' => 'post',
			'show_in_nav_menus' => false,
			'hierarchical' => false,
			'rewrite' => true,//array("slug" => "portfolio",'with_front' => FALSE), // Permalinks
			'query_var' => "stickynote", // This goes to the WP_Query schema
			'supports' => array('excerpt',
                                'title',
								'comments',
                                 ) // Let's use custom fields for debugging purposes only
		));
		
		add_filter("manage_edit-stickynote_columns", array(&$this, "edit_columns"));
		add_action("manage_posts_custom_column", array(&$this, "custom_columns"));
		add_filter('post_updated_messages', array(&$this, 'stickynotes_updated_messages'));
		add_action('admin_menu', array(&$this, 'admin_menu'));
		add_filter('screen_layout_columns', array(&$this, 'on_screen_layout_columns'), 10, 2);
		add_action('admin_post_save_stickynotes_settings', array(&$this, 'on_save_changes'));
		add_action('save_post', array(&$this,'save_stickynote_data') );
		
		wp_enqueue_style( 'sticky-notes-css' );
			
	}
	
	/* Add Columns to Sticky Notes */
	function edit_columns($columns)
	{
		$columns = array(
			"cb" => "<input type=\"checkbox\" />",
			"title" => "Title",
			"excerpts" => "Note Content",
			"comments" => '<div class="vers"><img src="'.get_bloginfo('siteurl').'/wp-admin/images/comment-grey-bubble.png" alt="Comments"></div>',
			"date" => "Date",
			
		);
		
		return $columns;
	}
	
	function custom_columns($column)
	{
		global $post, $wpdb;
		if($post->post_type == 'stickynote')
		{
			$query = "SELECT post_excerpt FROM wp_posts WHERE ID = " . $post->ID . " LIMIT 1";
	  		$result = $wpdb->get_results($query, ARRAY_A);
			switch ($column)
			{
				case "excerpts":
					echo strip_tags($result[0]['post_excerpt']);
					break;
			}
		}
	}
	
	function on_screen_layout_columns($columns, $screen)
	{
		if ($screen == $this->pagehook) {
			$columns[$this->pagehook] = 2;
		}
		return $columns;
	}
	
	function stickynotes_updated_messages( $messages )
	{
		$messages['stickynote'] = array(
			0 => '', // Unused. Messages start at index 1.
			1 => sprintf( __('Sticky Note updated. <a href="%s">View sticky note</a>'), esc_url( get_permalink($post_ID) ) ),
			2 => __('Custom field updated.'),
			3 => __('Custom field deleted.'),
			4 => __('Sticky Note updated.'),
			/* translators: %s: date and time of the revision */
			5 => isset($_GET['revision']) ? sprintf( __('Sticky Note restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6 => sprintf( __('Sticky Note published. <a href="%s">View sticky note</a>'), esc_url( get_permalink($post_ID) ) ),
			7 => __('Book saved.'),
			8 => sprintf( __('Sticky Note submitted. <a target="_blank" href="%s">Preview sticky note</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
			9 => sprintf( __('Sticky Note scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview sticky note</a>'),
			  // translators: Publish box date format, see http://php.net/date
			  date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
			10 => sprintf( __('Sticky Note draft updated. <a target="_blank" href="%s">Preview sticky note</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
	  	);
		
		return $messages;
	}
	
	function admin_menu()
	{
		$this->pagehook = add_submenu_page( 'edit.php?post_type=stickynote', __('Settings'), __('Settings'), 10, 'stickynote_settings', array(&$this, 'stickynote_settings_page') );
		add_action('load-'.$this->pagehook, array(&$this, 'on_load_page'));
		add_action('load-stickynotes', array(&$this, 'on_load_page')); 
		add_meta_box("stickynote-assigncolor", "Color & Style", array(&$this, "stickynote_assigncolor"), "stickynote", "side", "low");
		wp_enqueue_script( 'sticky-notes-admin' );

	}
	
	function stickynote_assigncolor($data)
	{
		global $post;
		
		foreach($this->colors as $option => $colors)
		{
			$this->colors[$option] = get_option($option, $colors);
		}
		
		$note_style = get_post_meta($post->ID, '_stickynote_style', true);
		$style = $this->colors[$note_style];
		$style = "style='background: #".$style['bg']."; border-color: #".$style['border']."; color: #".$style['text'].";'";
		
		$output .= "<input type='hidden' name='stickynote_noncename' value='" . wp_create_nonce( plugin_basename(__FILE__) ) . "' />";
		$output .= "<select id='stickynote_style' name='stickynote_style' $style>";
		$count = 1;
		foreach($this->colors as $option => $colors)
		{
			$selected = ($note_style == $option)? "selected='selected'": "";
			$style = "style='background: #".$colors['bg']."; border-color: #".$colors['border']."; color: #".$colors['text'].";'";
			$output .= "<option value='$option' $selected $style>Style 0$count</option>";
			$count++;
		}
		$output .= "</select>";
		echo $output;
	}
	
	function save_stickynote_data($post_id)
	{
		global $wpdb;
	 	if ( !wp_verify_nonce( $_POST['stickynote_noncename'], plugin_basename(__FILE__) )) {
			return $post_id;
		}
		// verify if this is an auto save routine. If it is our form has not been submitted, so we dont want to do anything
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
			return $post_id;
	 
		// Check permissions
		if ( !current_user_can( 'edit_post', $post_id ) )
			return $post_id;
	 
	 
		// OK, we're authenticated: we need to find and save the data	
		$post = get_post($post_id);
		if ($post->post_type == 'stickynote') {
			update_post_meta($post_id, '_stickynote_style', esc_attr($_POST['stickynote_style']) );
		}
		
		return $post_id;
	}
	
	function on_load_page()
	{
		wp_enqueue_script('common');
		wp_enqueue_script('wp-lists');
		wp_enqueue_script('postbox');
		wp_enqueue_script('sticky-notes-admin');
		wp_enqueue_style( 'sticky-notes-css');
		wp_enqueue_script('new_colorpicker');
		add_meta_box('stickynote_colors', 'Sticky Note Colors', array(&$this, 'stickynote_colors'), $this->pagehook, 'side', 'core');
		echo '<link rel="stylesheet" media="screen" type="text/css" href="'.WPSTICKY_PLUGIN_URL.'/css/colorpicker.css" />';
	}
	
	function stickynote_settings_page()
	{
		global $post, $wpdb, $screen_layout_columns;
		
		/* Save Settings Data */
		if($_POST):
		$new_colors = array();
		$count = 0;
		
		$new_colors['_sticky_note_01'] = array(
					'bg' => $_POST['_sticky_note_01_bg'], 
					'border' => $_POST['_sticky_note_01_border'], 
					'text' => $_POST['_sticky_note_01_text']);
		$new_colors['_sticky_note_02'] = array(
					'bg' => $_POST['_sticky_note_02_bg'], 
					'border' => $_POST['_sticky_note_02_border'], 
					'text' => $_POST['_sticky_note_02_text']);
		$new_colors['_sticky_note_03'] = array(
					'bg' => $_POST['_sticky_note_03_bg'], 
					'border' => $_POST['_sticky_note_03_border'], 
					'text' => $_POST['_sticky_note_03_text']);
		$new_colors['_sticky_note_04'] = array(
					'bg' => $_POST['_sticky_note_04_bg'], 
					'border' => $_POST['_sticky_note_04_border'], 
					'text' => $_POST['_sticky_note_04_text']);
		$new_colors['_sticky_note_05'] = array(
					'bg' => $_POST['_sticky_note_05_bg'], 
					'border' => $_POST['_sticky_note_05_border'], 
					'text' => $_POST['_sticky_note_05_text']);
		$new_colors['_sticky_note_06'] = array(
					'bg' => $_POST['_sticky_note_06_bg'], 
					'border' => $_POST['_sticky_note_06_border'], 
					'text' => $_POST['_sticky_note_06_text']);
		
		foreach($new_colors as $key => $value)
		{
			$option_name = $key; 
			$newvalue = $value ;
			if ( get_option($option_name) != $newvalue) {
				update_option($option_name, $newvalue);
			} else {
				$deprecated = ' ';
				$autoload = 'no';
				add_option($option_name, $newvalue, $deprecated, $autoload);
			}	
		}	
		
		if($_POST['reset_colors'])
		{
			$this->main->do_colors();
		}
		
		/* Save Settings for Canvas Width */
		if(get_option('_stickynote_canvaswidth') != mysql_real_escape_string($_POST['stickynote_canvaswidth']))
		{
			update_option('_stickynote_canvaswidth', mysql_real_escape_string($_POST['stickynote_canvaswidth']));
		} else {
			add_option('_stickynote_canvaswidth', mysql_real_escape_string($_POST['stickynote_canvaswidth']), ' ', 'no');
		}
		/* Save Settings for Canvas Height */
		if(get_option('_stickynote_canvasheight') != mysql_real_escape_string($_POST['stickynote_canvasheight']))
		{
			update_option('_stickynote_canvasheight', mysql_real_escape_string($_POST['stickynote_canvasheight']));
		} else {
			add_option('_stickynote_canvasheight', mysql_real_escape_string($_POST['stickynote_canvasheight']), ' ', 'no');
		}
		/* Save Settings for Default Text */
		if(get_option('_stickynote_defaulttext') != mysql_real_escape_string($_POST['stickynote_defaulttext']))
		{
			update_option('_stickynote_defaulttext', mysql_real_escape_string($_POST['stickynote_defaulttext']));
		} else {
			add_option('_stickynote_defaulttext', mysql_real_escape_string($_POST['stickynote_defaulttext']), ' ', 'no');
		}
		/* Save Settings for Postin Ability */
		if(get_option('_stickynote_posting') != mysql_real_escape_string($_POST['stickynote_posting']))
		{
			update_option('_stickynote_posting', mysql_real_escape_string($_POST['stickynote_posting']));
		} else {
			add_option('_stickynote_posting', mysql_real_escape_string($_POST['stickynote_posting']), ' ', 'no');
		}
		
		if(get_option('_stickynote_amount') != mysql_real_escape_string($_POST['stickynote_amount']))
		{
			update_option('_stickynote_amount', mysql_real_escape_string($_POST['stickynote_amount']));
		} else {
			add_option('_stickynote_amount', mysql_real_escape_string($_POST['stickynote_amount']), ' ', 'no');
		}
		
		endif;	
		/* End Save Settings Data */
		add_meta_box('stickynote_main_settings', 'Sticky Note Settings', array(&$this, 'stickynote_main_settings'), $this->pagehook, 'normal', 'core');?>
		<div id="howto-metaboxes-general" class="wrap">
		<?php screen_icon('sticky-notes'); ?>
		<h2>Sticky Note Settings</h2>
		<form action="" method="post" id="stickynotes-settingsform">
			<?php wp_nonce_field('stickynotes_settings'); ?>
			<?php wp_nonce_field('closedpostboxes', 'closedpostboxesnonce', false ); ?>
			<?php wp_nonce_field('meta-box-order', 'meta-box-order-nonce', false ); ?>
			<input type="hidden" name="action" value="save_howto_metaboxes_general" />
		
			<div id="poststuff" class="metabox-holder<?php echo 2 == $screen_layout_columns ? ' has-right-sidebar' : ''; ?>">
				<div id="side-info-column" class="inner-sidebar">
					<?php do_meta_boxes($this->pagehook, 'side', $data); ?>
				</div>
				<div id="post-body" class="has-sidebar">
					<div id="post-body-content" class="has-sidebar-content">
						<?php do_meta_boxes($this->pagehook, 'normal', $data); ?>
						<?php do_meta_boxes($this->pagehook, 'additional', $data); ?>
						<p>
							<input type="submit" value="Save Changes" class="button-primary" name="Submit"/>	
						</p>
					</div>
				</div>
				<br class="clear"/>
								
			</div>	
		</form>
		</div>
		<script type="text/javascript">
			//<![CDATA[
			jQuery(document).ready( function($) {
				// close postboxes that should be closed
				$('.if-js-closed').removeClass('if-js-closed').addClass('closed');
				// postboxes setup
				postboxes.add_postbox_toggles('<?php echo $this->pagehook; ?>');
			});
			//]]>
		</script>
		<?php
	}
	
	function stickynote_colors($data) 
	{	
		echo '<em>Change values to adjust colors of sticky notes</em>';
		foreach($this->colors as $option => $colors)
		{
			$this->colors[$option] = get_option($option, $colors);
		}
		
		$colorint = 1;
		foreach($this->colors as $option => $colors)
		{
			echo "<div class='color-box'>";
			echo "<div class='color-box-box color-box-".$colorint."' style='background: #".$colors['bg']."; border-color: #".$colors['border']."; color: #".$colors['text'].";'> T </div>";
			echo "<input class='bg' name='_sticky_note_0".$colorint."_bg' type='text' value='".$colors['bg']."' />";
			echo "<input class='border' name='_sticky_note_0".$colorint."_border' type='text' value='".$colors['border']."' />";
			echo "<input class='text' name='_sticky_note_0".$colorint."_text' type='text' value='".$colors['text']."' />";
			echo "</div>";
			
			$colorint++;
		}
		echo "<form id='resetcolors'><input class='button-secondary' type='submit' value='Reset Colors' name='reset_colors' /></form>";
	}
	
	function stickynote_main_settings($data) 
	{
		$canvaswidth = get_option('_stickynote_canvaswidth');
		$canvasheight = get_option('_stickynote_canvasheight');
		$defaulttext = get_option('_stickynote_defaulttext');
		$posting = get_option('_stickynote_posting');
		$stickynote_amount = get_option('_stickynote_amount');
		
		echo "<strong>Intructions: </strong><br />";
		echo "Use the shortcode '[wp-sticky-notes]' in any page that you want the sticky notes to appear.";
		?>
        <table class="form-table">
		<tbody><tr valign="top">
		<tr valign="top">
		<th scope="row"><label for="stickynote_canvaswidth">Canvas Size</label></th>
		<td><input type="text" class="small-text" value="<?php echo $canvaswidth;?>" id="stickynote_canvaswidth" name="stickynote_canvaswidth">
			<input type="text" class="small-text" value="<?php echo $canvasheight;?>" id="stickynote_canvasheight" name="stickynote_canvasheight">
		<span class="description">Enter size of sticky note canvas. Don't forget the "px" or "%".</span></td>
		</tr>
		<th scope="row"><label for="stickynote_defaulttext">Default Text</label></th>
		<td><textarea class="large-text" id="stickynote_defaulttext" name="stickynote_defaulttext"><?php echo $defaulttext;?></textarea>
		<span class="description">Enter text that will appear when there are no sticky note.</span></td>
		</tr>
		<tr valign="top">
		<th scope="row"><label for="stickynote_posting">Posting Ability</label></th>
		<td><fieldset><legend class="screen-reader-text"><span>Posting Ability</span></legend>
		<select id="stickynote_posting" name="stickynote_posting">
			<option value="anyone" <?php echo $posting == 'anyone' ? 'selected="selected"': '';?> >Anyone</option>
			<option value="loggedinusers" <?php echo $posting == 'loggedinusers' ? 'selected="selected"': '';?>>Logged In Users</option>
			<option value="admin" <?php echo $posting == 'admin' ? 'selected="selected"': '';?>>Only Admin</option>
		</select><span class="description">Who can post sticky notes and post comments</span>
		</fieldset></td>
		</tr>
        <tr valign="top">
		<th scope="row"><label for="stickynote_amount">Max Number of Stickynotes</label></th>
		<td><input type="text" class="small-text" value="<?php echo $stickynote_amount;?>" id="stickynote_amount" name="stickynote_amount"><span class="description">Enter max number of sticky notes to be displayed at once</span></td>
		</tr></tbody></table>
        <?
	}

}
}
?>