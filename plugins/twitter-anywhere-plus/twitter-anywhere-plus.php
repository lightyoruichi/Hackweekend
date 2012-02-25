<?php

/*

Plugin Name: Twitter @Anywhere Plus
Plugin URI: http://www.ngeeks.com/proyectos/twitter-anywhere-plus/
Description: This plugin allows you to easily add Twitter @Anywhere to your blog, enabling the @Anywhere features.
Version: 2.0
Author: GeekRMX
Author URI: http://www.ngeeks.com/
License: GPLv3

*************************************************************************

Copyright (C) 2010 nGeeks.com

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.

*************************************************************************

*/

load_plugin_textdomain('tap', false, dirname(plugin_basename( __FILE__ )).'/languages/');

// ADMIN MENU

add_action('admin_menu', 'twitter_anywhere_plus_menu');

function twitter_anywhere_plus_menu() {
	add_options_page('Twitter @Anywhere Plus', 'Twitter @Anywhere Plus', 'administrator', 'twitter-anywhere-plus', 'twitter_anywhere_plus_options');
}

function twitter_anywhere_plus_options() {
	
	if(isset($_POST['submit'])) {
		$api_key = $_POST['tap_api_key'];
		update_option('tap_api_key', $api_key);
		
		update_option('tap_shortener', $_POST['shortener']);
		update_option('tap_bitly_login', $_POST['bitly_login']);
		update_option('tap_bitly_key', $_POST['bitly_key']);
		
		if(isset($_POST['linkifyUsers'])) { update_option('tap_linkifyUsers', 'yes'); } else { update_option('tap_linkifyUsers', 'no'); }
		
		if(isset($_POST['hovercards'])) { update_option('tap_hovercards', 'yes'); } else { update_option('tap_hovercards', 'no'); }
		
		if(isset($_POST['followButton'])) { update_option('tap_followButton', 'yes'); } else { update_option('tap_followButton', 'no'); }
		update_option('tap_followButton_dom', $_POST['followButton_dom']);
		update_option('tap_followButton_user', $_POST['followButton_user']);
		
		if(isset($_POST['tweetBox'])) { update_option('tap_tweetBox', 'yes'); } else { update_option('tap_tweetBox', 'no'); }
		if(isset($_POST['tweetBox_dposts'])) { update_option('tap_tweetBox_dposts', 'yes'); } else { update_option('tap_tweetBox_dposts', 'no'); }
		if(isset($_POST['tweetBox_dpages'])) { update_option('tap_tweetBox_dpages', 'yes'); } else { update_option('tap_tweetBox_dpages', 'no'); }
		$tBwidth = (((int) $_POST['tweetBox_width']) == 0) ? '' : (int) $_POST['tweetBox_width'];
		$tBheight = (((int) $_POST['tweetBox_height']) == 0) ? '' : (int) $_POST['tweetBox_height'];
		update_option('tap_tweetBox_width', $tBwidth);
		update_option('tap_tweetBox_height', $tBheight);
		update_option('tap_tweetBox_label', $_POST['tweetBox_label']);
		update_option('tap_tweetBox_content', $_POST['tweetBox_content']);
		
		if(isset($_POST['cTweetBox'])) { update_option('tap_cTweetBox', 'yes'); } else { update_option('tap_cTweetBox', 'no'); }
		
		if(isset($_POST['retweet'])) { update_option('tap_retweet', 'yes'); } else { update_option('tap_retweet', 'no'); }
		if(isset($_POST['retweet_dposts'])) { update_option('tap_retweet_dposts', 'yes'); } else { update_option('tap_retweet_dposts', 'no'); }
		if(isset($_POST['retweet_dpages'])) { update_option('tap_retweet_dpages', 'yes'); } else { update_option('tap_retweet_dpages', 'no'); }
		update_option('tap_retweet_position', $_POST['retweet_position']);
		update_option('tap_retweet_label', $_POST['retweet_label']);
		update_option('tap_retweet_content', $_POST['retweet_content']);
		update_option('tap_retweet_bird', $_POST['retweet_bird']);
		
		echo '<div class="updated"><p><strong>'.__("Options saved.","tap").'</strong></p></div>';
	}
	
	$tap_api_key = get_option('tap_api_key');
	
	$tap_shortener = get_option('tap_shortener');
	$tap_bitly_login = get_option('tap_bitly_login');
	$tap_bitly_key = get_option('tap_bitly_key');
	
	$tap_linkifyUsers = get_option('tap_linkifyUsers');
	$tap_hovercards = get_option('tap_hovercards');
	
	$tap_followButton = get_option('tap_followButton');
	$tap_followButton_dom = get_option('tap_followButton_dom');
	$tap_followButton_user = get_option('tap_followButton_user');
	
	$tap_tweetBox = get_option('tap_tweetBox');
	$tap_tweetBox_dposts = get_option('tap_tweetBox_dposts');
	$tap_tweetBox_dpages = get_option('tap_tweetBox_dpages');
	$tap_tweetBox_width = get_option('tap_tweetBox_width');
	$tap_tweetBox_height = get_option('tap_tweetBox_height');
	$tap_tweetBox_label = get_option('tap_tweetBox_label');
	$tap_tweetBox_content = get_option('tap_tweetBox_content');
	
	$tap_cTweetBox = get_option('tap_cTweetBox');
	
	$tap_retweet = get_option('tap_retweet');
	$tap_retweet_dposts = get_option('tap_retweet_dposts');
	$tap_retweet_dpages = get_option('tap_retweet_dpages');
	$tap_retweet_position = get_option('tap_retweet_position');
	$tap_retweet_label = get_option('tap_retweet_label');
	$tap_retweet_content = get_option('tap_retweet_content');
	$tap_retweet_bird = get_option('tap_retweet_bird');

?>

<div class="wrap">
<h2>Twitter @Anywhere Plus</h2>

<form name="form1" method="post" action="">
<p><?php _e('In order to use @Anywhere, you must first register your blog for a free API key with Twitter.<br />You can do so at the following URL:','tap'); ?> <a href="http://dev.twitter.com/anywhere/apps/new" target="_blank">http://dev.twitter.com/anywhere/apps/new</a> (<strong><a href="http://wordpress.org/extend/plugins/twitter-anywhere-plus/faq/" target="_blank">FAQ</a></strong>)</p>
<p><?php _e("Your @Anywhere API key:","tap"); ?> <input type="text" name="tap_api_key" value="<?php echo $tap_api_key; ?>" size="30"></p>

<h3><?php _e('@Anywhere features','tap'); ?></h3>

<table style="width:580px; border:1px solid #999; border-radius: 10px; -ms-border-radius: 10px; -moz-border-radius: 10px; -webkit-border-radius: 10px; -khtml-border-radius: 10px;">
  <tr>
    <td style="padding:0px 10px 0px 10px;">
      <p><label><input type="checkbox" name="linkifyUsers" <?php if($tap_linkifyUsers == 'yes') { echo 'checked="checked"'; } ?> /> <strong><?php _e('Auto-linkification of @usernames','tap'); ?></strong></label></p>
      <p><small><?php _e('Turn Twitter usernames into links.','tap'); ?></small></p>
    </td>
  </tr>
</table>

<table style="width:580px; margin-top:10px; border:1px solid #999; border-radius: 10px; -ms-border-radius: 10px; -moz-border-radius: 10px; -webkit-border-radius: 10px; -khtml-border-radius: 10px;">
  <tr>
    <td style="padding:0px 10px 0px 10px;">
      <p><label><input type="checkbox" name="hovercards" <?php if($tap_hovercards == 'yes') { echo 'checked="checked"'; } ?> /> <strong><?php _e('Hovercards','tap'); ?></strong></label></p>
      <p><small><?php _e('Show hovercard when you move the mouse over a Twitter username.','tap'); ?></small></p>
    </td>
  </tr>
</table>

<table style="width:580px; margin-top:10px; border:1px solid #999; border-radius: 10px; -ms-border-radius: 10px; -moz-border-radius: 10px; -webkit-border-radius: 10px; -khtml-border-radius: 10px;">
  <tr>
    <td style="padding:10px; padding-top:0px;">
      <p><label><input type="checkbox" name="followButton" <?php if($tap_followButton == 'yes') { echo 'checked="checked"'; } ?> /> <strong><?php _e('Follow button','tap'); ?></strong></label></p>
      <p><small><?php _e('Show a follow button where you want it to be placed.','tap'); ?></small></p>
      <table border="0">
        <tr>
          <td><?php _e("Twitter username:","tap"); ?></td>
          <td><input type="text" name="followButton_user" value="<?php echo $tap_followButton_user; ?>" size="30"></td>
        </tr>
        <tr>
          <td><?php _e("DOM element:","tap"); ?></td>
          <td><input type="text" name="followButton_dom" value="<?php echo $tap_followButton_dom; ?>" size="30"></td>
        </tr>
        <tr>
          <td colspan="2"><small><?php _e("The <em>id</em> or <em>class</em> of the element (div, p) where the button must be inserted.","tap"); ?><br />
          <u><?php _e("Example:","tap"); ?></u><br />
          <?php _e("You can create a Text widget with the following code inside:","tap"); ?><br />
          <code>&lt;div id="followButton"&gt;&lt;/div&gt;</code> (<?php _e("DOM element:","tap"); ?> <code>#followButton</code>)<br />
          <?php _e("You can also use classes:","tap"); ?><br />
          <code>&lt;p class="followButton"&gt;&lt;/p&gt;</code> (<?php _e("DOM element:","tap"); ?> <code>.followButton</code>)</small>
          </td>
          </tr>
      </table>
    </td>
  </tr>
</table>

<table style="width:580px; margin-top:10px; border:1px solid #999; border-radius: 10px; -ms-border-radius: 10px; -moz-border-radius: 10px; -webkit-border-radius: 10px; -khtml-border-radius: 10px;">
  <tr>
    <td style="padding:10px; padding-top:0px;">
      <p><label><input type="checkbox" name="tweetBox" <?php if($tap_tweetBox == 'yes') { echo 'checked="checked"'; } ?> /> <strong><?php _e('Tweet Box','tap'); ?></strong></label></p>
      <p><small><?php _e('Show a tweet box below your posts or pages.','tap'); ?></small></p>
      <table border="0">
        <tr>
          <td colspan="2" style="padding-bottom:3px"><?php _e("Display in...","tap"); ?>&nbsp;&nbsp;<label style="vertical-align:text-top"><input style="vertical-align:text-top" type="checkbox" name="tweetBox_dposts" <?php if($tap_tweetBox_dposts != 'no') { echo 'checked="checked"'; } ?> /> <?php _e("Posts","tap"); ?></label>&nbsp;&nbsp;<label style="vertical-align:text-top"><input style="vertical-align:text-top" type="checkbox" name="tweetBox_dpages" <?php if($tap_tweetBox_dpages == 'yes') { echo 'checked="checked"'; } ?> /> <?php _e("Pages","tap"); ?></label></td>
        </tr>
        <tr>
          <td><?php _e("Width:","tap"); ?></td>
          <td><input type="text" name="tweetBox_width" value="<?php echo $tap_tweetBox_width; ?>" size="20"> <small><?php _e("Default:","tap"); ?> 515 (px)</small></td>
        </tr>
        <tr>
          <td><?php _e("Height:","tap"); ?></td>
          <td><input type="text" name="tweetBox_height" value="<?php echo $tap_tweetBox_height; ?>" size="20"> <small><?php _e("Default:","tap"); ?> 65 (px)</small></td>
        </tr>
        <tr>
          <td><?php _e("Label:","tap"); ?></td>
          <td><input type="text" name="tweetBox_label" value="<?php echo $tap_tweetBox_label; ?>" size="20"> <small><?php _e("Default:","tap"); ?> What's happening?</small></td>
        </tr>
        <tr>
          <td><?php _e("Content:","tap"); ?></td>
          <td><input type="text" name="tweetBox_content" value="<?php echo $tap_tweetBox_content; ?>" size="50"></td>
        </tr>
        <tr>
          <td colspan="2"><small><?php _e("You can use the following tags in the Tweet Box content:","tap"); ?><br />
          <code>%t</code> &raquo; <?php _e("Post title","tap"); ?><br />
          <code>%u</code> &raquo; <?php _e("Short URL","tap"); ?> <span style="color:#800000">*</span><br />
          <u><?php _e("Example:","tap"); ?></u> <code>%t - %u (via @nGeeksCom)</code></small></td>
          </tr>
      </table>
    </td>
  </tr>
</table>

<table style="width:580px; margin-top:10px; border:1px solid #999; border-radius: 10px; -ms-border-radius: 10px; -moz-border-radius: 10px; -webkit-border-radius: 10px; -khtml-border-radius: 10px;">
  <tr>
    <td style="padding:0px 10px 0px 10px;">
      <p><label><input type="checkbox" name="cTweetBox" <?php if($tap_cTweetBox == 'yes') { echo 'checked="checked"'; } ?> /> <strong><?php _e('Custom Tweet Boxes','tap'); ?></strong></label></p>
      <p><small><?php _e('Create alternative tweet boxes using the following shorcode:','tap'); ?> <code>[tweetbox]</code><br />
      <?php _e('You can use the shortcode in your posts or text widgets.','tap'); ?></small></p>
      <p><small><u><?php _e("Example:","tap"); ?></u><br />
      <code>[tweetbox width="200" height="150" label="Retweet!" content="%t - %u (via @nGeeksCom)"]</code></small></p>
      <table border="0" style="border-collapse:collapse;">
        <tr>
          <td style="border-bottom:1px solid black; border-right:1px solid black; padding:0px 30px 0px 5px;"><small><strong><?php _e("Attributes","tap"); ?></strong></small></td>
          <td style="border-bottom:1px solid black; padding-left:5px;"><small><?php _e("Default","tap"); ?></small></td>
        </tr>
        <tr>
          <td style="border-right:1px solid black; padding-left:5px"><small>width</small></td>
          <td style="padding-left:5px"><small>515</small></td>
        </tr>
        <tr>
          <td style="border-right:1px solid black; padding-left:5px"><small>height</small></td>
          <td style="padding-left:5px"><small>65</small></td>
        </tr>
        <tr>
          <td style="border-right:1px solid black; padding-left:5px"><small>label</small></td>
          <td style="padding-left:5px"><small><?php _e("What's happening?","tap"); ?></td>
        </tr>
        <tr>
          <td style="border-right:1px solid black; padding-left:5px"><small>content</small></td>
          <td style="padding-left:5px"><small><em><?php _e("empty","tap"); ?></em></small></td>
        </tr>
      </table>
      <p><small><?php _e("You can use the following tags in the content:","tap"); ?><br />
      <code>%t</code> &raquo; <?php _e("Post title","tap"); ?><br />
      <code>%u</code> &raquo; <?php _e("Short URL","tap"); ?> <span style="color:#800000">*</span></small></p>
    </td>
  </tr>
</table>

<table style="width:580px; margin-top:10px; border:1px solid #999; border-radius: 10px; -ms-border-radius: 10px; -moz-border-radius: 10px; -webkit-border-radius: 10px; -khtml-border-radius: 10px;">
  <tr>
    <td style="padding:10px; padding-top:0px;">
      <p><label><input type="checkbox" name="retweet" <?php if($tap_retweet == 'yes') { echo 'checked="checked"'; } ?> /> <strong><?php _e('Retweet button','tap'); ?></strong></label></p>
      <p><small><?php _e('Show a "Retweet" button on your posts or pages.<br />(Clicking the button will launch a Tweet Box with a Lightbox effect.)','tap'); ?></small></p>
      <table border="0">
        <tr>
          <td colspan="2" style="padding-bottom:3px"><?php _e("Display in...","tap"); ?>&nbsp;&nbsp;<label style="vertical-align:text-top"><input style="vertical-align:text-top" type="checkbox" name="retweet_dposts" <?php if($tap_retweet_dposts != 'no') { echo 'checked="checked"'; } ?> /> <?php _e("Posts","tap"); ?></label>&nbsp;&nbsp;<label style="vertical-align:text-top"><input style="vertical-align:text-top" type="checkbox" name="retweet_dpages" <?php if($tap_retweet_dpages == 'yes') { echo 'checked="checked"'; } ?> /> <?php _e("Pages","tap"); ?></label></td>
        </tr>
        <tr>
          <td colspan="2" style="padding-bottom:6px; padding-top:3px">
            <table border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><?php _e("Button position:","tap"); ?>&nbsp;&nbsp;</td>
                <td>
                    <table width="70" height="70" border="0" cellspacing="0" cellpadding="0" style="border:1px dashed #999; background:#FFF url(<?php echo plugins_url("/images/text.gif", __FILE__); ?>)">
                      <tr>
                        <td align="left" valign="top"><input name="retweet_position" type="radio" value="top-left" <?php if($tap_retweet_position == 'top-left') { echo 'checked="checked"'; } ?> title="<?php _e("Top-Left","tap"); ?>" /></td>
                        <td align="right" valign="top"><input name="retweet_position" type="radio" value="top-right" <?php if(($tap_retweet_position == 'top-right') || ($tap_retweet_position == '') || ($tap_retweet_position == 'top')) { echo 'checked="checked"'; } ?> title="<?php _e("Top-Right","tap"); ?>" /></td>
                      </tr>
                      <tr>
                        <td align="left" valign="bottom"><input name="retweet_position" type="radio" value="bottom-left" <?php if($tap_retweet_position == 'bottom-left') { echo 'checked="checked"'; } ?> title="<?php _e("Bottom-Left","tap"); ?>" /></td>
                        <td align="right" valign="bottom"><input name="retweet_position" type="radio" value="bottom-right" <?php if(($tap_retweet_position == 'bottom-right') || ($tap_retweet_position == 'bottom')) { echo 'checked="checked"'; } ?> title="<?php _e("Bottom-Right","tap"); ?>" /></td>
                      </tr>
                    </table>
                </td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td><?php _e("Label:","tap"); ?></td>
          <td><input type="text" name="retweet_label" value="<?php echo $tap_retweet_label; ?>" size="20"> <small><?php _e("Default:","tap"); ?> <?php _e("What's happening?","tap"); ?></small></td>
        </tr>
        <tr>
          <td><?php _e("Content:","tap"); ?></td>
          <td><input type="text" name="retweet_content" value="<?php echo $tap_retweet_content; ?>" size="50"></td>
        </tr>
        <tr>
          <td colspan="2"><small><?php _e("You can use the following tags in the Tweet Box content:","tap"); ?><br />
          <code>%t</code> &raquo; <?php _e("Post title","tap"); ?><br />
          <code>%u</code> &raquo; <?php _e("Short URL","tap"); ?> <span style="color:#800000">*</span><br />
          <u><?php _e("Example:","tap"); ?></u> <code>%t - %u (via @nGeeksCom)</code></small></td>
        </tr>
        <tr>
          <td colspan="2" style="padding-top:3px"><?php _e("Twitter bird:","tap"); ?> &nbsp;<label style="vertical-align:text-top"><input style="vertical-align:text-top" name="retweet_bird" type="radio" value="1" <?php if(($tap_retweet_bird == '1') || ($tap_retweet_bird == '')) { echo 'checked="checked"'; } ?> /> <img src="<?php echo plugins_url("/lightdiv/twitter1.png", __FILE__); ?>"  border="0" align="absmiddle" /></label> &nbsp;&nbsp;<label style="vertical-align:text-top"><input style="vertical-align:text-top" name="retweet_bird" type="radio" value="2" <?php if($tap_retweet_bird == '2') { echo 'checked="checked"'; } ?> /><img src="<?php echo plugins_url("/lightdiv/twitter2.png", __FILE__); ?>"  border="0" align="absmiddle" /></label> &nbsp;&nbsp;<label style="vertical-align:text-top"><input style="vertical-align:text-top" name="retweet_bird" type="radio" value="none" <?php if($tap_retweet_bird == 'none') { echo 'checked="checked"'; } ?> /><small> <?php _e("None","tap"); ?></small></label></td>
        </tr>
      </table>
    </td>
  </tr>
</table>

<script type="text/javascript">
function display_bitly() {
	document.getElementById("div-bitly").style.visibility = "visible";
	document.getElementById("div-isgd").style.visibility = "hidden";
	document.getElementById("div-none").style.visibility = "hidden";
}
function display_isgd() {
	document.getElementById("div-isgd").style.visibility = "visible";
	document.getElementById("div-bitly").style.visibility = "hidden";
	document.getElementById("div-none").style.visibility = "hidden";
}
function display_none() {
	document.getElementById("div-none").style.visibility = "visible";
	document.getElementById("div-isgd").style.visibility = "hidden";
	document.getElementById("div-bitly").style.visibility = "hidden";
}
</script>

<table style="width:580px; margin-top:15px; background-color:#FFF; border:1px solid #800000; border-radius: 10px; -ms-border-radius: 10px; -moz-border-radius: 10px; -webkit-border-radius: 10px; -khtml-border-radius: 10px;">
  <tr>
    <td style="padding:10px 10px 0px 10px;">
    <strong><?php _e('URL shortener:','tap'); ?></strong>&nbsp;&nbsp;<label onclick="display_bitly()" style="vertical-align:text-top"><input style="vertical-align:text-top" name="shortener" type="radio" value="bitly" <?php if($tap_shortener == 'bitly') { echo 'checked="checked"'; } ?> /> bit.ly</label>&nbsp;&nbsp;&nbsp;<label onclick="display_isgd()" style="vertical-align:text-top"><input style="vertical-align:text-top" name="shortener" type="radio" value="isgd" <?php if(($tap_shortener == 'isgd') || ($tap_shortener == '')) { echo 'checked="checked"'; } ?> /> is.gd</label>&nbsp;&nbsp;&nbsp;<label onclick="display_none()" style="vertical-align:text-top"><input style="vertical-align:text-top" name="shortener" type="radio" value="none" <?php if($tap_shortener == 'none') { echo 'checked="checked"'; } ?> /> <?php _e("None","tap"); ?></label>
    
    <div style="float:left;<?php if($tap_shortener != 'bitly') { echo ' visibility:hidden;'; } ?>" id="div-bitly">
    <p><?php _e('Username:','tap'); ?> <input type="text" name="bitly_login" value="<?php echo $tap_bitly_login; ?>" size="13">&nbsp;&nbsp;<?php _e('API key:','tap'); ?> <input type="text" name="bitly_key" value="<?php echo $tap_bitly_key; ?>" size="42"></p>
    <p><small><?php printf(__('In order to use this URL shortener, you must provide your own username and API key.<br />%1$sSign up for a bit.ly account%2$s. Once you register, you will find your API key %3$shere%2$s.','tap'), '<a href="http://bit.ly/a/sign_up" target="_blank">', '</a>', '<a href="http://bit.ly/a/your_api_key" target="_blank">'); ?></small></p>
    <p><small><?php _e("Example:","tap"); ?> <em>http://bit.ly/dtlXWC</em></small></p>
    </div>
    
    <div style="position:absolute; float:left;<?php if(($tap_shortener != 'isgd') && ($tap_shortener != '')) { echo ' visibility:hidden;'; } ?>" id="div-isgd">
    <p><small><?php _e("Example:","tap"); ?> <em>http://is.gd/dg4Im</em></small></p>
    </div>
    
    <div style="position:absolute; float:left;<?php if($tap_shortener != 'none') { echo ' visibility:hidden;'; } ?>" id="div-none">
    <p><small><?php _e("Example:","tap"); ?> <em><?php echo get_bloginfo('url').'/?p=ID'; ?></em></small></p>
    </div>
    </td>
  </tr>
</table>

<p class="submit"><input type="submit" class="button-primary" name="submit" value="<?php _e('Save changes','tap'); ?>" /></p>
</form>

<p><?php _e('This plugin has been developed by <strong>GeekRMX</strong>.','tap'); ?></p>
<p><a href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=paypal%40ngeeks%2ecom&lc=ES&item_name=Twitter%20%40Anywhere%20Plus&item_number=WordPress%20Plugin&cn=Your%20name%20and%20website%3f&no_shipping=1&currency_code=EUR&bn=PP%2dDonationsBF%3abtn_donate_SM%2egif%3aNonHosted" target="_blank"><img src="<?php echo WP_PLUGIN_URL.'/'.dirname(plugin_basename( __FILE__ )).'/images/paypal.gif'; ?>" alt="Donate"  border="0" /></a></p>
<p><strong><?php _e('Website:','tap'); ?></strong> <a href="http://www.ngeeks.com" target="_blank">nGeeks.com</a></p>
</div>

<?php
}

// ADD TWITTER @ANYWHERE PLUS

add_action('wp_head','TwitterAnywherePlus');
add_filter('the_content','tweetBoxDiv');
add_filter('the_content','retweetButton');
add_filter('the_posts', 'enqueueFiles');

if ( (get_option('tap_cTweetBox') == 'yes') && (get_option('tap_api_key') != '') ) {
	add_shortcode('tweetbox', 'cTweetBox');
	add_filter('widget_text', 'do_shortcode');
}

function enqueueFiles($posts) {
	if ( !is_admin() && (get_option('tap_api_key') != '') ) {
		if ( (get_option('tap_retweet') == 'yes') && condTags('retweet') ) {
			wp_enqueue_style("lightdiv", plugins_url("/lightdiv/lightdiv.css", __FILE__));
			wp_enqueue_script("lightdiv", plugins_url("/lightdiv/lightdiv.js", __FILE__), array('jquery'));
		}
		if ( (get_option('tap_tweetBox') == 'yes') && condTags('tweetBox') ) {
			wp_enqueue_script("twitteranywhereplus", plugins_url("twitter-anywhere-plus.js", __FILE__), array('jquery'));
		}
		if ( get_option('tap_cTweetBox') == 'yes' ) {
			wp_enqueue_script("jquery");
		}
	}
	
	return $posts;
}

function tweetBoxContent($tbcontent) {
	global $wp_query;
	
	$title = $wp_query->post->post_title;
	$title = str_replace("\\", "\\\\", $title);
	$title = str_replace('"', '\"', $title);
	
	$id = $wp_query->post->ID;
	$url = get_permalink($id);
	
	if(get_option('tap_shortener') == 'bitly') {
		$response = bitly_shortener($url);
		if (strpos($response,'http://') === false) {
			$url = get_bloginfo('url').'/?p='.$wp_query->post->ID;
		} else {
			$url = $response;
		}
	} else if((get_option('tap_shortener') == '') || (get_option('tap_shortener') == 'isgd')) {
		$response = isgd_shortener($url);
		if (strpos($response,'http://') === false) {
			$url = get_bloginfo('url').'/?p='.$wp_query->post->ID;
		} else {
			$url = $response;
		}
	} else {
		$url = get_bloginfo('url').'/?p='.$wp_query->post->ID;
	}
	
	$tbcontent = str_replace('%t', $title, $tbcontent);
	$tbcontent = str_replace('%u', $url, $tbcontent);
	
	return $tbcontent;
}

function bitly_shortener($url) {
	$bitly_login = get_option('tap_bitly_login');
	$bitly_key = get_option('tap_bitly_key');
	if(($bitly_login == '') && ($bitly_key == '')) {
		$bitly_login = 'twitteranywhereplus';
		$bitly_key = 'R_2855ea83fd022384e42af4e08fef0357' ;
	}
	
	$bitly_login = urlencode(trim($bitly_login));
	$bitly_key = urlencode(trim($bitly_key));
	$url_encoded = urlencode($url);
	
	$response = trim(wp_remote_retrieve_body(wp_remote_get("http://api.bit.ly/v3/shorten?login={$bitly_login}&apiKey={$bitly_key}&uri={$url_encoded}&format=txt")));
	
	return $response;
}

function isgd_shortener($url) {
	$url_encoded = urlencode($url);
	$response = trim(wp_remote_retrieve_body(wp_remote_get("http://is.gd/api.php?longurl={$url_encoded}")));
	return $response;
}

function TwitterAnywherePlus($post_id) {
	
	$tap_api_key = get_option('tap_api_key');
	
	if($tap_api_key != '') {
		$version = '1';
		$output = '
<!-- Twitter @Anywhere Plus v2.0 by GeekRMX - http://www.ngeeks.com -->
<script src="http://platform.twitter.com/anywhere.js?id='.$tap_api_key.'&v='.$version.'" type="text/javascript"></script>
<script type="text/javascript">
twttr.anywhere(function (T) {
// configure the @anywhere environment
'.anywhereOptions().'});
</script>'.jsOptions().cssOptions().'
<!-- /Twitter @Anywhere Plus -->
';
		
		echo $output;
	}
}

function anywhereOptions() {
	
	$selected_options = '';
	
	if(get_option('tap_linkifyUsers') == 'yes') {
		$selected_options .= 'T.linkifyUsers();'."\n";
	}
	
	if(get_option('tap_hovercards') == 'yes') {
		$selected_options .= 'T.hovercards();'."\n";
	}
	
	$tap_followButton_dom = get_option('tap_followButton_dom');
	$tap_followButton_user = get_option('tap_followButton_user');
	
	if( (get_option('tap_followButton') == 'yes') && ($tap_followButton_dom != '') && ($tap_followButton_user != '') ) {
		$selected_options .= 'T("'.$tap_followButton_dom.'").followButton("'.$tap_followButton_user.'");'."\n";
	}
	
	$tap_tweetBox_height = get_option('tap_tweetBox_height');
	$tap_tweetBox_width = get_option('tap_tweetBox_width');
	$tap_tweetBox_label = get_option('tap_tweetBox_label');
	$tap_tweetBox_content = get_option('tap_tweetBox_content');
	
	if( (get_option('tap_tweetBox') == 'yes') && condTags('tweetBox') ) {
		
		$selected_options .= 'T("#tweetBox").tweetBox({'."\n";
		if($tap_tweetBox_height != '') $selected_options .= 'height: '.$tap_tweetBox_height.','."\n";
		if($tap_tweetBox_width != '') $selected_options .= 'width: '.$tap_tweetBox_width.','."\n";
		if($tap_tweetBox_label != '') $selected_options .= 'label: "'.$tap_tweetBox_label.'",'."\n";
		if($tap_tweetBox_content != '') $selected_options .= 'defaultContent: "'.tweetBoxContent($tap_tweetBox_content).'",'."\n";
		if( ($tap_tweetBox_height != '') || ($tap_tweetBox_width != '') || ($tap_tweetBox_label != '') || ($tap_tweetBox_content != '') ) {
			$selected_options = rtrim($selected_options, ",\n");
			$selected_options .= "\n";
		}
		$selected_options .= '});'."\n";
	}
	
	return $selected_options;
}

function jsOptions() {
	
	$options = '';
	
	if( (get_option('tap_retweet') == 'yes') && condTags('retweet') ) {
		$rtLabel = (get_option('tap_retweet_label') == '') ? __("What's happening?","tap") : get_option('tap_retweet_label');
		$rtContent = tweetBoxContent(get_option('tap_retweet_content'));
		
		$options .= '
<script type="text/javascript">
/* <![CDATA[ */
var TwitterAnywherePlus = {
	rtLabel: "'.$rtLabel.'",
	rtContent: "'.$rtContent.'"
};
/* ]]> */
</script>';
	}
	
	return $options;
}

function cssOptions() {
	
	$options = '';
	
	if( (get_option('tap_retweet') == 'yes') && condTags('retweet') && (get_option('tap_retweet_bird') != 'none') ) {
		$bird = (get_option('tap_retweet_bird') == '2') ? '2' : '1';
		
		$options .= '
<style type="text/css">
<!--
#lightdiv .twitter-bird {
	background-image: url('.plugins_url("/lightdiv/twitter".$bird.".png", __FILE__).');
}
-->
</style>';
	}
	
	return $options;
}

