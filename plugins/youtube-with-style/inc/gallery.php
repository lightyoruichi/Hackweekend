<?php

global $youtube_gallery_count, $youtube_gallery_ID;
$youtube_gallery_count = 0;
$youtube_gallery_ID = 0;

function youtube_gallery( $atts, $youtubelinks = null ) {
	global $youtube_gallery_count, $youtube_gallery_ID;
	$myplayer = YT_URL . 'inc/player.swf';
	$youtubelinks = explode("\n", $youtubelinks);
	array_pop($youtubelinks);
	array_shift($youtubelinks);
	$x = $youtube_gallery_count;
	$youtube_gallery_ID++;
	$showgallery = ('<div id="youtube_gallery_'.$youtube_gallery_ID.'" class="youtube_gallery"><div class="youtube_gallery_divider"></div><br />'."\n");
	foreach ( $youtubelinks as $thumbnails ):
		$x++;
		if(strstr($thumbnails, '|')) { $thumb = explode('|', $thumbnails); $captions = 'true'; }
		else { $thumb[1] = $thumbnails; $captions = ''; }

		$thumb[1] = str_replace('&#8211;', '--', $thumb[1]);
		if(strstr($thumb[1], '&')) $thumb[1] = substr($thumb[1], 0, strpos($thumb[1], '&'));
		$thumb[1] = str_replace('http://www.youtube.com/watch?v=', '', $thumb[1]);
		$thumb[1] = str_replace('http://www.youtube.com/v/', '', $thumb[1]);		
		$thumb[1] = str_replace('<br />', '', $thumb[1]);
		$thumb[1] = str_replace('<p>', '', $thumb[1]);
		$thumb[1] = str_replace('</p>', '', $thumb[1]);		
		$showgallery .= '<div id="youtube_gallery_item_'.$x.'" class="youtube_gallery_item">'."\n";
		if(get_option('gallery_titles') == 'above' && $thumb[0] ) $showgallery .= ('<p>'.$thumb[0].'</p>');

		$vlink = "http://www.youtube.com/watch?v=$thumb[1]";

        	if (is_feed()) {
                	$show.= '<a href="'.$vlink.'"><img src="http://img.youtube.com/vi/'.str_replace("\r", '', $thumb[1]).'/default.jpg" border="0"></a><br />';
        	}

		else {
		$showgallery .= <<<END
<a href="#" onclick="return hs.htmlExpand(this, { src: '$myplayer', objectType: 'swf', width: 560, objectWidth: 560, objectHeight: 280, maincontentText: 'You need to upgrade your Flash player',swfOptions: { version: '7' ,params: {wmode: 'transparent'}, flashvars: { playOnStart: 'true', MediaLink: '$vlink'},} } )" class="highslide">
END;
		$showgallery .= '<img src="http://img.youtube.com/vi/'.str_replace("\r", '', $thumb[1]).'/default.jpg" border="0"></a><br />';
		if(get_option('gallery_titles') == 'below' && $thumb[0] ) $showgallery .= ('<p>'.$thumb[0].'</p>');
		$showgallery .= '</div>'."\r";
		unset($thumb[0]);
		unset($thumb[1]);
}
	endforeach;
	$showgallery .= ('<div class="youtube_gallery_divider"></div><br clear="all" /></div>');
	$youtube_gallery_count = $x;

        if (is_feed()) {
                return $show;
        }
	else {
		return $showgallery;
	}
}

add_shortcode('youtubegallery', 'youtube_gallery');
