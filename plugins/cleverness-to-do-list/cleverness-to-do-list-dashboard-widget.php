<?php
/* Display Dashboard Widget */
function cleverness_todo_todo_in_activity_box() {
   	global $wpdb, $userdata, $cleverness_todo_option, $current_user;
	get_currentuserinfo();

	$cleverness_widget_action = '';
	if ( isset($_GET['cleverness_widget_action']) ) $cleverness_widget_action = $_GET['cleverness_widget_action'];

	if ( $cleverness_widget_action == 'complete' ) {
		if ( $cleverness_todo_option['list_view'] == '0' || current_user_can($cleverness_todo_option['complete_capability']) ) {
			$cleverness_widget_id = attribute_escape($_GET['cleverness_widget_id']);
			$message = cleverness_todo_complete($cleverness_widget_id, '1');
		} else {
			$message = __('You do not have sufficient privileges to do that.', 'cleverness-to-do-list');
		}
	}

	$table_name = $wpdb->prefix.'todolist';
	$status_table_name = $wpdb->prefix.'todolist_status';
	$number = $cleverness_todo_option['dashboard_number'];
	$cat_id = $cleverness_todo_option['dashboard_cat'];

	// individual view
	if ( $cleverness_todo_option['list_view'] == '0' ) {
		if ( $cleverness_todo_option['assign'] == '0' )
			$sql = "SELECT * FROM $table_name WHERE status = 0 AND ( author = $userdata->ID || assign = $userdata->ID )";
		else
			$sql = "SELECT * FROM $table_name WHERE status = 0 AND author = $userdata->ID";
		}
	// group view - show only assigned - show all assigned
	elseif ( $cleverness_todo_option['list_view'] == '1' && $cleverness_todo_option['show_only_assigned'] == '0' && (current_user_can($cleverness_todo_option['view_all_assigned_capability'])) )
		$sql = "SELECT * FROM $table_name WHERE status = 0";
	// group view - show only assigned
	elseif ( $cleverness_todo_option['list_view'] == '1' && $cleverness_todo_option['show_only_assigned'] == '0' )
		$sql = "SELECT * FROM $table_name WHERE status = 0 AND assign = $userdata->ID";
	// group view - show all
	elseif ( $cleverness_todo_option['list_view'] == '1' )
		$sql = "SELECT * FROM $table_name WHERE status = 0";
	// master view with edit capablities
	elseif ( $cleverness_todo_option['list_view'] == '2' && current_user_can($cleverness_todo_option['edit_capability']) )
			$sql = "SELECT * FROM $table_name WHERE status = 0";
	// master view
	elseif ( $cleverness_todo_option['list_view'] == '2' ) {
			$user = $current_user->ID;
		   	$sql = "SELECT * FROM $table_name WHERE ( id = ANY ( SELECT id FROM $status_table_name WHERE user = $user AND status = 0 ) OR  id NOT IN( SELECT id FROM $status_table_name WHERE user = $user AND status = 1 ) ) AND status = 0";
		}
	// show only one category
	if ( $cleverness_todo_option['categories'] == '1' ) {
		if ( $cat_id != 'All' )
			$sql .= " AND cat_id = $cat_id ";
		}
	// order by sort order - no categories
	if ( $cleverness_todo_option['categories'] == '0' )
		$sql .= ' ORDER BY priority, '.$cleverness_todo_option['sort_order'].'  LIMIT '.$number;
	// order by categories then sort order
	else
		$sql .= ' ORDER BY cat_id, priority, '.$cleverness_todo_option['sort_order'].'  LIMIT '.$number;
	$results = $wpdb->get_results($sql);

	if ($results) {
		foreach ($results as $result) {
			$user_info = get_userdata($result->author);
			$priority_class = '';
		   	if ($result->priority == '0') $priority_class = ' class="todo-important"';
			if ($result->priority == '2') $priority_class = ' class="todo-low"';

			if ( $cleverness_todo_option['categories'] == '1' ) {
				$cat = cleverness_todo_get_cat_name($result->cat_id);
				if ( $catid != $result->cat_id && $cat->name != '' ) echo '<h4>'.$cat->name.'</h4>';
				$catid = $result->cat_id;
			}

			echo '<p><input type="checkbox" id="td-'.$result->id.'" onclick="window.location = \'index.php?cleverness_widget_action=complete&amp;cleverness_widget_id='.$result->id.'\';" /> <span'.$priority_class.'>'.stripslashes($result->todotext).'</span>';
			if ( ($cleverness_todo_option['list_view'] == '1' && $cleverness_todo_option['show_only_assigned'] == '0' && (current_user_can($cleverness_todo_option['view_all_assigned_capability']))) ||  ($cleverness_todo_option['list_view'] == '1' && $cleverness_todo_option['show_only_assigned'] == '1') && $cleverness_todo_option['assign'] == '0') {
				$assign_user = '';
				if ( $result->assign != '-1' && $result->assign != '' && $result->assign != '0') {
					$assign_user = get_userdata($result->assign);
					echo ' <small>['.__('assigned to', 'cleverness-to-do-list').' '.$assign_user->display_name.']</small>';
				}
			}
			if ( $cleverness_todo_option['show_dashboard_deadline'] == '1' && $result->deadline != '' )
				echo ' <small>['.__('Deadline:', 'cleverness-to-do-list').' '.$result->deadline.']</small>';
			if ( $cleverness_todo_option['show_progress'] == '1' && $result->progress != '' )
				echo ' <small>['.$result->progress.'%]</small>';
			if ( $cleverness_todo_option['list_view'] == '1' && $cleverness_todo_option['dashboard_author'] == '0' )
				echo ' <small>- '.__('added by', 'cleverness-to-do-list').' '.$user_info->display_name.'</small>';
			if (current_user_can($cleverness_todo_option['edit_capability']) || $cleverness_todo_option['list_view'] == '0')
		   		echo ' <small>(<a href="admin.php?page=cleverness-to-do-list&amp;action=edittodo&amp;id='. $result->id . '">'. __('Edit', 'cleverness-to-do-list') . '</a>)</small>';
			echo '</p>';
			}
	} else {
		echo '<p>'.__('No items to do.', 'cleverness-to-do-list').'</p>';
		}
		if (current_user_can($cleverness_todo_option['add_capability']) || $cleverness_todo_option['list_view'] == '0')
			echo '<p style="text-align: right">'. '<a href="admin.php?page=cleverness-to-do-list#addtodo">'. __('New To-Do Item &raquo;', 'cleverness-to-do-list').'</a></p>';
	}


/* Add Dashboard Widget */
function cleverness_todo_dashboard_setup() {
	global $userdata, $cleverness_todo_option;
   	get_currentuserinfo();

   	if (current_user_can($cleverness_todo_option['view_capability']) || $cleverness_todo_option['list_view'] == '0') {
		wp_add_dashboard_widget('cleverness_todo', __( 'To-Do List', 'cleverness-to-do-list' ) . ' <a href="admin.php?page=cleverness-to-do-list">'. __('&raquo;', 'cleverness-to-do-list').'</a>', 'cleverness_todo_todo_in_activity_box' );
		}
	}
?>