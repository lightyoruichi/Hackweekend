<?php
/*
Template Name: Landing Page
*/
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">

<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<meta name="distribution" content="global" />
<meta name="robots" content="follow, all" />
<meta name="og:language" content="en" />
<meta name="verify-v1" content="7XvBEj6Tw9dyXjHST/9sgRGxGymxFdHIZsM6Ob/xo5E=" />

<!--Facebook Open Graph-->
<meta property="og:site_name" content="HackWeekend"/>
<meta property="og:title" content="<?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?>"/>
<meta property="og:description" content="Hackweekend is an invite-only 24 hour hackathon targeting the crème de la crème of local developers. Positioning itself as a catalyst for startup innovation and career positioning in the region, Hackweekend seeks to gather developers, designers and idea generators to network, brainstorm and convert ideas into reality."/>
<meta property="og:type" content="website"/>
<meta property="og:image" content="http://hack.weekend.my/wp-content/uploads/logo/hackweekend-emblem.jpg"/>
<meta property="fb:admins" content="664596657,593045411,2215867,722053034,13605072"/>
<meta property="fb:page_id" content="168750623185734"/>
<meta property="fb:app_id" content="188017334580577"/>
<meta property="og:url" content="http://hack.weekend.my "/> 
<script language="JavaScript" type="text/javascript">
<!-- Copyright 2005, Sandeep Gangadharan -->
<!-- For more free scripts go to http://www.sivamdesign.com/scripts/ -->
<!--

if (document.getElementById) {
document.writeln('<style type="text/css"><!--')
document.writeln('.texter {display:none} @media print {.texter {display:block;}}')
document.writeln('//--></style>') }

function openClose(theID) {
if (document.getElementById(theID).style.display == "block") { document.getElementById(theID).style.display = "none" }
else { document.getElementById(theID).style.display = "block" } }
// -->
</script>

<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?></title>
<link rel="Shortcut Icon" href="<?php echo bloginfo('template_url'); ?>/favicon.ico" type="image/x-icon" />

<?php // if(is_front_page()) {
// this is to make sure Facebook uses our HW emblem for sharing
// if you uncomment the logic, it will limit it to the front page only
// if it breaks ask Kevin >_< or Mr. Facebook ?>
<link rel="image_src" href="http://hack.weekend.my/wp-content/uploads/2011/05/hackweekend-emblem.jpg" />
<?php // } ?>

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />

<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom Feed" href="<?php bloginfo('atom_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
<?php wp_enqueue_script("jquery"); ?>
<?php wp_head(); ?>

<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/superfish/superfish.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/superfish/hoverIntent.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery.flow.1.1.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/iepngfix_tilebg.js"></script>



<script type="text/javascript">

    twttr.anywhere(function (T) {
    T.hovercards();
  });
</script>
<!--IE6 Fix-->
<style type="text/css">
    img, div, a, input, body, span { 
        behavior: url(<?php bloginfo('template_url'); ?>/images/iepngfix.htc);
    }
</style>

<script type="text/javascript"> 
    var $j = jQuery.noConflict();
    $j(document).ready(function() { 
        $j('ul.ot-menu').superfish(); 
    });
</script>

<script type="text/javascript">
    $j(function() {
        $j("div#controller").jFlow({
            slides: "#slides",
            width: "620px",
            height: "440px",
            timer: <?php echo ot_option('slider_interval'); ?>,
            duration: 400
        });
    });
</script>

</head>

<body>
<div id="fb-root"></div><script src="http://connect.facebook.net/en_US/all.js#appId=188017334580577&amp;xfbml=1"></script>
<div id="wrap">

<div id="content">

	<div id="contentwide">
    
        <div align="center">    
        
        <img src="http://hack.weekend.my/wp-content/uploads/2011/07/hackweekend-logo-header-11.png">
        <br><br>

        </div>

            <div class="posttitle" align="center">
                <h1><?php the_title(); ?></h1>
            </div>

        <div class="postarea">

            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            
            <?php the_content(__('Read More'));?>
            <div style="clear:both;"></div>
            <?php edit_post_link('(Edit)', '', ''); ?>
            
            <?php endwhile; else: ?>
            <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
            <?php endif; ?>
        </div>
        
        <div class="postcomments">
        </div>
		
	</div>
			
</div>



<?php get_footer(); ?>