<?php

$options = new TopPage(array(
		'id' => 'youtube_with_style',
		'menu_title' => 'Youtube',
		'page_title' => 'Shortcode',
		'icon_url' => YT_URL . 'images/options_icon.png',
		'menu_slug' => 'youtube',
		'position' => 100,
	));

$options->addInput(array(
		'id' => 'player_width',
		'label' => 'Player Width',
		'desc' => 'Put the desired width of the player here.',
		'standard' => '320',
		'size' => 'small',
	));

$options->addInput(array(
		'id' => 'player_height',
		'label' => 'Player Height',
		'desc' => 'Put the desired height of the player here.',
		'standard' => '240',
		'size' => 'small',
	));

$options->addCheckbox(array(
		'id' => 'player_autoplay',
		'label' => 'Autoplay',
		'desc' => 'Enable or not?',
		'standard' => false,
	));

$options->addCheckbox(array(
		'id' => 'player_loop_media',
		'label' => 'Loop Videos',
		'desc' => 'Enable Video Looping (repeat)',
		'standard' => false,
	));

$options->addSlider(array(
		'id' => 'player_buffer_size',
		'label' => 'Player Buffersize (seconds)',
		'standard' => 0,
	));

$options->addCheckbox(array(
		'id' => 'player_fetch_thumbnail',
		'label' => 'Fetch Thumbnail',
		'desc' => 'Automatically Fetch Thumbnail and Import to Media Library',
		'standard' => false,
	));

$options->addSlider(array(
		'id' => 'player_volume',
		'label' => 'Player Volume.',
		'standard' => 70,
	));

$widget = new SubPager('youtube', 'Widget');

$widget->addInput(array(
		'id' => 'widget_username',
		'label' => 'Youtube Widget Username',
		'desc' => 'Put the desired youtube account username.',
		'standard' => 'fristopher',
		'size' => 'medium',
	));


$widget->addInput(array(
		'id' => 'widget_title',
		'label' => 'Youtube Widget Title',
		'desc' => 'Put the desired title for the widget.',
		'standard' => 'My Videos',
		'size' => 'medium',
	));

$widget->addInput(array(
		'id' => 'widget_width',
		'label' => 'Widget Player Width',
		'desc' => 'Put the desired height for the player widget.',
		'standard' => '320',
		'size' => 'small',
	));

$widget->addInput(array(
		'id' => 'widget_height',
		'label' => 'Widget Player Height',
		'desc' => 'Put the desired width for the player widget.',
		'standard' => '240',
		'size' => 'small',
	));

$widget->addDropdown(array(
		'id' => 'widget_order',
		'label' => 'Sort Order',
		'desc' => 'Order which the Widget Videos will be shown',
		'standard' => 'viewCount',
		'options' => array(
			'published' => 'published',
			'view count' => 'viewCount',
			'rating' => 'rating',
		),
	));

$widget->addSlider(array(
		'id' => 'widget_num',
		'label' => 'How many videos to show?',
		'standard' => 5,
	));


$ytgallery = new SubPager('youtube', 'Gallery');

$ytgallery->addInput(array(
		'id' => 'gallery_player_width',
		'label' => 'Gallery Player Width',
		'desc' => 'Put the desired width of the player here.',
		'standard' => '320',
		'size' => 'small',
	));

$ytgallery->addInput(array(
		'id' => 'gallery_player_height',
		'label' => 'Gallery Player Height',
		'desc' => 'Put the desired height of the player here.',
		'standard' => '240',
		'size' => 'small',
	));

$ytgallery->addRadiobuttons(array(
		'id' => 'gallery_titles',
		'label' => 'Display Titles',
		'standard' => 'below',
		'options' => array(
			'Above thumbnails' => 'above',
			'Below Thumbnails' => 'below',
		),
	));

?>
