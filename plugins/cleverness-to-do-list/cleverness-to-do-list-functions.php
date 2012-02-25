<?php
/* Insert new to-do item into the database */
function cleverness_todo_insert($todotext, $priority, $assign = 0, $deadline, $progress = 0, $category = 0) {
	global $wpdb, $userdata, $cleverness_todo_option;
	require_once (ABSPATH . WPINC . '/pluggable.php');
   	get_currentuserinfo();

	if ( $cleverness_todo_option['list_view'] == '0' || current_user_can($cleverness_todo_option['add_capability']) ) {
  	 	$table_name = $wpdb->prefix . 'todolist';
   		$results = $wpdb->insert( $table_name, array( 'author' => $userdata->ID, 'status' => 0, 'priority' => $priority, 'todotext' => $todotext, 'assign' => $assign, 'deadline' => $deadline, 'progress' => $progress, 'cat_id' => $category ) );
		if ( $results ) $message = __('New To-Do item has been added.', 'cleverness-to-do-list');
		else {
			$message = __('There was a problem adding the item to the database.', 'cleverness-to-do-list');
			$wpdb->show_errors();
			$wpdb->print_error();
			$wpdb->hide_errors();
			}
	} else {
		$message = __('You do not have sufficient privileges to do that.', 'cleverness-to-do-list');
		}
	return $message;
	}


/* Send an email to assigned user */
function cleverness_todo_email_user($todotext, $priority, $assign, $deadline) {
	global $wpdb, $userdata, $cleverness_todo_option;
	$priority_array = array(0 => $cleverness_todo_option['priority_0'] , 1 => $cleverness_todo_option['priority_1'], 2 => $cleverness_todo_option['priority_2']);
	require_once (ABSPATH . WPINC . '/pluggable.php');
   	get_currentuserinfo();

   	if ( current_user_can($cleverness_todo_option['assign_capability']) && $assign != '' && $assign != '-1' && $assign != '0') {
		$headers = 'From: '.$cleverness_todo_option['email_from'].' <'.get_bloginfo('admin_email').'>' . "\r\n\\";
		$subject = $cleverness_todo_option['email_subject'];
		$assign_user = get_userdata($assign);
		$email = $assign_user->user_email;
		$email_message = $cleverness_todo_option['email_text'];
		$email_message .= "\r\n\\".$todotext."\r\n\\";
		if ( $deadline != '' )
			$email_message .= __('Deadline:', 'cleverness-to-do-list').' '.$deadline."\r\n\\";
  		if ( wp_mail($email, $subject, $email_message, $headers) )
			$message = __('A email has been sent to the assigned user.', 'cleverness-to-do-list').'<br /><br />';
		else
			$message = __('The email failed to send to the assigned user.', 'cleverness-to-do-list');
			$message .= '<br />
			To: '.$email.'<br />
			Subject: '.$subject.'<br />
			Message: '.$message.'<br />
			Headers: '.$headers.'<br /><br />';
		return $message;
	} else {
		$message = __('No email has been sent.', 'cleverness-to-do-list').'<br /><br />';
		return $message;
	}
}

/* Update to-do list item */
function cleverness_todo_update($id, $priority, $todotext, $assign = 0, $deadline, $progress = 0, $category = 0) {
   	global $wpdb, $userdata, $cleverness_todo_option;
   	get_currentuserinfo();

   	if ( $cleverness_todo_option['list_view'] == '0' || current_user_can($cleverness_todo_option['edit_capability']) ) {
		$table_name = $wpdb->prefix . 'todolist';
   		$results = $wpdb->update( $table_name, array( 'priority' => $priority, 'todotext' => $todotext, 'assign' => $assign, 'deadline' => $deadline, 'progress' => $progress, 'cat_id' => $category ), array( 'id' => $id ) );
		if ( $results ) $message = __('To-Do item has been updated.', 'cleverness-to-do-list');
		else {
			$message = __('There was a problem editing the item.', 'cleverness-to-do-list');
			$wpdb->show_errors();
			$wpdb->print_error();
			$wpdb->hide_errors();
			}
	} else {
		$message = __('You do not have sufficient privileges to do that.', 'cleverness-to-do-list');
		}
	return $message;
	}

