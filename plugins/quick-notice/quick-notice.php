<?php 
/**
 * @package Quick Notice
 * @author Shaon
 * @version 1.0.5
 */
/*
Plugin Name: Quick Notice Bar
Plugin URI: http://www.wpeden.com/
Description: Display important message/notice from site admin to visitor
Author: Shaon
Version: 1.0.5
Author URI: http://www.wpeden.com/
*/
 

$plugindir = str_replace('\\','/',dirname(__FILE__));
 

define('PLUGINDIR',$plugindir);  

function wpqn_install(){      
    add_option('wpp_redirect', true); 
    
}

function wpqn_redirect(){
    if (get_option('wpp_redirect', false)) {
        delete_option('wpp_redirect');
        wp_redirect(home_url('/wp-admin/admin.php?page=quick-notice'));
    }
}


function wpqn_save_notice(){
    if($_POST['notice']) {
       update_option('_wpqn_notice', $_POST['notice']);       
       update_option('_wpqn_disabled', $_POST['_wpqn_disabled']);       
   }
   die('Notice Updated');
} 

 function wpqn_save_notice_settings(){
    if($_POST['action']=='wpqn_save_notice_settings') {
       update_option('_wpqn_twitter', $_POST['twitter']);       
       update_option('_wpqn_facebook', $_POST['facebook']);       
       update_option('_wpqn_custom_code', $_POST['custom_code']);       
   }
   die('Notice Updated');
} 

 
function wpqn_admin_options(){   
    $notice = get_option('_wpqn_notice');
    include("tpls/setup.php");
}

function wpqn_settgins(){   
    $notice = get_option('_wpqn_notice');
    include("tpls/settings.php");
}

function wpqn_archive(){   
    $notice = get_option('_wpqn_notice');
    include("tpls/archive.php");
}

