=== Mailing List ===
Contributors: zingiri
Donate link: http://www.zingiri.net/donations
Tags: mailing, mailing list, mail, email, contact, newsletter, subscription, marketing, phplist
Requires at least: 2.1.7
Tested up to: 3.2.1
Stable tag: 1.4.0

Mailing List is a powerful mailing list plugin based on phplist, the world's most popular open source email campaign manager. 

== Description ==

Mailing List is a powerful mailing list plugin based on phplist, the world's most popular open source email campaign manager. 
It is easy to install and use, and is seamlessly integrated with Wordpress. 

It is great for newsletters, publicity lists, notifications, and many other uses. 

The main features are:

* Write and send messages, and manage your mailing lists anywhere you are
* Designed to manage mailing lists with hundreds of thousands of subscribers but also excellent with smaller lists 
* Manages message delivery with a message queue, so no duplicate messages and no forgotten messages
* Tracking tells you how many users opened your email message
* Multiple subscribe Pages allow you to choose many different combinations of templates, languages, user attributes and lists
* Templates are completely customizable, and make further theme tuning a breeze.
* Subscriber attributes like 'name', 'country', and other personal information, are completely customizable
* Make each and every email message personalized with the subscribers name, country, or any other attribute
* Subscribers can be given the choice between text or html email messages
* Uses TinyMCE to edit messages
* Available in English, French, German, Spanish, Portuguese, Traditional Chinese, Dutch, Vietnamese and Japanese
* Multiple list administrators
* Every email message contains personalized URLs for subscribers to update their preferences or unsubscribe
* Bounce processing keeps your database clean of unused and non-existent email addresses
* CSV Import and Export
* Attachments can be uploaded and included in messages for download.
* Send your message as a PDF to ensure that your message is seen the way it was designed by all your subscribers
* Keep sending messages from your web server in the background
* Throttling can limit the load on your server so it doesn't overload
* Scheduled sending let you decide when the message is to be sent
* Send a message repeatedly for updated dynamic content and attachments

== Installation ==

1. Upload the `mailz` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to the Wordpress Settings page and find the Mailing List menu, click on install
4. You're now ready to start configuring your mailing lists

