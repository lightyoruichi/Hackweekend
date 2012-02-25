<?php
/*
Plugin Name: Sticky Note Plugin
Plugin URI: http://www.kuckovic.com/plugins/sticky-note
Description: Write your own notes at the Admin-dashboard, and help yourself remebering.
Version: 1.0
Author: Aris Kuckovic
Author URI: http://www.kuckovic.com
License: GNU General Public License
*/

/*  Copyright 2010  Aris Kuckovic  (email : support@kuckovic.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


global $knote_db_version;
$knote_db_version = "1.0";


function note_install()
{
	global $wpdb;
	$table_name = $wpdb->prefix."k_note";{
	if($wpdb->get_var("show tables like '$table_name'") != $table_name) {
	
		$sql = "CREATE TABLE " . $table_name . " (
												  id INT(9) NOT NULL AUTO_INCREMENT,
												  note TEXT NOT NULL,
												  PRIMARY KEY id (id)
												  );";
		
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
		
		$success_message = "This is your first note. Congratz!";
		$rows_affected = $wpdb->query("INSERT INTO $table_name(note) VALUES('$success_message')");
		
		
		
		add_option("knote_db_version", $knote_db_version);
	}
	}
}

register_activation_hook(__FILE__,'note_install');
require_once('sticky-note-admin.php');
require_once('sticky-note-dashboard.php');
?>