function wpqn_show_notice(){
    if(get_option('_wpqn_disabled',0)==1) return;
    $notice = get_option('_wpqn_notice');
?>
<link href='http://fonts.googleapis.com/css?family=<?php echo $notice['font']; ?>&v1' rel='stylesheet' type='text/css'>
<style type="text/css">
.wpqn{
<?php echo $notice['bg_css']?stripcslashes($notice['bg_css']):"background: #6d0019;background: -moz-linear-gradient(top, #6d0019 0%, #a90329 74%);background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#6d0019), color-stop(74%,#a90329));background: -webkit-linear-gradient(top, #6d0019 0%,#a90329 74%);background: -o-linear-gradient(top, #6d0019 0%,#a90329 74%);background: -ms-linear-gradient(top, #6d0019 0%,#a90329 74%);filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#6d0019', endColorstr='#a90329',GradientType=0 );background: linear-gradient(top, #6d0019 0%,#a90329 74%);"; ?>
border-bottom: 3px solid #fff;
-moz-box-shadow: 0 0 5px #888;
-webkit-box-shadow: 0 0 5px#888;
box-shadow: 0 0 5px #888;
z-index:999999;
font-size: <?php echo $notice['font_size']?$notice['font_size']:'12'; ?>pt; 
font-family: '<?php echo str_replace("+"," ",$notice['font']); ?>';
text-align: center;
color: <?php echo $notice['color']?$notice['color']:'#ffffff'; ?>;
font-weight: <?php echo $notice['font_weight']?$notice['font_weight']:'normal'; ?>;
line-height: 35px;
}
.wpqn_down{
<?php echo $notice['bg_css']?stripcslashes($notice['bg_css']):"background: #6d0019;background: -moz-linear-gradient(top, #6d0019 0%, #a90329 74%);background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#6d0019), color-stop(74%,#a90329));background: -webkit-linear-gradient(top, #6d0019 0%,#a90329 74%);background: -o-linear-gradient(top, #6d0019 0%,#a90329 74%);background: -ms-linear-gradient(top, #6d0019 0%,#a90329 74%);filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#6d0019', endColorstr='#a90329',GradientType=0 );background: linear-gradient(top, #6d0019 0%,#a90329 74%);"; ?>
border-bottom: 3px solid #fff;
border-left: 3px solid #fff;
border-right: 3px solid #fff;
-moz-box-shadow: 0 0 5px #888;
-webkit-box-shadow: 0 0 5px#888;
box-shadow: 0 0 5px #888;
z-index:999999;
font-size: <?php echo $notice['font_size']?$notice['font_size']:'12'; ?>pt; 
font-family: '<?php echo str_replace("+"," ",$notice['font']); ?>';
text-align: center;
color: <?php echo $notice['color']?$notice['color']:'#ffffff'; ?>;
font-weight: <?php echo $notice['font_weight']?$notice['font_weight']:'normal'; ?>;
height: 35px;
-webkit-border-bottom-right-radius: 6px;
-webkit-border-bottom-left-radius: 6px;
-moz-border-radius-bottomright: 6px;
-moz-border-radius-bottomleft: 6px;
border-bottom-right-radius: 6px;
border-bottom-left-radius: 6px;
}
.wpqn a{
   color: <?php echo $notice['color']?$notice['color']:'#ffffff'; ?>; 
}

/*body{
    margin-top: 40px;
}*/

</style>
  <div style="width: 100%;position: fixed;top:0px;left:0px" class="wpqn" id="wpqn">
  <div style="position: absolute;margin: 5px 0 0 10px">
  <a href="http://facebook.com/hackweekend" target="_blank"><img src='<?php echo plugins_url(); ?>/quick-notice/images/facebook.png' title="We're in facebook" height="24" /></a>
  <a href="#" onclick="window.open('https://twitter.com/share?original_referer=http%3A%2F%2Fwww.hackweekend.com%2F&source=tweetbutton&text=<?php echo $notice['link_label']; ?>&url=http://hackweekend.com&via=hackweekend','window 1','height=250,width=550');return false;"><img src='<?php echo plugins_url(); ?>/quick-notice/images/twitter.png' title="Tweet this" height="24" /></a>
  <a href="<?php echo get_option('_wpqn_twitter'); ?>" target="_blank"><img src='<?php echo plugins_url(); ?>/quick-notice/images/twitter_follow_me_65b.png' title="Follow me on twitter" height="24" /></a>
  <?php echo get_option('_wpqn_custom_code'); ?>
  </div>
  <?php echo htmlspecialchars_decode(stripcslashes($notice['message'])); ?>&nbsp;&nbsp;&nbsp;&nbsp;
  <?php if($notice['url']!=''){ ?>
  <a href='<?php echo $notice['url']; ?>'><?php echo $notice['link_label']; ?></a>
  <div style="float: right;margin-right: 50px;">
  <!--<div id="fb-root"></div><script src="http://connect.facebook.net/en_US/all.js#appId=139844432762974&amp;xfbml=1"></script><fb:like href="" send="false" layout="button_count" width="100" show_faces="false" font="segoe ui"></fb:like>-->
  <iframe scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height: 24px; align: left; margin: 7px 0px 2px 0px;float:right;" allowtransparency="true" src="http://www.facebook.com/plugins/like.php?href=http://facebook.com/hackweekend&amp;layout=button_count&amp;show_faces=false&amp;width=150&amp;action=like&amp;colorscheme=light"></iframe>
  </div>  
  <?php } ?>
  <img src="<?php echo plugins_url(); ?>/quick-notice/images/up.png" style="position: absolute;cursor:pointer;right:0px;margin-right: 20px;margin-top: 2px;"  onclick="jQuery('#wpqn').slideUp(function(){jQuery('#wpqn_down').slideDown();});" />
  </div>
  
  <div style="width: 40px;position: fixed;top:0px;cursor:pointer;right:0px;margin-right: 15px;display: none;" class="wpqn_down" id="wpqn_down">
  <img src="<?php echo plugins_url(); ?>/quick-notice/images/down.png" onclick="jQuery('#wpqn_down').slideUp(function(){jQuery('#wpqn').slideDown();});" />
  </div>
  
<?php    
}


function wpqn_menu(){
    add_menu_page("Quick Notice","Quick Notice",'administrator','quick-notice','wpqn_admin_options');    
    add_submenu_page('quick-notice', 'Setup a Notice', 'Setup', 'administrator', 'quick-notice', 'wpqn_admin_options');    
    /*add_submenu_page('quick-notice', 'Quick Notice Archive', 'Archive', 'administrator', 'quick-notice/archive', 'wpqn_archive');    */
    add_submenu_page('quick-notice', 'Quick Notice Settings', 'Settgins', 'administrator', 'quick-notice/settings', 'wpqn_settgins');    
    
}

if(is_admin()){
    add_action("admin_menu","wpqn_menu");
    wp_enqueue_script("jquery");
    wp_enqueue_script("jquery-form",plugins_url().'/wordpress-perfection/jquery.form.js');    
    add_action('wp_ajax_wpqn_save_notice','wpqn_save_notice');
    add_action('wp_ajax_wpqn_save_notice_settings','wpqn_save_notice_settings');
}else{
    add_action('wp_footer','wpqn_show_notice');
}
 

register_activation_hook(__FILE__,'wpqn_install');
add_action('admin_init','wpqn_redirect');