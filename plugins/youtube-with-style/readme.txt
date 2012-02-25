=== Youtube with Style ===
Contributors: Chris McCoy
Donate link: http://wp.am
Tags: video,youtube,search,widget,media,post,shortcode,admin,gallery
Requires at least: 3.0
Tested up to: 3.1
Stable tag: trunk

You Tube with Style lets you post Youtube videos in a stylish way while taking advantage of Youtube hosting your content.

== Description ==

<blockquote>
You Tube with Style is a plugin I created at first for myself, because I wanted to show You Tube videos on my site(s) without using the ugly default player You Tube has.

You Tube with Style lets you insert shortcodes via your post/page screen, and even search for You Tube videos via the You Tube API, so you never have to leave your site to find videos to post.
</blockquote>

<b>IMPORTANT!</b>

This plugin requires PHP5, and Wordpress 3.0 and Above.

You Tube API Important Links:

* <a href="http://code.google.com/apis/youtube/terms.html" title="Youtube API TOS">Youtube API Terms of Service</a>
* <a href="http://code.google.com/apis/youtube/2.0/developers_guide_protocol.html" title="Youtube API Developers Guide">Youtube API Developers Guide</a>
* <a href="http://code.google.com/apis/youtube/getting_started.html">Getting Started with the Youtube API</a>

Other Links for getting in touch:

* <a href="http://wp.am" title="You Tube with Style Author Site">You Tube with Style Plugin Author and Support</a>

= Features =

* Shortcode : You can add Youtube videos via shortcodes in your posts/pages
* Widget : Show your uploaded youtube videos in your sidebar
* Thumbnails: Ability to grab thumbnails from Youtube and Automatically add to the Media Library
* Quick Tag: Insert the Short Code via a post/page button
* AJAX Youtube Search: Search via the Post/Page Screen to quickly add videos without leaving your site.
* Lightbox : View your videos in a Highslide Lightbox for widgets and galleries.
* Galleries : Show a list of Youtube Videos with ease.
* Custom CSS: Easily Alter the style for the Widget and Gallery Style

== Credits ==

Copyright 2009-2011 by CHris McCoy (email: chris@lod.com)

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

== Installation ==

1. Install & Activate the plugin

2. Go to your post/page an enter the tag `[youtube]videoid[/youtube]` 

See more in the FAQ section.

== Screenshots ==

1. Screenshot Plugin Options
2. Screenshot AJAX You Tube Post Search
3. Screenshot Post Screen
4. Screenshot Example of You Tube with Style in Action

== Frequently Asked Questions ==

<b>Remember this plugin requires PHP5 and Wordpress 3.0 and above.</b>

When writing a page/post, you can use the follow tags:

* `[youtube]videoid[/youtube]`

example:

* `[youtube]eBGIQ7ZuuiU[/youtube]`

You can force the width and height, thumbnail, and autoplay of the player with the following shortcode: (this overrides the values in the settings panel)

* `[youtube width="400" height="300"]eBGIQ7ZuuiU[/youtube]`

These formats also work for showing a youtube video.

* `[youtube]http://www.youtube.com/watch?v=eBGIQ7ZuuiU[/youtube]`
* `[youtube]http://www.youtube.com/v/eBGIQ7ZuuiU[/youtube]`

== Changelog == 
= V8.2 =
* NEW: Check for required PHP5, Curl, and Simplexml extensions

= V8.1 =
* Changed: Fixed register_sidebar_widget to wp_register_sidebar_widget

= V8.0 =
* NEW: Entire Plugin redone, fixed all known issues and bugs.
* Bugfix : AJAX Search with regards to json
* Bugfix : Overidden Shortcode variables
* Changed: Quicktag Button on Post Screen
* Changed: You Tube Search has its own Icon on Post/Page Screen

== Upgrade Notice ==

= 8.0 =
Please Deactivate the previous version, remove the directory, then upload the new version and activate, as the plugin was totally overhauled and has a different directory and file structure.

== Support ==
For support contact chris@lod.com

