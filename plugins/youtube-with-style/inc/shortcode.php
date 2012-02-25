<?php

function youtube_shortcode($attr,$content){  
    global $post;
    $fileLoc = YT_URL . 'inc';
    $nwidth = get_option('player_width');
    $nheight = get_option('player_height');
    $nauto = get_option('player_autoplay');
    $buffersize = get_option('player_buffer_size');
    $volume = get_option('player_volume');
    $loopmedia = get_option('player_loop_media');

    $thumbnail = "$fileLoc/img.php?v=$content";
    
    extract(shortcode_atts(array(
        'width'      => $nwidth,
        'height'     => $nheight,
        'thumb'     => '',
        'auto'       => $nauto,
    ), $attr));

       if(get_option('player_fetch_thumbnail') == "true") {
			if ($attr['thumb']=="") {
        			$custom = get_post_custom($post->ID);
        			$thumb = $custom["_video_thumbnail"][0];
			}
			else $thumb = $attr['thumb'];
	}
	else {
		if ($attr['thumb']=="") $thumb = $thumbnail;
	}
	$regex  = "/(?:(?:http:\/\/)?(?:www\.)?youtube\.com\/)?(?:(?:watch\?)?v=|v\/)?([a-zA-Z0-9\-\_]{11})(?:&[a-zA-Z0-9\-\_]+=[a-zA-Z0-9\-\_]+)*/";
	if(preg_match_all($regex,$content,$matches,PREG_SET_ORDER)) {
		$content = $matches[0][1];
	}
	$alt = "http://www.youtube.com/watch?v=$content";

        if (is_feed()) {
		$show = '<a href="'.$alt.'"><img src="'.$thumb.'"></a>';
		return $show;
	} 

    else {
	static $counter = 1;
	return '
	<script type="text/javascript">
		var flashvars = {};
		flashvars.playOnStart = "'.$auto.'";
		flashvars.startVolume = "'.$volume.'";
		flashvars.autoHideOther = "false";
		flashvars.autoHideVideoControls = "false";
		flashvars.onStartShowControls = "true";
		flashvars.fullVideoScale = "true";
		flashvars.showPlayButton = "true";
		flashvars.loopMedia = "'.$loopmedia.'";
		flashvars.bufferSize = "'.$buffersize.'";
		flashvars.share = "false";
		flashvars.MediaLink = "http://www.youtube.com/watch?v='.$content.'";
		flashvars.image = "'.$thumb.'";
		var params = {};
		params.bgcolor = "#000000";
		params.allowfullscreen = "true";
		params.wmode = "opaque";
		var attributes = {};
		attributes.id = "myplayer";
		swfobject.embedSWF("' . $fileLoc . '/player.swf", "myAlternativeContent", "'.$width.'", "'.$height.'", "9.0.0", false, flashvars, params, attributes);
	</script> <div id="myAlternativeContent">'.$alt.'</div>';
     } 

     return $output;
} 

add_shortcode('youtube', 'youtube_shortcode');
