<?php
/*
Plugin Name: Youtube with Style
Plugin URI: http://wordpress.org/extend/plugins/youtube-with-style/
Description: Show You Tube videos with a custom stylish player, also create galleries, how user videos in widget form, and search in real time via the youtube api.
Date: January, 31st, 2011 
Version: 8.7
Author: Chris McCoy
Author URI: http://wp.am
Copyright: 2009-2011, Blog Kingpin Consulting.

    Copyright 2011 Chris McCoy (e-mail: chris@lod.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

define('YT_DIR', dirname(__FILE__) . '/' );
define('YT_URL', plugin_dir_url(__FILE__));

function youtube_with_style_check_notice() { ?>
    <div class='updated fade'>
        <p>The You Tube with Style plugin requires PHP5, and the Curl and Simplexml php extensions to work, please upgrade to use this plugin.</p>
    </div> 
<?php
}

if (version_compare(PHP_VERSION, '5.0.0', '<') || !extension_loaded('curl') || !extension_loaded('simplexml'))
{
        add_action('admin_notices', 'youtube_with_style_check_notice');
}

else {
	include(YT_DIR. 'inc/options.class.php');
	include(YT_DIR. 'inc/options.php');
	include(YT_DIR. 'inc/init.php');
	include(YT_DIR. 'inc/search.php');
	include(YT_DIR. 'inc/shortcode.php');
	include(YT_DIR. 'inc/widget.php');
	include(YT_DIR. 'inc/quicktag.php');
	include(YT_DIR. 'inc/gallery.php');
	include(YT_DIR. 'inc/thumbnails.php');
}

?>