Please visit the [Zingiri](http://zingiri.net/forums/ "Zingiri Support Forum") for more information and support.

== Frequently Asked Questions ==

= I have more questions! =
Please visit the [Zingiri](http://zingiri.net/forums/ "Zingiri Support Forum") for more information and support.

== Screenshots ==

Screenshots are not yet available, anyway, just install the plugin and try it out, it's pretty easy.

== Upgrade notice ==

Simply upload the new version and go to the control panel to ugprade your version.
Don't forget to take a database backup before you upgrade!

== Other ==
Fixes applied in PHPlists:
* admin/connect.php: added a class to "Powered by" image
* index.php: moved hardcoded styling for div.adminmessage to zing.css
* config/config.php: various changes
* admin/defaultconfig.inc: modified default links for mailing list messages (unsubscribe, etc)
* admin/FCKEditor/editor/fckeditor.html: changed location of Loadscript
* admin/FCKEditor: fixed bug in phplist where phpxml tags are used instead of xml tags
* admin/header.inc: modified look and feel
* admin/styles/phplist.css: adapted styles to fit with Wordpress
* config/config.php: disabled Test mode
* config/header.inc: modified look and feel
* config/footer.inc: modified look and feel
* styles/phplist.css: adapted styles to fit with Wordpress

== Changelog ==

= 1.4.0 =
* Fixed issue with redirect URL's duplicating url path
* Fixed issue with 'Error:no access' showing after updating a configuration option

= 1.3.8 =
* Removed activation error display
* Fixed compatibility issue with Simple Facebook Connect plugin

= 1.3.7 =
* Changed verification on session_save_path
* Only start PHP session if no session started yet

= 1.3.6
* Changed message about PHP versions
* Fixed issue with tables renaming

= 1.3.5 =
* Removed debugging output
* Renamed phpList tables that were using the WP prefix only

= 1.3.4 =
* Added verification that PHP sessions are properly configured 
* Fixed RFI vulnerability
* Moved footer location to bottom of page
* Corrected minor syntax errors

= 1.3.3 =
* Only load Tiny MCE editor when required
* Fixed issue with load of admin styles phplist.css
* Generic Support Us function

= 1.3.2 =
* Fixed issue with 'No access' message being displayed when updating configuration and users
* Fixed issue in phplist with handling of GET and POST variables
* Corrected default blacklist and forward URL's at first installation
* Updated Support Us page
* Minor styling improvements
* Fixed issue with FCK Editor not loading in some cases
* Defaulted to Wordpress Tiny MCE editor instead of FCK Editor
* Added option to activate FCK Editor in phplist configuration page

= 1.3.1 =
* Fixed issue with Mailing List plugin deleting tables of the Zingiri Web Shop plugin upon uninstall
* Changed load of simplehtmldom script
* Fixed issues with plugin activation 

= 1.3.0 =
* Upgraded phplists to version 2.10.15
* Removed fix in admin/structure.php: changed length of index of user_blacklist_data (limited to 1000, i.e. 333 bytes in UTF-8)
* Updated donations link
* Uninstall plugin when deactivating
* Fixed issue with empty messages being created when adding new messages or editing existing ones
* First release to support Mailing List Pro extension

= 1.2.4 =
* Fixed issue with sort users not working

= 1.2.3 =
* Upgraded http.class.php
* Fixed issue with new messages not being saved correctly

= 1.2.2 =
* Changed name of cookies storage
* Fixed issues with redirects in zHttpRequest

= 1.2.1 =
* Update cURL class to avoid having to use the cache directory
* Enhanced management of logins to phplist application
* Rebranding
* Shortened plugin title

= 1.2.0 =
* Revamped the front and back end interfaces to fit better with Wordpress themes
* Added link to our Facebook fan page on the plugin control panel
* Added link to our Twitter account on the plugin control panel
* Added Paypal donation link on the plugin control panel
* Added link to our rate the plugin on Wordpress on the plugin control panel
* Added link to help information on the plugin control panel
* Verified compatibility with Wordpress 3.0.5
* Renamed plugin to Mailing List

= 1.1.2 =
* Removed definition of GetUserIp function which is not used and causes a conflict with Nextgen Gallery Voting plugin

= 1.1.1 =
* Added test on cache directory being writable
* Added new option to import all Wordpress users in a default mailing list
* Tested up to Wordpress version 3.0.4
* Fixed potential compatibility issue with other Zingiri plugins

= 1.1.0 =
* Fixed issue with editing of subscribe pages duplicating the page instead of updating it
* Added a check to see if CURL is installed
* Renamed plugin to ccMails
* Changed support site to http://choppedcode.com

= 1.0.0 = 
* Updated to work with Wordpress 3.0.1
* Fixed issue with editing of lists duplicating the list instead of simply updating it
* Fixed issue with user reconciliation features being directed to an unaccessible page
* Fixed issue with website url in PHPlist not being updated correctly. Should be siteurl rather than home url.
* Fixed issue with "Error: No such attribute: 0" when trying to add an attribute.
* Added display of version in control panel

= 0.9.4 =
* Fixed compatibility issue with ccTickets plugin
* Fixed issue with backslashes in front of single and double quotes

= 0.9.3 =
* Now uses dedicated phplist.css for front end, different from the one used in the admin back-end
* Cleaned up unused sidebar code
* Fixed issue with HTML links on mailing page

= 0.9.2 =
* Corrected footer (PHPlist instead of osTicket)
* Fixed issue with PHP magic quotes set to on in PHPlist

= 0.9.1 = 
* Fixed issue with pages and posts being shown as blank after activation of plugin
* Code clean up

= 0.8 =
* Fixed issue with max key length exceeded on table user_blacklist_data
* Fixed issue with plugin not installing on GoDaddy servers because of setting magic_quotes_gpc on in .htaccess file (moved to php.ini file)

= 0.7 =
* Fixed issue with options array not being initialized properly causing an installation problem

= 0.6 = 
* Forced admin user as default user that connects to PHPmail
* Added hourly cron job using WP scheduling functionality to process mail queue

= 0.5 =
* Adapted code to be compatible with PHP4
* Corrected issue when trying to upload files 

= 0.4 = 
* Fixed issue with admin login to PHPlist back-end

= 0.3 = 
* Better initialisation of default configuration options

= 0.2 =
* First release

= 0.1 =
* Working version
