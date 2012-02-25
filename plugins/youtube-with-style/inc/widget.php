<?php

function youtube_widget($args) {
	extract($args);

	$width = get_option('widget_width');
	$height = get_option('widget_height');
	$title = get_option('widget_title');
	$username = get_option('widget_username');
	$num = get_option('widget_num');
	$sortorder = get_option('widget_order');
	$videos = youtube_widget_getvids($num, $username, $sortorder);
	$myplayer = YT_URL . 'inc/player.swf';

	echo $before_widget;
	echo $before_title . $title . $after_title;
	echo '<ul class="widget-videolisting">';

	foreach ($videos as $video) {
		$videolink = $video['url'];
		$vlink = trim($videolink,"&feature=youtube_gdata");
		$videothumb = $video['thumb'];
		$videotitle = $video['title']; 
		?>
		<li><a href="#" onclick="return hs.htmlExpand(this, { src: '<?php echo $myplayer;?>', objectType: 'swf', width: 560, objectWidth: 560, objectHeight: 280, maincontentText: 'You need to upgrade your Flash player',swfOptions: { version: '7' ,params: {wmode: 'transparent'}, flashvars: { playOnStart: 'true', MediaLink: '<?php echo $vlink;?>'},} } )" class="highslide"><img width="120" height="90" border="0" alt="<?php echo $videotitle;?>" src="<?php echo $videothumb;?>" /></a><p><?php echo $videotitle;?></p></li>
		<?php
	}

	echo  '</ul>';
	echo $after_widget;
}
	
function youtube_widget_getvids($num, $username, $sortorder = 'published') {
	$num_param = '&max-results='.$num;
	$url = 'http://gdata.youtube.com/feeds/api/videos?author='.$username.$num_param.'&orderby='.$sortorder;
	$sxml = simplexml_load_file($url);
	$i = 0;
	$videoobj;
	foreach ($sxml->entry as $entry) {
		if ($i == $num && !empty($num_param)) {
			break;
		}

	$media = $entry->children('http://search.yahoo.com/mrss/');

	if ($media->group->player && $media->group->player->attributes() && $media->group->thumbnail && $media->group->thumbnail[0]->attributes()) {
		$attrs = $media->group->player->attributes();
		$videoobj[$i]['url'] = (string) $attrs['url'];
		$attrs = $media->group->thumbnail[0]->attributes();
		$videoobj[$i]['thumb'] = (string) $attrs['url']; 
		$videoobj[$i]['title'] = (string) $media->group->title;
		$i++;
	}
	else {
		return null;
	}
	}
	return $videoobj;
}
	
wp_register_sidebar_widget('my_youtube_widget','YouTube Widget', 'youtube_widget');