/* Delete to-do list item */
function cleverness_todo_delete($id) {
   	global $wpdb, $userdata, $cleverness_todo_option;
	require_once (ABSPATH . WPINC . '/pluggable.php');
   	get_currentuserinfo();

   	$table_name = $wpdb->prefix . 'todolist';
   	if ( $cleverness_todo_option['list_view'] == '0' || current_user_can($cleverness_todo_option['delete_capability']) ) {
   		$delete = "DELETE FROM ".$table_name." WHERE id = '".$id."'";
   		$results = $wpdb->query( $delete );
		if ( $results ) $message = __('To-Do item has been deleted.', 'cleverness-to-do-list');
		else {
			$message = __('There was a problem deleting the item.', 'cleverness-to-do-list');
			$wpdb->show_errors();
			$wpdb->print_error();
			$wpdb->hide_errors();
			}
   	} else {
		$message = __('You do not have sufficient privileges to do that.', 'cleverness-to-do-list');
		}
	return $message;
	}

/* Mark to-do list item as completed or uncompleted */
function cleverness_todo_complete($id, $status) {
	global $wpdb, $userdata, $cleverness_todo_option, $current_user;
	require_once (ABSPATH . WPINC . '/pluggable.php');
   	get_currentuserinfo();

   	 $table_name = $wpdb->prefix . 'todolist';
	 $status_table_name = $wpdb->prefix . 'todolist_status';
	 // if individual view, group view with complete capability, or master view with edit capability
   	 if ( $cleverness_todo_option['list_view'] == '0' ||
	 ( $cleverness_todo_option['list_view'] == '1' && current_user_can($cleverness_todo_option['complete_capability']) ) ||
	 ( $cleverness_todo_option['list_view'] == '2' && current_user_can($cleverness_todo_option['edit_capability']) )
	 ) {
		$results = $wpdb->update( $table_name, array( 'status' => $status ), array( 'id' => $id ) );
		if ( $status == '1' ) $status_text = __('completed', 'cleverness-to-do-list');
		else $status_text = __('uncompleted', 'cleverness-to-do-list');
		if ( $results ) $message = __('To-Do item has been marked as ', 'cleverness-to-do-list').$status_text.'.';
		else {
			$message = __('There was a problem changing the status of the item.', 'cleverness-to-do-list');
			}
	 // master view - individual
	 } elseif ( $cleverness_todo_option['list_view'] == '2' ) {
	 	$user = $current_user->ID;
		$wpdb->get_results("SELECT * FROM $status_table_name WHERE id = $id AND user = $user");
		$num = $wpdb->num_rows;

		if ( $num == 0 ) {
			$results = $wpdb->insert( $status_table_name, array( 'id' => $id, 'status' => $status, 'user' => $user ) );
	 	} else {
			$results = $wpdb->update( $status_table_name, array( 'status' => $status ), array( 'id' => $id, 'user' => $user ) );
			}

		if ( $status == '1' ) $status_text = __('completed', 'cleverness-to-do-list');
		else $status_text = __('uncompleted', 'cleverness-to-do-list');
		if ( $results ) $message = __('To-Do item has been marked as ', 'cleverness-to-do-list').$status_text.'.';
		else {
			$message = __('There was a problem changing the status of the item.', 'cleverness-to-do-list');
			}
	 // no capability
	 } else {
		$message = __('You do not have sufficient privileges to do that.', 'cleverness-to-do-list');
		}
	return $message;
	}

/* Get to-do list item */
function cleverness_todo_get_todo($id) {
   	global $wpdb, $userdata, $cleverness_todo_option;
	require_once (ABSPATH . WPINC . '/pluggable.php');
   	get_currentuserinfo();

   	$table_name = $wpdb->prefix . 'todolist';
   	if ( $cleverness_todo_option['list_view'] == '0' || current_user_can($cleverness_todo_option['edit_capability']) ) {
   		$edit = "SELECT * FROM ".$table_name." WHERE id = '".$id."' LIMIT 1";
   		$result = $wpdb->get_row( $edit );
   		return $result;
	} else {
		$message = __('You do not have sufficient privileges to do that.', 'cleverness-to-do-list');
		}
	return $message;
	}

