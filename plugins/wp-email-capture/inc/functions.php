<?php 

function sanitize($string)

{

	$string = mysql_real_escape_string($string);

	$string = htmlspecialchars($string, ENT_QUOTES, 'UTF-8');

	return $string;

}



function checkIfPresent($email){

	global $wpdb;

	$table_name = $wpdb->prefix . "wp_email_capture_registered_members";

	$sql = 'SELECT COUNT(*)

	FROM '. $table_name . ' WHERE email = "'. $email .'"';
	
	$prep = $wpdb->prepare($sql);

	$result = $wpdb->get_var($prep);
	
  	if($result > 0)

  	{

  		return true;

  	}else{

  	return false;

  }

}



?>