function tweetBoxDiv($content) {
	if( (get_option('tap_tweetBox') == 'yes') && (get_option('tap_api_key') != '') && condTags('tweetBox') ) {
		return $content.'<div id="tweetBox" style="text-align:center"></div>';
	}
	else
	{
		return $content;
	}
}

function cTweetBox($atts) {
	extract(shortcode_atts(array(
		"height" => '65',
		"width" => '515',
		"label" => __("What's happening?","tap"),
		"content" => ''
	), $atts));
	
	$ramdom = rand();
	$content = tweetBoxContent($content);
	
	return '
<!-- Twitter @Anywhere Plus -->
<div class="cTweetBox-'.$ramdom.'"></div>
<script type="text/javascript">
  twttr.anywhere(function (T) {
	T(".cTweetBox-'.$ramdom.'").tweetBox({
	  height: '.$height.',
	  width: '.$width.',
	  label: "'.$label.'",
	  defaultContent: "'.$content.'"
	});
  });
  jQuery(document).ready(function($) {
	$(".cTweetBox-'.$ramdom.'").mouseover(function() {
		$(".cTweetBox-'.$ramdom.' > .twitter-anywhere-tweet-box")[0].contentWindow.document.getElementById("tweet-box").focus();
	});
  });
</script>
<!-- /Twitter @Anywhere Plus -->
';
}

function retweetButton($content) {
	if( (get_option('tap_retweet') == 'yes') && (get_option('tap_api_key') != '') && condTags('retweet') ) {
		
		$position = get_option('tap_retweet_position');
		if(strpos($position,'left') !== false) {
			$lr = 'l';
		} else {
			$lr = 'r';
		}
		$button = '<div id="lightdiv-button-div-'.$lr.'"><a href="#retweet"><img id="lightdiv-button" src="'.plugins_url("/images/retweet.png", __FILE__).'" border="0"></a></div>';
		
		if(strpos($position,'bottom') === false) {
			$content = $button."\n".$content;
		} else {
			$content = $content."\n".$button;
		}
	}
	
	return $content;
}

function condTags($element) {
	$display = false;
	if($element == 'tweetBox') {
		$display = ((get_option('tap_tweetBox_dposts') != "no") && is_single()) || ((get_option('tap_tweetBox_dpages') == "yes") && is_page());
	}
	if($element == 'retweet') {
		$display = ((get_option('tap_retweet_dposts') != "no") && is_single()) || ((get_option('tap_retweet_dpages') == "yes") && is_page());
	}
	return $display;
}

?>