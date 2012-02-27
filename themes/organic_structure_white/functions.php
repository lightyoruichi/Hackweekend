<?php

//Adding a "weekend" custom post type
add_action( 'init', 'hackweekend_event_post' );
function hackweekend_event_post() {
  $labels = array(
    'name' => _x('Weekend', 'post type general name'),
    'singular_name' => _x('Weekend', 'post type singular name'),
    'add_new' => _x('Add New', 'Weekend'),
    'add_new_item' => __('Add New Weekend'),
    'edit_item' => __('Edit Weekend'),
    'new_item' => __('New Weekend'),
    'all_items' => __('All Weekend'),
    'view_item' => __('View Weekend'),
    'search_items' => __('Search Weekend'),
    'not_found' =>  __('No weekend found'),
    'not_found_in_trash' => __('No weekend found in Trash'), 
    'parent_item_colon' => '',
    'menu_name' => 'Weekend'

  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_menu' => true, 
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'has_archive' => true, 
    'hierarchical' => true,
    'menu_position' => null,
    'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'custom-fields' )
  ); 
  register_post_type('Weekend',$args);
}

//add filter to ensure the text Weekend, or Weekend, is displayed when user updates a Weekend 
add_filter( 'post_updated_messages', 'codex_Weekend_updated_messages' );
function codex_Weekend_updated_messages( $messages ) {
  global $post, $post_ID;

  $messages['weekend'] = array(
    0 => '', // Unused. Messages start at index 1.
    1 => sprintf( __('weekend updated. <a href="%s">View weekend</a>'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Custom field updated.'),
    3 => __('Custom field deleted.'),
    4 => __('Weekend updated.'),
    /* translators: %s: date and time of the revision */
    5 => isset($_GET['revision']) ? sprintf( __('Weekend restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Weekend published. <a href="%s">View Weekend</a>'), esc_url( get_permalink($post_ID) ) ),
    7 => __('Weekend saved.'),
    8 => sprintf( __('Weekend submitted. <a target="_blank" href="%s">Preview Weekend</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('Weekend scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Weekend</a>'),
      // translators: Publish box date format, see http://php.net/date
      date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('Weekend draft updated. <a target="_blank" href="%s">Preview Weekend</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );

  return $messages;
}

//display contextual help for Weekends
add_action( 'contextual_help', 'codex_add_help_text', 10, 3 );

function codex_add_help_text( $contextual_help, $screen_id, $screen ) { 
  //$contextual_help .= var_dump( $screen ); // use this to help determine $screen->id
  if ( 'Weekend' == $screen->id ) {
    $contextual_help =
      '<p>' . __('Things to remember when adding or editing a Weekend:') . '</p>' .
      '<ul>' .
      '<li>' . __('Specify the correct genre such as Mystery, or Historic.') . '</li>' .
      '<li>' . __('Specify the correct writer of the Weekend.  Remember that the Author module refers to you, the author of this Weekend review.') . '</li>' .
      '</ul>' .
      '<p>' . __('If you want to schedule the Weekend review to be published in the future:') . '</p>' .
      '<ul>' .
      '<li>' . __('Under the Publish module, click on the Edit link next to Publish.') . '</li>' .
      '<li>' . __('Change the date to the date to actual publish this article, then click on Ok.') . '</li>' .
      '</ul>' .
      '<p><strong>' . __('For more information:') . '</strong></p>' .
      '<p>' . __('<a href="http://codex.wordpress.org/Posts_Edit_SubPanel" target="_blank">Edit Posts Documentation</a>') . '</p>' .
      '<p>' . __('<a href="http://wordpress.org/support/" target="_blank">Support Forums</a>') . '</p>' ;
  } elseif ( 'edit-Weekend' == $screen->id ) {
    $contextual_help = 
      '<p>' . __('This is the help screen displaying the table of Weekends blah blah blah.') . '</p>' ;
  }
  return $contextual_help;
}



add_action( 'init', 'create_register' );
function create_register() {
  $labels = array(
    'name' => _x('Register', 'post type general name'),
    'singular_name' => _x('Register', 'post type singular name'),
    'add_new' => _x('Add New', 'Register'),
    'add_new_item' => __('Add New Register'),
    'edit_item' => __('Edit Register'),
    'new_item' => __('New Register'),
    'view_item' => __('View Register'),
    'search_items' => __('Search Register'),
    'not_found' =>  __('No Register found'),
    'not_found_in_trash' => __('No Register found in Rejected'),
    'parent_item_colon' => ''
  );

  $supports = array('title', 'editor', 'custom-fields', 'revisions', 'excerpt');

  register_post_type( 'Register',
    array(
      'labels' => $labels,
      'public' => true,
      'supports' => $supports
    )
  );
}

//Adding locations to advanced custom field
if(function_exists('register_field'))
{
register_field('Location_field', dirname(__FILE__) . '/custom-fields/locations.php');
}


//Adding timepicker to advanced custom field
if(function_exists('register_field'))
{
register_field('xa_time_field', dirname(__FILE__) . '/custom-fields/timepicker/time_picker.php');
}

// Adding hwkl1 field to advanced custom field
if(function_exists('register_field')) 
{ 
// wrap your register field functions in this to prevent your site breaking on an update to the ACF plugin via @shaunbent
register_field('Users_field', dirname(__File__) . '/custom-fields/users_field.php');
}



//Add more user profiles
add_action( 'show_user_profile', 'extra_user_profile_fields' );
add_action( 'edit_user_profile', 'extra_user_profile_fields' );
 
function extra_user_profile_fields( $user ) { ?>
<h3><?php _e("Extra profile information", "blank"); ?></h3>
 
<table class="form-table">
<tr>
<th><label for="hwkl1"><?php _e("Hackweekend 1"); ?></label></th>
<td>
<input type="text" name="hwkl1" id="hwkl1" value="<?php echo esc_attr( get_the_author_meta( 'hwkl1', $user->ID ) ); ?>" class="regular-text" /><br />
<span class="description"><?php _e("Attendance"); ?></span>
</td>
</tr>
<tr>
<th><label for="hwkl2"><?php _e("Hackweekend 2"); ?></label></th>
<td>
<input type="text" name="hwkl2" id="hwkl2" value="<?php echo esc_attr( get_the_author_meta( 'hwkl2', $user->ID ) ); ?>" class="regular-text" /><br />
<span class="description"><?php _e("Attendance"); ?></span>
</td>
</tr>
<tr>
<th><label for="hwkl3"><?php _e("Hackweekend 3"); ?></label></th>
<td>
<input type="text" name="hwkl3" id="hwkl3" value="<?php echo esc_attr( get_the_author_meta( 'hwkl3', $user->ID ) ); ?>" class="regular-text" /><br />
<span class="description"><?php _e("Attendance"); ?></span>
</td>
</tr>
<tr>
<th><label for="hwkl4"><?php _e("Hackweekend 4"); ?></label></th>
<td>
<input type="text" name="hwkl4" id="hwkl4" value="<?php echo esc_attr( get_the_author_meta( 'hwkl4', $user->ID ) ); ?>" class="regular-text" /><br />
<span class="description"><?php _e("Attendance"); ?></span>
</td>
</tr>
<tr>
<th><label for="hwkl4"><?php _e("Reason"); ?></label></th>
<td>
<input row="3" column="3" type="textarea" name="reason" id="reason" value="<?php echo esc_attr( get_the_author_meta( 'reason', $user->ID ) ); ?>" class="regular-text" /><br />
<span class="description"><?php _e("Reason for his screw ups"); ?></span>
</td>
</tr>
</table>
<?php }

add_action( 'show_user_profile', 'save_extra_user_profile_fields' );
add_action( 'edit_user_profile', 'save_extra_user_profile_fields' );
add_action( 'personal_options_update', 'save_extra_user_profile_fields' );
add_action( 'edit_user_profile_update', 'save_extra_user_profile_fields' );
 
function save_extra_user_profile_fields( $user_id ) {
 
if ( !current_user_can( 'edit_user', $user_id ) ) { return false; }
 
update_user_meta( $user_id, 'hwkl1', $_POST['hwkl1'] );
update_user_meta( $user_id, 'hwkl2', $_POST['hwkl2'] );
update_user_meta( $user_id, 'hwkl3', $_POST['hwkl3'] );
update_user_meta( $user_id, 'hwkl4', $_POST['hwkl4'] );
update_user_meta( $user_id, 'reason', $_POST['reason'] );
}

// END

// Add Facebook and Twitter 
// adding custom fields to WP user profile
function famousbloggers_profiles( $contactmethods ) {
    // Add Twitter
    $contactmethods['blog_title'] = 'Blog Title';
    // Add Google profile
    $contactmethods['google'] = 'Google+ URL';
    // Add Twitter
    $contactmethods['twitter'] = 'Twitter ID';
    //add Facebook
    $contactmethods['facebook'] = 'Facebook Profile URL';

    return $contactmethods;
    }
    add_filter('user_contactmethods','famousbloggers_profiles',10,1);
// end of adding custom fields to WP user profile

//Turn a category ID to a Name
function cat_id_to_name($id) {
	foreach((array)(get_categories()) as $category) {
    	if ($id == $category->cat_ID) { return $category->cat_name; break; }
	}
}

//	Pull theme options from database
function ot_option($key) {
	global $settings;
	$option = get_option($settings);
	if(isset($option[$key])) return $option[$key];
	else return FALSE;
}

//	Include the theme options
include(TEMPLATEPATH."/includes/theme-options.php");

//	Include the Custom Header code
include_once(TEMPLATEPATH.'/includes/custom-header.php');

//	Load local Gravity Forms styles if the plugin is installed
if(class_exists("RGForms") && !is_admin()){
    wp_enqueue_style("local_gf_styles", get_bloginfo('template_url') . "/includes/organic_gforms.css");
    if(!get_option('rg_gforms_disable_css'))
        update_option('rg_gforms_disable_css', true);
}

//	Register widgets
if ( function_exists('register_sidebars') )
	register_sidebar(array('name'=>'Right Sidebar','before_widget'=>'<div id="%1$s" class="widget %2$s">','after_widget'=>'</div>','before_title'=>'<h4>','after_title'=>'</h4>'));
	register_sidebar(array('name'=>'Left Sidebar','before_widget'=>'<div id="%1$s" class="widget %2$s">','after_widget'=>'</div>','before_title'=>'<h4>','after_title'=>'</h4>'));
	register_sidebar(array('name'=>'Homepage Top Right','before_widget'=>'<div id="%1$s" class="widget %2$s">','after_widget'=>'</div>','before_title'=>'<h4>','after_title'=>'</h4>'));
	register_sidebar(array('name'=>'Footer Left','before_widget'=>'<div id="%1$s" class="widget %2$s">','after_widget'=>'</div>','before_title'=>'<h4>','after_title'=>'</h4>'));
	register_sidebar(array('name'=>'Footer Mid Left','before_widget'=>'<div id="%1$s" class="widget %2$s">','after_widget'=>'</div>','before_title'=>'<h4>','after_title'=>'</h4>'));
	register_sidebar(array('name'=>'Footer Mid Right','before_widget'=>'<div id="%1$s" class="widget %2$s">','after_widget'=>'</div>','before_title'=>'<h4>','after_title'=>'</h4>'));
	register_sidebar(array('name'=>'Footer Right','before_widget'=>'<div id="%1$s" class="widget %2$s">','after_widget'=>'</div>','before_title'=>'<h4>','after_title'=>'</h4>'));

//	Load Content Limit
function the_content_limit($max_char, $more_link_text = 'Read More', $stripteaser = 0, $more_file = '') {

    $content = get_the_content($more_link_text, $stripteaser, $more_file);
    $content = apply_filters('the_content', $content);
    $content = str_replace(']]>', ']]&gt;', $content);
    $content = strip_tags($content);

   if (strlen($_GET['p']) > 0) {
      echo "<p>";
      echo $content;
      echo "&nbsp;<a href='";
      the_permalink();
      echo "'>"."Read More</a>";
      echo "</p>";
   }

   else if ((strlen($content)>$max_char) && ($espacio = strpos($content, " ", $max_char ))) {

        $content = substr($content, 0, $espacio);
        $content = $content;
        echo "<p>";
        echo $content;
        echo "...";
        echo "&nbsp;<a href='";
        the_permalink();
        echo "'>".$more_link_text."</a>";
        echo "</p>";
   }
   
   else {
      echo "<p>";
      echo $content;
      echo "&nbsp;<a href='";
      the_permalink();
      echo "'>"."Read More</a>";
      echo "</p>";

   }
}

//	Use a div ID, not CLASS, for wp_page_menu
add_filter('wp_page_menu', 'menu_class_to_div');
function menu_class_to_div($menu) {
	$menu = str_replace('<div class', '<div id', $menu);
	
	return $menu;
}

add_filter('wp_list_pages', 'organicthemes_list_pages');
function organicthemes_list_pages($output) {
	$include_pages = ot_option('include_pages');
	if(in_array('feed', (array)$include_pages))
		$output .= '<li class="feed"><a href="'.get_bloginfo('rss2_url').'">RSS Feed</a></li>';
	
	return $output;
}

//	Create a page checklist
function ot_page_checklist($name = '', $selected = array()) {
	global $settings;
	$pages = get_pages();

	//	home page
	if (in_array('home', (array)$selected)) $checked = 'checked'; else $checked = '';
	$checkboxes .= '<li><label class="selectit"><input type="checkbox" name="'.$name.'[]" value="home" '.$checked.' /> Home</label></li>'."\n";
	//	other pages
	foreach ($pages as $page) {
		if(in_array($page->ID, (array)$selected)) $checked = 'checked'; else $checked = '';
		$ancestors = get_post_ancestors($page); $indent = count($ancestors);
		$indent = 'style="margin-left: '.($indent * 15).'px;"';
		$checkboxes .= '<li '.$indent.'><label class="selectit"><input type="checkbox" name="'.$name.'[]" value="'.$page->ID.'" '.$checked.' /> ';
		$checkboxes .= $page->post_title."</label></li>\n";
	}
	//	feed link
	if (in_array('feed', (array)$selected)) $checked = 'checked'; else $checked = '';
	$checkboxes .= '<li><label class="selectit"><input type="checkbox" name="'.$name.'[]" value="feed" '.$checked.' /> RSS Feed</label></li>'."\n";
	
	echo $checkboxes;
}

//	Add thumbnail support
add_theme_support('post-thumbnails');
add_image_size( 'home-feature', 620, 380, true ); // Homepage Feature Image
add_image_size( 'home-thumbnail', 430, 430 ); // Homepage Mid Thumbnail
add_image_size( 'home-side', 180, 180, true ); // Homepage Sidebar Thumbnail
add_image_size( 'portfolio', 950, 1200, true ); // Portfolio Image

class Hackweekend {

  public static function uasort($a, $b) {
    return strcmp($a[0], $b[0]);
  }

  public static function participants_shortcode($atts) {
    $url = html_entity_decode($atts['url']);
    $type = isset($atts['type']) ? $atts['type'] : 'Confirmed';
    $handle = fopen($url, "r");

    $html = '<ul class="participants">';
    fgetcsv($handle);

    while ($row = fgetcsv($handle)) {
      $status = $row[4];
      if ($status != $type) {
        continue;
      }

      $name = $row[1].' '.$row[2];
      $role = $row[5];
      $url = '';
      $facebook = '';
      $github = '';
      $twitter = '';
      $image = 'http://a0.twimg.com/profile_images/1378522066/203616_185508028168161_4452354_n_normal.jpeg';

      if (!empty($row[15])) {
        $github = $row[15];
        $url = $github;
      }

      if (!empty($row[13])) {
        $twitter = $row[13];
        $url = "http://twitter.com/$twitter";
        $image = "https://api.twitter.com/1/users/profile_image/{$twitter}?size=normal";
      }

      if (!empty($row[14])) {
        $facebook = $row[14];
        if (intval($facebook) != 0) {
          $facebook = "/profile.php?id={$facebook}";
        }
        
        $url = "http://facebook.com/$facebook";
        $image = "https://graph.facebook.com/{$row[14]}/picture";
      }

      $html .= <<<HTML
        <li><a href="{$url}" class="alignleft" alt="{$name}" title="{$name}"><img src="{$image}" alt="{$name}" title="{$name}"/></a>
        <div>
          <strong><a href="{$url}" alt="{$name}" title="{$name}">{$name}</a></strong>
          <em>({$role})</em>
        </div>
        {$links}
        <div class="clear"></div></li>
HTML;
    }

    return $html."</ul>";
  }

}

add_shortcode('participants', array('Hackweekend', 'participants_shortcode'));
