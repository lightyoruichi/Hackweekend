<?php

class wpStickyNotes_user
{
	private $main;
	private $colors;
	private $selected_style;
	
	public function wpStickyNotes_user($mainClass){__construct($mainClass);}
	public function __construct($mainClass)
	{
		$this->main = $mainClass;
		$this->colors = $this->main->colors;
	}
	
	public function setup_stickynotes()
	{
		global $wpdb, $post, $current_user;
      	get_currentuserinfo();
		
		$canvaswidth = get_option('_stickynote_canvaswidth');
		$canvaswidth = ($canvaswidth == NULL || $canvaswidth == "")? "100%" : $canvaswidth;
		$canvasheight = get_option('_stickynote_canvasheight');
		$canvasheight = ($canvasheight == NULL || $canvasheight == "")? "600px" : $canvasheight;
		$defaulttext = get_option('_stickynote_defaulttext');
		$posting = get_option('_stickynote_posting');
		$stickynote_amount = get_option('_stickynote_amount');
		
		echo $this->setup_colors();
		
		$sticknote_query = new WP_Query('post_type=stickynote&status=publish&posts_per_page='.$stickynote_amount);		
		
		// Main holder for the Sticky Notes
		$output .= "<div id='stickynote-main' style='width:$canvaswidth; height:$canvasheight;'>";
		
		$output .= "<div id='add_sticky_note'>";
		if($posting == 'anyone' || $current_user->ID == 1 || current_user_can( 'manage_options' ) || ($posting == 'loggedinusers' && is_user_logged_in())):
		// Start Add Sticky Note Form
		$output .= "<div class='main_identify'></div>";
		$output .= "<div id='add_sticky_note-content'>";
				
				/* New Sticky Note Preview */
				$output .= '<div id="sticknote-preview">';
				$output .= '<div class="stickynote '.array_rand($this->colors, 1).' box-shadow">';
				$output .= '<div class="stickynote_comments_data">';
				$output .= '<ul class="stickynote-body">';
				$output .= '<li><h2 class="stickynote-date">'. date('F jS, Y', time()).'</h2><br clear="all" />';
				$output .= '<span class="stickynote-content"></span></li>';
				
				$output .= '<div class="stickynote-title"></div>';
				$output .= '<span class="stickynote-id"></span>';
				$output .= '</ul>';
				$output .= '</div>';
				$output .= "<div class='identify'></div>";
				$output .= "<a class='pr-stickynote-commentsbutton' style='display:none'></a>";
				$output .= '</div></div>';
				
			$output .= '<div id="sticknote-data">';
			$output .= '<form action="" method="post" class="sticknote_createnote-form stickynote-form">';
	
			$output .= '<label for="note-name">'. __('Title').' <span class="stickynote-title-count">&nbsp;</span></label>';
			$output .= '<input tabindex="1" type="text" name="stickynote-title" autocomplete="off" id="stickynote-title" class="pr-stickynote-title" value="" />';
			
			$output .= '<label for="stickynote-content">'.__('Text').' <span class="stickynote-content-count">&nbsp;</span></label>';
			$output .= '<textarea tabindex="2" name="stickynote-content" id="stickynote-content" class="pr-stickynote-content" autocomplete="off"></textarea>';
			
			$output .= '<input type="hidden" name="stickynote-author" id="stickynote-author" class="pr-stickynote-author" value="'.$current_user->ID.'" />';
			
			$output .= '<label>Style </label><br clear="all" />';
			$colorint = 1;
			foreach($this->colors as $option => $colors)
			{
				$output .= "<div class='color-box-box color-box-".$colorint."' style='background: #".$colors['bg']."; border-color: #".$colors['border']."; color: #".$colors['text'].";' rel='$option'> A </div>";				
				$colorint++;
			}			
			$output .= '<div style="height:4px"></div>';
			$output .= '<a id="stickynote-submit" tabindex="4" onclick="jQuery(this).closest(\'form\').submit();">'. __('Stick It!').'</a><br clear="all" />';
			$output .= '<label for="stickynote-comments"><input type="checkbox" name="stickynote-comments" id="stickynote-comments" tabindex="3" class="pr-stickynote-comments" autocomplete="off" /> Allow others to comment on note?</label>';
			$output .= '</form>';
			
		$output .= "<a id='stickynote-toggle' class='box-shadow'>+ Create Sticky Note</a>";
		$output .= "</div>";
		
		$output .= "</div>";
		// End Add Sticky Note Form
		endif;
		
		$output .= "</div>";
		
		if ( $sticknote_query->have_posts() ) : while ( $sticknote_query->have_posts() ) : $sticknote_query->the_post();
		
		$style = get_post_meta($post->ID, '_stickynote_style');
		$position = get_post_meta($post->ID, '_stickynote_position', true);
		
		/* Parse Coordinates on Canvas */
		$left='';
		$top='';
		$zindex='';
		
		// The xyz column holds the position and z-index in the form 200x100x10:
		list($left,$top,$zindex) = explode('x',$position);
			
		$output .= '<div class="stickynote '.$style[0].' box-shadow" style="left:'.$left.'px; top:'.$top.'px; z-index:'.$zindex.'">';
		$output .= '<div class="stickynote_comments_data">';
		$output .= '<ul class="stickynote-body">';
		$output .= '<li><h2 class="stickynote-date">'. get_the_time('F jS, Y').'</h2><br clear="all" />';
		$query = "SELECT post_excerpt FROM wp_posts WHERE ID = " . $post->ID . " LIMIT 1";
	  	$result = $wpdb->get_results($query, ARRAY_A);
		$output .= '<span class="stickynote-content">'.convert_smilies(strip_tags($result[0]['post_excerpt'])).'</span></li>';
		
		if(	comments_open( get_the_ID() ) == true ):
		$output .= $this->doComments(get_the_ID());
		endif;
		
		$output .= '</ul>';
		if(get_comments_number( get_the_ID() ) > 0):
		$output .= '<a class="stickynote-leftarrow"></a>';
		$output .= '<a class="stickynote-rightarrow"></a>';
		endif;
		$output .= '<div class="stickynote-title">'.get_the_title().'</div>';
		$output .= '<span class="stickynote-id">'.get_the_ID().'</span>';
		
		$output .= '</div>';
		if(	comments_open( get_the_ID() ) == true ):
		if($posting == 'anyone' || $current_user->ID == 1 || current_user_can( 'manage_options' ) || ($posting == 'loggedinusers' && is_user_logged_in())):
		$output .= "<div class='identify'></div>";
		$output .= "<a class='stickynote-commentsbutton'></a>";
		$output .= $this->get_comments_form(get_the_ID());
		
		endif;
		endif;
		$output .= '</div>';
		
		endwhile; else:
		
		// If no sticky notes displays one sticky note with 'Default Text'
		$canvaswidth = $this->divide($canvaswidth);
		$canvasheight = $this->divide($canvasheight);
		
		$output .= '<div class="stickynote _sticky_note_01 box-shadow" style="left:'.$canvaswidth.';top:'.$canvasheight.'">';
		$output .= '<div class="stickynote_comments_data">';
		$output .= '<ul class="stickynote-body">'; 
		$output .= '<li><h2 class="stickynote-date">'. date('F jS, Y', time()).'</h2><br clear="all" />';
		$output .= '<div class="stickynote-content">'.$defaulttext.'</div>';
		$output .= '<div class="stickynote-title">'.get_bloginfo('name').'</div></li>';
		$output .= '</ul>';
		$output .= '</div>';
		$output .= '</div>';
		
		endif;
				
		//Reset Query
		wp_reset_query();
		$output .= "</div>";
		
		return $output;
	}
	
