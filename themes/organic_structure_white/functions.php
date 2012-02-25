<?php
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
