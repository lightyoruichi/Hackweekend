<?php

function youtube_media_init() {
	if ( !is_admin() ) {

		wp_enqueue_script('jquery');
		wp_enqueue_script('swfobject');

		wp_register_script('youtube_gallery',  YT_URL . 'js/fixyt.js');
		wp_enqueue_script('youtube_gallery');

		wp_register_style('youtube_gallery_css', YT_URL . 'css/gallery.css'); 
		wp_enqueue_style('youtube_gallery_css');

		wp_register_style('youtube_widget_css', YT_URL . 'css/widget.css'); 
		wp_enqueue_style( 'youtube_widget_css');

   		if(is_active_widget('youtube_widget')) {
			wp_register_style('highslide', YT_URL . 'highslide/highslide.css');
			wp_enqueue_style('highslide');
			wp_register_script('highslide', YT_URL . 'highslide/highslide-with-html.packed.js', false); 
			wp_enqueue_script('highslide');
		}
	}
}

function youtube_admin_scripts() {
 	$player = YT_URL . 'inc/player.swf';
   	echo '<script type="text/javascript"> var player = "'.$player.'";</script>';

    	wp_register_script('json_sans_eval', YT_URL . 'js/json-sans-eval.js');
    	wp_enqueue_script('json_sans_eval');

    	wp_register_script('youtube_search_video', YT_URL . 'js/search-video.js');
    	wp_enqueue_script('youtube_search_video');

}

function youtube_admin_styles() {
 	wp_register_style('youtube_media_search_video_css', YT_URL . 'css/search.css');
 	wp_enqueue_style('youtube_media_search_video_css');
}

function youtube_add_highslide() {
	if(is_active_widget('youtube_widget') && (!is_admin())) {
	echo '
	<script type="text/javascript">
		hs.graphicsDir = "'.YT_URL.'highslide/graphics/";
		hs.outlineType = "rounded-white";
		hs.outlineWhileAnimating = true;
		hs.showCredits = false;
		hs.wrapperClassName = "draggable-header no-footer";
		hs.allowSizeReduction = false;
		hs.preserveContent = false;
	</script>
	';
	}
}

add_action('init','youtube_media_init');
add_action('admin_print_scripts','youtube_admin_scripts');
add_action('admin_print_styles','youtube_admin_styles');
add_action('wp_head', 'youtube_add_highslide');