	private function setup_colors()
	{
		foreach($this->colors as $option => $colors)
		{
			$this->colors[$option] = get_option($option, $colors);
		}
		
		$output .= "<style type='text/css'>";
		
		$count = 1;
		foreach($this->colors as $color)
		{
			$output .= "._sticky_note_0".$count."{".
						"background-color: #".$color['bg']." !important;". 
						"border-color: #".$color['border']." !important;".
						"color: #".$color['text']." !important;".
						"}";
			$output .= "._sticky_note_0".$count." .stickynote_comment-submit{".
						"color: #".$color['border']." !important;".
						"border-color: #".$color['border']." !important;".
						"}";
			$output .= "._sticky_note_0".$count." .stickynote_comments_form textarea, 
						._sticky_note_0".$count." .stickynote_comments_form input{".
						"border-color: #".$color['border']." !important;".
						"}";
			$count++;
		}
		$output .= "</style>";
		
		return $output;
	}
	
	private function divide($string)
	{
		$num = preg_replace('`[^0-9]*?`', '', $string);$sym = preg_replace('`[0-9]*?`', '', $string);
		$num = $num / 2;
		$string = $num.''.$sym;
		return $string;
	}
	
	public function get_comments_form($post_id)
	{
		global $current_user, $wpdb;
		get_currentuserinfo();
		$comments_form = "<form class='stickynote_comments_form stickynote-form' method='post' action=''>";
		$comments_form .= "<input type='hidden' name='stickynote_comment-author' class='stickynote_comment-author' value='". $current_user->ID."' />";
		$comments_form .= "<h3 class='stickynote_comments-title'>Post comment</h3><br clear='all' />";
		$comments_form .= "<textarea rows='4' cols='10' class='stickynote_comment-comment' name='stickynote_comment-comment' autocomplete='off' style='border:1px solid #".$this->colors['border'].";'></textarea>";
		$comments_form .= "<span class='stickynote-count'></span>";
		$comments_form .= "<input type='hidden' value='".$post_id."' name='stickynote_comment-ID' class='stickynote_comment-ID'>";
		$comments_form .= '<a class="stickynote_comment-submit" onclick="jQuery(this).closest(\'form\').submit();">'. __('Submit').'</a><br clear="all" />';
		$comments_form .= "</form>";
		return $comments_form;
	}
	
	private function doComments($post_id)
	{
		global $post;
		$comment_array = array_reverse(get_comments("post_id=".$post_id."&post_ID=".$post_id."&status=1"));
		/*echo "<pre>";
		var_dump($comment_array);
		echo "</pre>";*/
		if($comment_array){
			$comment_count = 1;
			foreach($comment_array as $comment){
				$timestamp = strtotime($comment->comment_date);
				$author = ($comment->comment_author) ? '<a href="'.$comment->comment_author_url.'">'.$comment->comment_author.'</a>' : "Guest";
				$output .= '<li><h2 class="stickynote-date">'.date('F jS, Y',$timestamp).'</h2><br clear="all" />';
				$output .= $comment->comment_content.'<br />';
				$output .= '<span style="font-size:10px;">Comment by: '.$author.'</a></span></li>';
				$comment_count++;
			}
		}
		return $output;
	}
}
?>