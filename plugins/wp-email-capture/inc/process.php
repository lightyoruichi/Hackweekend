<?php



function wp_email_capture_process()

{

  if(isset($_REQUEST['wp_capture_action'])) {
  	wp_email_capture_signup();
  }

   if(isset($_GET['wp_email_confirm']) || isset($_REQUEST['wp_email_confirm'])) {
  		wp_capture_email_confirm();
  }

}



function wp_email_capture_double_check_everything($name, $email)

{

	if (wp_email_injection_chars($name) || wp_email_injection_chars($email) || wp_email_injection_chars($name) || wp_email_injection_chars($email))

	{

		return FALSE;

	} else {

		return TRUE;
	}

}



function wp_email_capture_signup()

{

global $wpdb;



// Random confirmation code

$confirm_code=md5(uniqid(rand()));

$name = $_REQUEST['wp-email-capture-name'];

$email = $_REQUEST['wp-email-capture-email'];


if (!validEmail($email))

{

	$url = $_SERVER['PHP_SELF'] . "?wp_email_capture_error=Not%20a%20valid%20email";

	header("Location: $url");	

	die();

}



if (wp_email_capture_double_check_everything($name, $email))

{

	// values sent from form

	$name = sanitize($name);

	$email= sanitize($email);

	$name = wp_email_injection_test($name);

	$email = wp_email_injection_test($email);

	$name = wp_email_stripslashes($name);

	$email = wp_email_stripslashes($email);

	$referrer = sanitize($_SERVER['HTTP_REFERER']);

	$ip = sanitize($_SERVER['REMOTE_ADDR']);

	$date = date("Y-m-d H-i");


	$sqlcheck = checkIfPresent($email);



	if ($sqlcheck){

		

		$url = $_SERVER['PHP_SELF'] . "?wp_email_capture_error=User%20already%20present";

		header("Location: $url");

		die();

	}



	// Insert data into database

	$table_name = $wpdb->prefix . "wp_email_capture_temp_members";





	$sql="INSERT INTO ".$table_name."(confirm_code, name, email)VALUES('$confirm_code', '$name', '$email')";

	$result=$wpdb->query($wpdb->prepare($sql));

	

	// if suceesfully inserted data into database, send confirmation link to email

	if($result){



	// ---------------- SEND MAIL FORM ----------------



	// send e-mail to ...

	$to=$email;

	$siteurl = get_option('home');
	$siteurl = addLastCharacter($siteurl);

	// Your subject

	$subject=get_option('wp_email_capture_subject');

	// From
	$header = "MIME-Version: 1.0\n" . "From: " . get_option('wp_email_capture_from_name') . " <" . get_option('wp_email_capture_from') . ">\n"; 
	$header .= "Content-Type: text/plain; charset=\"" . get_settings('blog_charset') . "\"\n";
	// Your message

	$message.= get_option('wp_email_capture_body') . "\n\n";

	$message.= $siteurl ."?wp_email_confirm=1&wp_email_capture_passkey=$confirm_code";
	$message .= "\n\nThanks,\n";
	$message .= "----\n";
	$message .= "HackWeekend Team\n";
	$message .= "|| http://hack.weekend.my ||";
	$message = str_replace("%NAME%", $name, $message);
	
	// send email

	$sentmail = wp_mail($to,$subject,$message,$header);

}

}



// if not found

else {

echo "Not found your email in our database";

}



// if your email succesfully sent

if($sentmail){

	$halfreg = get_option('wp_email_capture_signup');

	header("Location: $halfreg"); 

	die();

}

else {

	$url = $_SERVER['PHP_SELF'] . "?wp_email_capture_error=Email%20unable%20to%20be%20sent";

	header("Location: $url");

	die();

	//echo "<meta http-equiv='refresh' content='0;". $url . "?wp_email_capture_error=Email%20unable%20to%20be%sent'>";

}

}





function wp_capture_email_confirm()

{

	global $wpdb;

	// Passkey that got from link

	$passkey=sanitize($_GET['wp_email_capture_passkey']);

	$table_name = $wpdb->prefix . "wp_email_capture_temp_members";

	$sql1="SELECT id FROM $table_name WHERE confirm_code ='$passkey'";

	$result=$wpdb->get_var($wpdb->prepare($sql1));

	if ($result != '')

	{	

		$table_name2 = $wpdb->prefix . "wp_email_capture_registered_members";

		$sql2="SELECT * FROM $table_name WHERE confirm_code ='$passkey'";

		$rowresults = $wpdb->get_results($wpdb->prepare($sql2));

		foreach ($rowresults as $rowresult) {

		 $name = $rowresult->name;  

		 $email = $rowresult->email;

		 $sql3="INSERT INTO $table_name2(name, email)VALUES('$name', '$email')";

		 $result3=$wpdb->query($wpdb->prepare($sql3));

		}

	}

	else {

			$url = $url . "?wp_email_capture_error=Wrong%20confirmation%20code";

			header("Location: $url");

	}

		// if successfully moved data from table"temp_members_db" to table "registered_members" displays message "Your account has been activated" and don't forget to delete confirmation code from table "temp_members_db"

		

	if($result3){

			$sql4="DELETE FROM $table_name WHERE confirm_code = '$passkey'";

			$result4=$wpdb->query($wpdb->prepare($sql4));

			$fullreg = get_option('wp_email_capture_redirection');

			header("Location: $fullreg"); 
			
			

			echo "<meta http-equiv='refresh' content='0;". $fullreg ."'>"; 
			die();

	}



		

}





?>
