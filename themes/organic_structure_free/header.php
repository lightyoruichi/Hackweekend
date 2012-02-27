<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">

<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<meta name="distribution" content="global" />
<meta name="robots" content="follow, all" />
<meta name="language" content="en" />
<meta name="verify-v1" content="7XvBEj6Tw9dyXjHST/9sgRGxGymxFdHIZsM6Ob/xo5E=" />

<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?></title>
<link rel="Shortcut Icon" href="<?php echo bloginfo('template_url'); ?>/images/favicon.ico" type="image/x-icon" />

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom Feed" href="<?php bloginfo('atom_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
<?php wp_enqueue_script("jquery"); ?>
<?php wp_head(); ?>

<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/superfish/superfish.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/superfish/hoverIntent.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/iepngfix_tilebg.js"></script>


<!--IE6 Fix-->
<style type="text/css">
	img, div, a, input, body, span { 
		behavior: url(<?php bloginfo('template_url'); ?>/images/iepngfix.htc);
	}
</style>

<script type="text/javascript"> 
	var $j = jQuery.noConflict();
	$j(document).ready(function() { 
		$j('.menu').superfish(); 
	});
</script>

</head>

<body <?php if(function_exists('body_class')) body_class(); ?>>

<div id="wrap">

    <div id="header">
    
        <div class="headerleft">
            <p id="title"><a href="<?php echo get_option('home'); ?>/" title="Home"><?php bloginfo('name'); ?></a></p>
        </div>
        
        <div class="headerright">
            <form id="searchformheader" method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input type="text" value="Search Here and Press Enter" name="s" id="searchbox" onfocus="if (this.value == 'Search Here and Press Enter') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Search Here and Press Enter';}" />
            <input type="hidden" id="searchbutton" value="Go" /></form>
        </div>
    
    </div>
    
    <div id="navbar">
		<?php if ( function_exists('wp_nav_menu') ) { // Check for 3.0+ menus
		wp_nav_menu( array( 'title_li' => '', 'depth' => 4, 'container_class' => 'menu' ) ); }
		else {?>
		<ul class="menu"><?php wp_list_pages('title_li=&depth=4'); ?></ul>
		<?php } ?>
    </div>
    
    <div style="clear:both;"></div>