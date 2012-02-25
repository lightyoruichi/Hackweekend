<?php

if(get_option('player_fetch_thumbnail') == true) {

function get_video_thumbnail($post_id=null) {
	
	if($post_id==null OR $post_id=='') $post_id = get_the_ID();
	if( ($thumbnail_meta = get_post_meta($post_id, '_video_thumbnail', true)) != '' ) {
		return $thumbnail_meta;
	}

	else {
		$post_array = get_post($post_id); 
		$markup = $post_array->post_content;
		$markup = apply_filters('the_content',$markup);
		$new_thumbnail = null;
		preg_match('#<object[^>]+>.+?http://www.youtube.com/[ve]/([A-Za-z0-9\-_]+).+?</object>#s', $markup, $matches);
		if(!isset($matches[1])) {
			preg_match('#http://www.youtube.com/embed/([A-Za-z0-9\-_]+)#s', $markup, $matches);
		}
	
		if(!isset($matches[1])) {
			preg_match('#http://w?w?w?.?youtube.com/watch\?v=([A-Za-z0-9\-_]+)#s', $markup, $matches);
		}
		
		if(isset($matches[1])) {
			$youtube_thumbnail = 'http://img.youtube.com/vi/' . $matches[1] . '/0.jpg';
			
			if (!function_exists('curl_init')) {
				$new_thumbnail = $youtube_thumbnail;
			} else {
				$ch = curl_init($youtube_thumbnail);
				curl_setopt($ch, CURLOPT_NOBODY, true);
				curl_exec($ch);
				$retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				curl_close($ch);
				if($retcode==200) {
					$new_thumbnail = $youtube_thumbnail;
				}
			}
		}
		
		if($new_thumbnail!=null) {
				$ch = curl_init(); 
				$timeout = 0; 
				curl_setopt ($ch, CURLOPT_URL, $new_thumbnail); 
				curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
				curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout); 
				$image_contents = curl_exec($ch); 
				curl_close($ch); 
			
				$upload = wp_upload_bits(basename($new_thumbnail), null, $image_contents);
				$new_thumbnail = $upload['url'];
				$filename = $upload['file'];
				$wp_filetype = wp_check_filetype(basename($filename), null );

				$attachment = array(
				   'post_mime_type' => $wp_filetype['type'],
				   'post_title' => get_the_title($post_id),
				   'post_content' => '',
				   'post_status' => 'inherit'
				);

				$attach_id = wp_insert_attachment( $attachment, $filename, $post_id );


				require_once(ABSPATH . "wp-admin" . '/includes/image.php');
				$attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
				wp_update_attachment_metadata( $attach_id,  $attach_data );
				
			
			if(!update_post_meta($post_id, '_video_thumbnail', $new_thumbnail)) add_post_meta($post_id, '_video_thumbnail', $new_thumbnail, true);
			
		}
		return $new_thumbnail;

	}
};

function video_thumbnail($post_id=null) {
	if( ( $video_thumbnail = get_video_thumbnail($post_id) ) == null ) { echo plugins_url() . "/video-thumbnails/default.jpg"; }
	else { echo $video_thumbnail; }
};

add_action("admin_init", "video_thumbnail_admin_init");
 
function video_thumbnail_admin_init(){
	add_meta_box("video_thumbnail", "Video Thumbnail", "video_thumbnail_admin", "post", "normal", "low");
}
 
function video_thumbnail_admin(){
	global $post;
	$custom = get_post_custom($post->ID);
	$video_thumbnail = $custom["_video_thumbnail"][0];
	?>
	<p><label>Video Thumbnail URL:</label></p>
	<p><input type="text" size="16" name="video_thumbnail" style="width:450px;" value="<?php echo $video_thumbnail; ?>" /></p>
	<?php if(isset($video_thumbnail) && $video_thumbnail!='') { ?><p><img src="<?php echo $video_thumbnail; ?>" width="300" height="225" /></p><?php } ?>
	<?php
}

add_action('save_post', 'save_video_thumbnail');

function save_video_thumbnail(){
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
		return null;
	} else {
		global $post;
		$custom = get_post_custom($post->ID);
		$old_thumbnail = $custom["_video_thumbnail"][0];
		if ($old_thumbnail == '') {
			get_video_thumbnail($post->ID);
		} elseif (isset($_POST["video_thumbnail"]) && $_POST["video_thumbnail"]==$old_thumbnail) {
			return null;
		} elseif (isset($_POST["video_thumbnail"]) && $_POST["video_thumbnail"]!='') {
			if(!update_post_meta($post->ID, "_video_thumbnail", $_POST["video_thumbnail"])) add_post_meta($post->ID, "_video_thumbnail", $_POST["video_thumbnail"], true);
		} elseif (isset($_POST["video_thumbnail"]) && $_POST["video_thumbnail"]=='') {
			delete_post_meta($post->ID, "_video_thumbnail");
		}
	}
}

}
