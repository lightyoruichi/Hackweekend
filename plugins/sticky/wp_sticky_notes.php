<?php
/*
Plugin Name: Wordpress Sticky Notes
Plugin URI: http://greenorangestudios.com
Description: Adds a custom post type of interactive sticky notes, with custom settings. Requires PHP 5 or Higher
Version: 1.1
Author: Brennan Thompson
Author URI: http://greenorangestudios.com

Copyright 2010  Brennan Thompson  (email : brenjt@gmail.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if ( ! defined( 'WPSTICKY_PLUGIN_BASENAME' ) )
	define( 'WPSTICKY_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

if ( ! defined( 'WPSTICKY_PLUGIN_NAME' ) )
	define( 'WPSTICKY_PLUGIN_NAME', trim( dirname( WPSTICKY_PLUGIN_BASENAME ), '/' ) );

if ( ! defined( 'WPSTICKY_PLUGIN_DIR' ) )
	define( 'WPSTICKY_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . WPSTICKY_PLUGIN_NAME );

if ( ! defined( 'WPSTICKY_PLUGIN_URL' ) )
	define( 'WPSTICKY_PLUGIN_URL', WP_PLUGIN_URL . '/' . WPSTICKY_PLUGIN_NAME );

require_once(WPSTICKY_PLUGIN_DIR . '/admin/admin.php');
require_once(WPSTICKY_PLUGIN_DIR . '/shortcode.php');

if (!class_exists("wpStickyNotes")) {
class wpStickyNotes
{
	public $colors = array(
		'_sticky_note_01' => array('bg' => 'DAFE70', 'border' => 'C5FC57', 'text' => '000000'),
		'_sticky_note_02' => array('bg' => 'FFC465', 'border' => 'FCBB5D', 'text' => '000000'),
		'_sticky_note_03' => array('bg' => 'FEF276', 'border' => 'FDEB61', 'text' => '000000'),
		'_sticky_note_04' => array('bg' => '66B0EC', 'border' => '569AF9', 'text' => '000000'),
		'_sticky_note_05' => array('bg' => 'EC6EFD', 'border' => 'E761ED', 'text' => '000000'),
		'_sticky_note_06' => array('bg' => 'F96060', 'border' => 'F75050', 'text' => '000000')
	);
	public $shortcode;
	
	public function wpStickyNotes(){$this->__construct();}
	public function __construct()
	{
		
		register_activation_hook( __FILE__, array( &$this, 'install' ) );
        register_uninstall_hook( __FILE__, array( &$this, 'uninstall' ) );
		//add_action( 'init', array( &$this, 'init' ) );
		
		add_action( 'init', array( &$this, 'admin_init' ) );
		add_filter( 'get_the_excerpt', array( &$this, 'new_excerpt_more' ));
		
		add_shortcode( 'wp-sticky-notes', array( &$this, 'shortcode' ) );
		
		wp_register_style('sticky-notes-css', WPSTICKY_PLUGIN_URL. "/css/sticky-notes.css");
		wp_register_script('sticky-notes-admin', WPSTICKY_PLUGIN_URL. "/js/stickynotes-admin.js", "jquery");
		wp_register_script('sticky-notes-user', WPSTICKY_PLUGIN_URL. "/js/stickynotes-user.js", "jquery", true);
		wp_register_script('new_colorpicker', WPSTICKY_PLUGIN_URL.'/js/colorpicker.js');
		wp_register_script('jquery.livequery', WPSTICKY_PLUGIN_URL.'/js/jquery.livequery.js');
		add_action('wp_print_scripts', array(&$this, 'wp_print_scripts'));
		
		/* Ajax functions */
		add_action('wp_ajax_stickynote_create', array(&$this, 'stickynote_ajax_post_create'));
		add_action('wp_ajax_nopriv_stickynote_create', array(&$this, 'stickynote_ajax_post_create'));
		add_action('wp_ajax_stickynote_updateposition', array(&$this, 'stickynote_ajax_update_position'));
		add_action('wp_ajax_nopriv_stickynote_updateposition', array(&$this, 'stickynote_ajax_update_position'));
		add_action('wp_ajax_stickynote_post_comment', array(&$this, 'stickynote_ajax_post_comment'));
		add_action('wp_ajax_nopriv_stickynote_post_comment', array(&$this, 'stickynote_ajax_post_comment'));
		add_action('wp_ajax_get_comments_form', array(&$this, 'stickynote_get_comments_form'));
		add_action('wp_ajax_nopriv_get_comments_form', array(&$this, 'stickynote_get_comments_form'));
	}
	
	public function new_excerpt_more($more)
	{
		global $post;
		if($post->post_type == 'stickynote' && has_excerpt() && ! is_attachment())
		{
			return $more;
		}
		return $more;
	}
	
	public function wp_print_scripts()
	{
		global $post;
		if ( strstr( $post->post_content, '[wp-sticky-notes]' )) {
			wp_enqueue_script(array('jquery', 'jquery-ui-core','jquery-ui-draggable','jquery.livequery'));
	    	wp_enqueue_style('sticky-notes-css');
			wp_enqueue_script('sticky-notes-user', WPSTICKY_PLUGIN_URL. "/js/stickynotes-user.js", array("jquery"), "", true);
			echo "<script type='text/javascript'>
					var ajax_url = '".admin_url('admin-ajax.php')."';
					var stickynotes_pluginurl = '".WPSTICKY_PLUGIN_URL."';
				  </script>\n";
	  	}
	}
	
	public function stickynote_ajax_update_position()
	{
		$id = (int)$_POST['id'];
		$x = (int)$_POST['x'];
		$y = (int)$_POST['y'];
		$z = (int)$_POST['z'];
		
		$position = $x.'x'.$y.'x'.$z;
		
		update_post_meta($id, '_stickynote_position', $position);
		echo $id;
		exit;
	}
	
	/* Inserts stickynote into database via Ajax using wp_insert_post()*/
	public function stickynote_ajax_post_create()
	{
		if(ini_get('magic_quotes_gpc'))
		{
			$_POST['author'] = stripslashes($_POST['author']);
			$_POST['body'] = stripslashes($_POST['body']);
		}
		$author = mysql_real_escape_string(strip_tags($_POST['author']));
		$body = mysql_real_escape_string(strip_tags($_POST['body']));
		$title = mysql_real_escape_string(strip_tags($_POST['title']));
		$style = mysql_real_escape_string($_POST['style']);
		$zindex = mysql_real_escape_string($_POST['zindex']);
		$comments = mysql_real_escape_string($_POST['comments']);
		
		$my_post = array();
		$my_post['comment_status'] = $comments;
		$my_post['post_title'] = $title;
		$my_post['post_excerpt'] = $body;
		$my_post['post_status'] = 'publish';
		$my_post['post_author'] = $author;
		$my_post['post_type'] = 'stickynote';
		
		$newStickyNoteID = wp_insert_post($my_post);
		
		update_post_meta($newStickyNoteID, '_stickynote_style', $style);
		
		$position = '0x0x'.$zindex;
		update_post_meta($newStickyNoteID, '_stickynote_position', $position);
		$newStickyNoteID = 1;
		echo $newStickyNoteID;
		exit;
	}
	
	/* Inserts comment into database via Ajax */
	public function stickynote_ajax_post_comment(){
				
		if(ini_get('magic_quotes_gpc'))
		{
			$_POST['author'] = stripslashes($_POST['author']);
			$_POST['body'] = stripslashes($_POST['body']);
		}
		$body = mysql_real_escape_string($_POST['body']);
		$stickynote_ID = mysql_real_escape_string($_POST['stickynote_ID']);
		$author = mysql_real_escape_string($_POST['author']);
		$user_info = get_userdata($author);

		$time = current_time('mysql', $gmt = 0);
		
		$data = array(
			'comment_post_ID' => $stickynote_ID,
			'comment_author' => $user_info->user_login,
			'comment_author_email' => $user_info->user_email,
			'comment_author_url' => 'http://',
			'comment_content' => $body,
			'user_ID' => $author,
			'comment_date' => $time,
			'comment_date_gmt' => $time,
			'comment_approved' => 1,
		);
		wp_insert_comment($data);
		$author = ($user_info->user_login) ? '<a href="'.$user_info->user_url.'">'.$user_info->user_login.'</a>' : "Guest";
		echo '<li style="display:none;"><h2 class="stickynote-date">'.date('F jS, Y', time()).'</h2><br clear="all">'.$body.'<br><span style="font-size: 10px;">Comment by: '.$author.'</span></li>';
		exit;
	}

	
	/* Admin Initiation function */
	public function admin_init()
	{
		global $wpStickyNotes;
		$wpStickyNotes = new wpStickyNotes_custom_post_type($this);
	}
	
	public function shortcode()
	{
		global $wpStickyNotes_shortcode;
		$wpStickyNotes_shortcode = new wpStickyNotes_user($this);
		echo $wpStickyNotes_shortcode->setup_stickynotes();
	}
	
	public function stickynote_get_comments_form()
	{
		global $wpStickyNotes_shortcode;
		$id = mysql_real_escape_string($_POST['id']);
		//global $wpStickyNotes_shortcode;
		echo wpStickyNotes_user::get_comments_form($id);
		exit;
	}
	
	public function install() 
	{
		$this->do_colors();
		add_option('_stickynote_canvaswidth','100%');
		add_option('_stickynote_canvasheight','600px');
		add_option('_stickynote_defaulttext','There looks to be no sticky notes! Be the first, click the tab above and try her out.');
		add_option('_stickynote_posting','anyone');
		add_option('_stickynote_amount', '26');
	}
	
	private function do_colors()
	{
		foreach($this->colors as $key => $value)
		{
			$option_name = $key; 
			$newvalue = $value ;
			if ( get_option($option_name) != $newvalue) {
				update_option($option_name, $newvalue);
			} else {
				$deprecated = ' ';
				$autoload = 'no';
				add_option($option_name, $newvalue);
			}	
		}
	}

	private function uninstall() 
	{
		foreach($this->colors as $option)
		{
			delete_option($option);
		}
	}
}
}

if (class_exists("wpStickyNotes")) {
	$stickynotes = new wpStickyNotes();
}
?>