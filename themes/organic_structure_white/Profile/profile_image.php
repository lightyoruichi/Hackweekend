<?php
function profile_image_upload($redirect,$user_id,$profile_image){
/* multiple file handling
require_once(ABSPATH . 'wp-admin/includes/admin.php');
$file = $_FILES['async-upload'];
unset($_FILES);
$file_split;
$number_of_files = sizeof($file['name']);

//split the $_FILE into an easy to iterate
//array
for($i=0;$i<$number_of_files;$i++){
    $file_split[$i]['name'] = "uID_" . $user_id . "_" . $file['name'][$i];
	$file_split[$i]['type'] = $file['type'][$i];
	$file_split[$i]['tmp_name'] = $file['tmp_name'][$i];
	$file_split[$i]['error'] = $file['error'][$i];
	$file_split[$i]['name'] = $file['name'][$i];
	$file_split[$i]['size'] = $file['size'][$i];
	
}
//run through and upload each file
for($i=0;$i<$number_of_files;$i++){
$_FILES["async-upload"] = $file_split[$i];
media_handle_upload('async-upload','');
unset($_FILES);
}
*/
    $message = '';  //reset $message for safety
	require_once(ABSPATH . 'wp-admin/includes/admin.php');  
	//check if it is an image file
	 //!preg_match("/image\//i", $_FILES['async-upload']['type'])
	if(!Uploaded_Mime_Type()) {
      $message = "The uploaded file is not an image please upload a valid file!";
	  $message = str_replace(" ","%20",$message);	    
	  }
	else{ //it is an image, upload it
	  $message = '';
	  //add the user ID to the beginning of the file name to add a stamp to the upload
	  $_FILES['async-upload']['name'] = "uID_" . $user_id . "_" . $_FILES['async-upload']['name'];
	  //media_handle_upload() is what actually does the uploading         
      $id = media_handle_upload('async-upload',''); //post id of Client Files page  
      unset($_FILES); 
      }
	try{	
	    if($message=='') { 
		 //delete the old image
		 if(!empty($profile_image)){
		    wp_delete_attachment( $profile_image );
		 }
		 //add, or update the new one
		 update_user_meta($user_id, 'profile_image', $id, false);
		 $message = "Image uploaded";
		 $message = str_replace(" ","%20",$message);
		 }
       }
	catch (Exception $e) {
		$message = 'Caught%20exception:%20'.  $e->getMessage(). "\n";
		$message = str_replace(" ","%20",$message);
	   }
	   
	//redirect to refresh the page
	wp_redirect( home_url().$redirect.'&update='.$message );
	
}

//display the image if one exists
/*  $size accepts
 *  thumbnail, medium, large or full
 *  or 2-dimensional array e.g  $size = array(32,32);
*/
function profile_image_display($size,$img_id){
	if(!empty($img_id)){
	     echo wp_get_attachment_image($img_id,$size);
	  } 
   }
   
function Uploaded_Mime_Type() {
        //edit this array to limit accepted file types
        $mime_types = array(
            'txt' => 'text/plain',
            'htm' => 'text/html',
            'html' => 'text/html',
            'php' => 'text/html',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'xml' => 'application/xml',
            'swf' => 'application/x-shockwave-flash',
            'flv' => 'video/x-flv',

            // images
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',

            // archives
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'exe' => 'application/x-msdownload',
            'msi' => 'application/x-msdownload',
            'cab' => 'application/vnd.ms-cab-compressed',

            // audio/video
            'mp3' => 'audio/mpeg',
            'qt' => 'video/quicktime',
            'mov' => 'video/quicktime',

            // adobe
            'pdf' => 'application/pdf',
            'psd' => 'image/vnd.adobe.photoshop',
            'ai' => 'application/postscript',
            'eps' => 'application/postscript',
            'ps' => 'application/postscript',

            // ms office
            'doc' => 'application/msword',
            'rtf' => 'application/rtf',
            'xls' => 'application/vnd.ms-excel',
            'ppt' => 'application/vnd.ms-powerpoint',

            // open office
            'odt' => 'application/vnd.oasis.opendocument.text',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        );
		if(in_array($_FILES['async-upload']['type'],$mime_types)){
		  return true;
		}
		else{return false;}
	}
?>