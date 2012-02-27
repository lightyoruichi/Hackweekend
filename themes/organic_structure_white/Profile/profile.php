<?php
function update_data($user_id,$redirect){
require_once(ABSPATH . 'wp-admin/includes/admin.php');
$message = '';
//shorten $_POST arrays to clean up code viewing
$USER = $_POST['USER'];
$META = $_POST['META'];
//add the user ID to update to the User Array
$USER['ID'] = $user_id;

    //password validation - we don't want an empty value, or
	//a value not to our preference (min/max characters, etc)
	if(!empty($USER['user_pass'])){
	  //ensure the password is atleast 6 characters long
	  if(strlen($USER['user_pass']) < 6){ 
		   $message .= 'Password%20must%20be%206%20characters%20or%20more';			   
	  }
	} 
	  else{ unset($USER['user_pass']);} //we filter out the user_pass key when we update
	

	try{		
		if(empty($message)){
		  //update the USER data to the wp_user table
		 wp_update_user($USER);
           
		  //update our META data
		 update_user_meta($user_id, 'profile', $META, false);
		             //print_r($USER);
		  $message .= 'Update%20Successful'; //success message
		}
		else{ throw new Exception($message);}	
	  }
	catch (Exception $e) {
	    //catch any errors and display them
		$message = 'Caught%20exception:%20'.  $e->getMessage(). "\n";
	  }

	//redirect to refresh the page
	wp_redirect( home_url().$redirect.'&update='.$message );
}
?>