<?php

require_once("../../../wp-config.php");
global $wpdb;

$table_name = $wpdb->prefix . "k_note";

$k_note=$_POST['k_note'];

$wpdb->query( $wpdb->query( "UPDATE $table_name SET note = ('$k_note') WHERE id = '1'"  ) );

if($wpdb) {
	header("location:/wp-admin/options-general.php?page=sticky-note");
	exit();
}


?>