/* Delete all completed to-do list items */
function cleverness_todo_purge() {
   	global $wpdb, $userdata, $cleverness_todo_option;
	require_once (ABSPATH . WPINC . '/pluggable.php');
   	get_currentuserinfo();

   	$table_name = $wpdb->prefix . 'todolist';
   	if ( $cleverness_todo_option['list_view'] == '0' || current_user_can($cleverness_todo_option['purge_capability']) ) {
   		if ( $cleverness_todo_option['list_view'] == '0' )
   			$purge = "DELETE FROM ".$table_name." WHERE status = '1' AND ( author = '".$userdata->ID."' || assign = '".$userdata->ID."' )";
	   	elseif ( $cleverness_todo_option['list_view'] == '1' || $cleverness_todo_option['list_view'] == '2' )
			$purge = "DELETE FROM ".$table_name." WHERE status = '1'";
   		$results = $wpdb->query( $purge );
		if ( $results ) $message = __('Completed To-Do items have been deleted.', 'cleverness-to-do-list');
		else {
			$message = __('There was a problem removing the completed items.', 'cleverness-to-do-list');
			}
	} else {
		$message = __('You do not have sufficient privileges to do that.', 'cleverness-to-do-list');
		}
	return $message;
	}

/* Insert new to-do category into the database */
function cleverness_todo_insert_cat($catname, $catvisibility, $addcat_nonce) {
	global $wpdb, $userdata, $cleverness_todo_option;
	require_once (ABSPATH . WPINC . '/pluggable.php');
   	get_currentuserinfo();
	if (!wp_verify_nonce($addcat_nonce, 'todoaddcat') ) die('Security check failed');

	if ( $cleverness_todo_option['categories'] == '1' || (current_user_can($cleverness_todo_option['add_cat_capability']) || $cleverness_todo_option['list_view'] == '0' ) ) {
  	 	$cattable_name = $wpdb->prefix . 'todolist_cats';
   		$results = $wpdb->insert( $cattable_name, array( 'name' => $catname, 'visibility' => $catvisibility ) );
		if ( $results ) $message = __('New category has been added.', 'cleverness-to-do-list');
		else {
			$message = __('There was a problem adding the category to the database.', 'cleverness-to-do-list');
			}
	} else {
		$message = __('You do not have sufficient privileges to do that.', 'cleverness-to-do-list');
		}
	return $message;
	}

/* Update to-do list category */
function cleverness_todo_update_cat($id, $catname, $catvisibility, $updatecat_nonce) {
   	global $wpdb, $userdata, $cleverness_todo_option;
	require_once (ABSPATH . WPINC . '/pluggable.php');
   	get_currentuserinfo();
	if (!wp_verify_nonce($updatecat_nonce, 'todoupdatecat') ) die('Security check failed');

   	if ( $cleverness_todo_option['categories'] == '1' || ( current_user_can($cleverness_todo_option['add_cat_capability']) || $cleverness_todo_option['list_view'] == '0' ) ) {
		$table_name = $wpdb->prefix . 'todolist_cats';
   		$results = $wpdb->update( $table_name, array( 'name' => $catname, 'visibility' => $catvisibility ), array( 'id' => $id ) );
		if ( $results ) $message = __('Category has been updated.', 'cleverness-to-do-list');
		else {
			$message = __('There was a problem editing the category.', 'cleverness-to-do-list');
			}
	} else {
		$message = __('You do not have sufficient privileges to do that.', 'cleverness-to-do-list');
		}
	return $message;
	}

