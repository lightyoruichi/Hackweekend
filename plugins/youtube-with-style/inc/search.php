<?php

function youtube_media_fetch_feed($uri) {
	if (function_exists('curl_init')) {
		$ch = curl_init ($uri) ;
        	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1) ;
        	$res = curl_exec ($ch) ;
        	curl_close ($ch) ;
	}
	else if ("1" == ini_get("allow_url_fopen")) {
	    $res =  file_get_contents($uri);	
	}
	else {
		$res = '';
	}

	return $res;
}

function youtube_search_video() {
	if (isset($_POST['uri'])) {
		$uri = $_POST['uri'];
	}
	else {
		$q = isset($_POST['q']) ? urlencode($_POST['q']) : 'wordpress';
		$orderby = isset($_POST['orderby']) ? $_POST['orderby'] : 'relevance';
		$uri = "http://gdata.youtube.com/feeds/api/videos?q=$q&orderby=$orderby&max-results=12&v=2&alt=json";
	}
	
	$feed = youtube_media_fetch_feed($uri);
	@header('Content-type: application/json; charset=UTF-8');
	die($feed);
}

add_action('wp_ajax_search_video', 'youtube_search_video');

function youtube_media_tab($tabs) {
        return array(
            'youtube' =>  'Youtube'
        );
}

function youtube_media_button() {
	global $post_ID, $temp_ID;
	$icon = YT_URL . 'images/media_icon.png';
        $uploading_iframe_ID = (int) (0 == $post_ID ? $temp_ID : $post_ID);
        $media_upload_iframe_src = "media-upload.php?post_id=$uploading_iframe_ID";
        echo "<a href=\"{$media_upload_iframe_src}&amp;tab=youtube&amp;TB_iframe=false&amp;height=300&amp;width=640\" class=\"thickbox\" title=\"Add Videos via You Tube\"><img src=\"{$icon}\" /></a>\n";
}

add_action('media_buttons', 'youtube_media_button', 20);

function media_search_video_form() {
	add_filter('media_upload_tabs', 'youtube_media_tab');
        media_upload_header();
        $post_id = $_GET['post_id'];
        include(YT_DIR. 'inc/search-video.php');
}

function youtube_media_search() {
	wp_iframe('media_search_video_form');
}

add_action('media_upload_youtube', 'youtube_media_search');
