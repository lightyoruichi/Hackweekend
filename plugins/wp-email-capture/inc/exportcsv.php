<?php


function wp_email_capture_export()
{
	global $wpdb;
	
	$csv_output .= "Name,Email";
	$csv_output .= "\n";

	 
   	$table_name = $wpdb->prefix . "wp_email_capture_registered_members";
   	$sql = "SELECT name, email FROM " . $table_name;
   	$results = $wpdb->get_results($wpdb->prepare($sql));
 	foreach ($results as $result) {
		$csv_output .= $result->name ."," . $result->email ."\n";
	}

	$filename = $file."_".date("Y-m-d_H-i",time());
	header("Content-type: application/vnd.ms-excel");
	header("Content-disposition: csv" . date("Y-m-d") . ".csv");
	header( "Content-disposition: filename=".$filename.".csv");
	print $csv_output;
	exit;
}

?>