/* Delete to-do list category */
function cleverness_todo_delete_cat($id) {
   	global $wpdb, $userdata, $cleverness_todo_option;
	require_once (ABSPATH . WPINC . '/pluggable.php');
   	get_currentuserinfo();

   	$table_name = $wpdb->prefix . 'todolist_cats';
   	if ( $cleverness_todo_option['categories'] == '1' ||(  current_user_can($cleverness_todo_option['add_cat_capability']) || $cleverness_todo_option['list_view'] == '0' ) ) {
   		$delete = "DELETE FROM ".$table_name." WHERE id = '".$id."'";
   		$results = $wpdb->query( $delete );
		if ( $results ) $message = __('Category has been deleted.', 'cleverness-to-do-list');
		else {
			$message = __('There was a problem deleting the category.', 'cleverness-to-do-list');
			}
   	} else {
		$message = __('You do not have sufficient privileges to do that.', 'cleverness-to-do-list');
		}
	return $message;
	}

/* Get to-do list category */
function cleverness_todo_get_todo_cat($id) {
   	global $wpdb, $userdata, $cleverness_todo_option;
	require_once (ABSPATH . WPINC . '/pluggable.php');
   	get_currentuserinfo();

   	$table_name = $wpdb->prefix . 'todolist_cats';
   	if ( $cleverness_todo_option['categories'] == '1' || ( current_user_can($cleverness_todo_option['add_cat_capability'])  || $cleverness_todo_option['list_view'] == '0' )) {
   		$edit = "SELECT * FROM ".$table_name." WHERE id = '".$id."' LIMIT 1";
   		$result = $wpdb->get_row( $edit );
   		return $result;
	} else {
		$message = __('You do not have sufficient privileges to do that.', 'cleverness-to-do-list');
		}
	return $message;
	}

/* Get to-do list categories */
function cleverness_todo_get_cats() {
   	global $wpdb, $userdata, $cleverness_todo_option;
	require_once (ABSPATH . WPINC . '/pluggable.php');
   	get_currentuserinfo();

   	$table_name = $wpdb->prefix . 'todolist_cats';
   	if ( $cleverness_todo_option['categories'] == '1' ) {
   		$sql = "SELECT id, name FROM ".$table_name;
   		$results = $wpdb->get_results( $sql );
   		return $results;
	} else {
		$message = __('You do not have sufficient privileges to do that.', 'cleverness-to-do-list');
		}
	return $message;
	}

/* Get to-do category name */
function cleverness_todo_get_cat_name($id) {
   	global $wpdb, $userdata, $cleverness_todo_option;

   	$table_name = $wpdb->prefix . 'todolist_cats';

   	$cat = "SELECT name FROM ".$table_name." WHERE id = '".$id."' LIMIT 1";
   	$result = $wpdb->get_row( $cat );
   	return $result;
	}

