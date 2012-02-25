=== Twitter @Anywhere Plus ===
Contributors: GeekRMX
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=paypal%40ngeeks%2ecom&lc=ES&item_name=Twitter%20%40Anywhere%20Plus&item_number=WordPress%20Plugin&cn=Your%20name%20and%20website%3f&no_shipping=1&currency_code=EUR&bn=PP%2dDonationsBF%3abtn_donate_SM%2egif%3aNonHosted
Tags: shortcode, lightbox, button, retweet, tweet, sidebar, widget, social, javascript, anywhere, api, @anywhere, twitter
Requires at least: 2.7
Tested up to: 3.0
Stable tag: trunk

This plugin allows you to easily add Twitter @Anywhere to your blog, enabling the @Anywhere features.

== Description ==

This plugin allows you to easily add **Twitter @Anywhere** to your blog, enabling the @Anywhere features:

* Auto-linkification of @usernames
* Hovercards
* Follow button
* Tweet Boxes
* Retweet button

You can enable and configure each function from the plugin settings page:

* Customize the label, content and dimensions of your Tweet Boxes.
* Display the post title and short URL into the Tweet Box.
* Shorten your URLs with *bit.ly* or *is.gd*.
* Insert custom Tweet Boxes by using shortcodes.
* Clicking the Retweet button will launch a special Tweet Box with Lightbox effect ([screenshot](http://wordpress.org/extend/plugins/twitter-anywhere-plus/screenshots/)).
* Choose from two Twitter birds to be displayed above the Retweet Box :)

Languages:

* English (en_US)
* Spanish (es_ES)
* French (fr_CA)
* Belorussian (be_BY)

In order to use @Anywhere, you must first register your blog for a free API key with Twitter. You can do so at the following URL: http://dev.twitter.com/anywhere/apps/new ([FAQ](http://wordpress.org/extend/plugins/twitter-anywhere-plus/faq/))

[nGeeks.com](http://www.ngeeks.com)

== Screenshots ==

1. Retweet button (Tweet Box with Lightbox effect)
2. Auto-linkification of @usernames, Hovercards, Retweet button, Follow button, Tweet Box
3. Settings page

== Installation ==

1. Upload the `twitter-anywhere-plus` folder to the `/wp-content/plugins/` directory.
1. Activate the plugin through the `Plugins` page in your WordPress administration panel.
1. Enter your Twitter @Anywhere API key on the `Settings -> Twitter @Anywhere Plus` page.

== Frequently Asked Questions ==

= Where can I find more information about Twitter @Anywhere? =

http://dev.twitter.com/anywhere

= Where do I get a Twitter @Anywhere API key for my blog? =

http://dev.twitter.com/anywhere/apps/new

= How do I fill the form to create a new @Anywhere application? =

Example:

* Application Name: My blog
* Application Website: [http://www.myblog.com]()
* Callback URL: [http://www.myblog.com]()
* Default Access type: Read & Write

== Changelog ==

= 2.0 =
* Added new URL shortener: is.gd
* Now you must provide your own bit.ly username and API key.
* Retweet button can be placed in any corner of your posts.
* The container div of the Tweet Box is now centered.

= 1.9 =
* Added URL shortener (bit.ly)
* Fix: final comma in JavaScript array

= 1.8 =
* Display the Tweet Box and Retweet button either in posts or pages.
* Improved "Tweet" button enabling for all the Tweet Boxes.
* Fixed issue with Google Chrome when using more than one Tweet Box.

= 1.7 =
* Added custom Tweet Boxes by using shortcodes.
* More customizable Tweet Box content.
* Settings page improved.
* Added French translation by Charles Desaulniers ([Siliticx.ca](http://siliticx.ca))

= 1.6 =
* "Tweet" button enabled when mouse over the Tweet Box, and always enabled in the Retweet Box.
* Now "post title and short URL" works for everyone (`global $post` -> `global $wp_query`).

= 1.5 =
* Now you can choose between two Twitter birds or none.
* Improved Retweet button image (valid for any background color).

= 1.4 =
* Added Retweet button feature (Tweet Box with Lightbox effect).

= 1.3 =
* Added Tweet Box feature.

= 1.2 =
* Bugfix: newline before `<?php` (PHP warning)

= 1.1 =
* Added Belorussian translation by Marcis G. ([PC.DE](http://pc.de))

= 1.0 =
* Initial release.

== Translations ==

* English (en_US) [default]
* Spanish (es_ES)
* French (fr_CA) - [Charles Desaulniers](http://siliticx.ca)
* Belorussian (be_BY) - [Marcis G.](http://pc.de)

You can help translating the plugin into your language.
Use the `tap-default.po` file included with the plugin.