/* Create database table and add default options */
function cleverness_todo_install () {
   	global $wpdb, $userdata;
   	get_currentuserinfo();

	$cleverness_todo_db_version = '1.8';

	$table_name = $wpdb->prefix.'todolist';
	$cat_table_name = $wpdb->prefix.'todolist_cats';
	$status_table_name = $wpdb->prefix.'todolist_status';

   	if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
   		$sql = "CREATE TABLE ".$table_name." (
	      id bigint(20) UNIQUE NOT NULL AUTO_INCREMENT,
	      author bigint(20) NOT NULL,
	      status tinyint(1) DEFAULT '0' NOT NULL,
	      priority tinyint(1) NOT NULL,
          todotext text NOT NULL,
		  assign int(10),
		  progress int(3),
		  deadline varchar(30),
		  completed timestamp,
		  cat_id bigint(20)
	    );";
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
   		dbDelta($sql);
		$sql2 = "CREATE TABLE ".$cat_table_name." (
	      id bigint(20) UNIQUE NOT NULL AUTO_INCREMENT,
	      name varchar(100),
	      visibility tinyint(1) DEFAULT '0' NOT NULL
	    );";
   		dbDelta($sql2);
		$sql3 = "CREATE TABLE ".$status_table_name." (
	      id bigint(20),
	      user bigint(20),
	      status tinyint(1) DEFAULT '0' NOT NULL
	    );";
   		dbDelta($sql3);
   		$welcome_text = __('Add your first To-Do List item', 'cleverness-to-do-list');
   		$results = $wpdb->insert( $table_name, array( 'author' => $userdata->ID, 'status' => 0, 'priority' => 1, 'todotext' => $welcome_text ) );

		$new_options = array(
		'list_view' => '0',
		'dashboard_author' => '0',
		'todo_author' => '0',
		'assign' => '1',
		'show_only_assigned' => '1',
		'view_capability' => 'publish_posts',
		'add_capability' => 'publish_posts',
		'edit_capability' => 'publish_posts',
		'delete_capability' => 'manage_options',
		'purge_capability' => 'manage_options',
		'complete_capability' => 'publish_posts',
		'assign_capability' => 'manage_options',
		'view_all_assigned_capability' => 'manage_options',
		'dashboard_number' => '10',
		'priority_0' => __('Important', 'cleverness-to-do-list'),
		'priority_1' => __('Normal', 'cleverness-to-do-list'),
		'priority_2' => __('Low', 'cleverness-to-do-list'),
		'show_deadline' => '0',
		'show_dashboard_deadline' => '0',
		'show_progress' => '0',
		'email_assigned' => '0',
		'show_completed_date' => '0',
		'date_format' => 'm-d-Y',
		'user_roles' => 'contributor, author, editor, administrator',
		'categories' => '0',
		'sort_order' => 'id',
		'add_cat_capability' => 'manage_options',
		'dashboard_cat' => 'All',
		'email_text' => __('The following item has been assigned to you.', 'cleverness-to-do-list'),
		'email_subject' => __('A to-do list item has been assigned to you', 'cleverness-to-do-list')
   		);
   		add_option( 'cleverness_todo_settings', $new_options );
		add_option( 'cleverness_todo_db_version', $cleverness_todo_db_version );
		}

	$installed_ver = get_option( 'cleverness_todo_db_version' );

	if( $installed_ver != $cleverness_todo_db_version ) {

		if ( !function_exists('maybe_create_table') ) {
			require_once(ABSPATH . 'wp-admin/install-helper.php');
		}

		maybe_add_column($table_name, 'assign', "ALTER TABLE `$table_name` ADD `assign` int(10);");
		maybe_add_column($table_name, 'deadline', "ALTER TABLE `$table_name` ADD `deadline` varchar(30);");
		maybe_add_column($table_name, 'progress', "ALTER TABLE `$table_name` ADD `progress` int(3);");
		maybe_add_column($table_name, 'completed', "ALTER TABLE `$table_name` ADD `completed` timestamp;");
		maybe_add_column($table_name, 'cat_id', "ALTER TABLE `$table_name` ADD `cat_id` bigint(20);");
		maybe_create_table($cat_table_name, "CREATE TABLE ".$cat_table_name." (
	      id bigint(20) UNIQUE NOT NULL AUTO_INCREMENT,
	      name varchar(100),
	      sort tinyint(3) DEFAULT '0' NOT NULL,
	      visibility tinyint(1) DEFAULT '0' NOT NULL
	    );");
		maybe_create_table($status_table_name, "CREATE TABLE ".$status_table_name." (
	      id bigint(20),
	      user bigint(20),
	      status tinyint(1) DEFAULT '0' NOT NULL
	    );");

		$theoptions = get_option('cleverness_todo_settings');
		if ( $theoptions['categories'] == '' ) $theoptions['categories'] = '0';
		if ( $theoptions['sort_order'] == '' ) $theoptions['sort_order'] = 'id';
		if ( $theoptions['add_cat_capability'] == '' ) $theoptions['add_cat_capability'] = 'manage_options';
		if ( $theoptions['dashboard_cat'] == '' ) $theoptions['dashboard_cat'] = 'All';
		if ( $theoptions['email_text'] == '' ) $theoptions['email_text'] = __('The following item has been assigned to you.', 'cleverness-to-do-list');
		if ( $theoptions['email_subject'] == '' ) $theoptions['email_subject'] = __('A to-do list item has been assigned to you', 'cleverness-to-do-list');
		if ( $theoptions['email_from'] == '' ) $theoptions['email_from'] = html_entity_decode(get_bloginfo('name'));
		update_option( 'cleverness_todo_settings', $theoptions);

    	update_option( 'cleverness_todo_db_version', $cleverness_todo_db_version );
		delete_option( 'atd_db_version' );
		}
	}
?>