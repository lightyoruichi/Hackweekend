<?php
/* Creates a page to manage categories */
include_once 'cleverness-to-do-list-functions.php';
$cleverness_todo_option = get_option('cleverness_todo_settings');

$action = '';
if ( isset($_GET['action']) ) $action = $_GET['action'];
if ( isset($_POST['action']) ) $action = $_POST['action'];

switch($action) {

case 'addtodocat':
	if ( $_POST['cleverness_todo_cat_name'] != '' ) {
   		$catname = attribute_escape($_POST['cleverness_todo_cat_name']);
		$catvisibility = attribute_escape($_POST['cleverness_todo_cat_visibility']);
		$addcat_nonce = $_REQUEST['_wpnonce'];
		$message = cleverness_todo_insert_cat($catname, $catvisibility, $addcat_nonce);
	} else {
		$message = __('Category name cannot be blank.', 'cleverness-to-do-list');
	}
	break;

case 'updatetodocat':
	$catid = attribute_escape($_POST['cat_id']);
	$catname = attribute_escape($_POST['cleverness_todo_cat_name']);
	$catvisibility = attribute_escape($_POST['cleverness_todo_cat_visibility']);
	$updatecat_nonce = $_REQUEST['_wpnonce'];
	$message = cleverness_todo_update_cat($catid, $catname, $catvisibility, $updatecat_nonce);
	break;

case 'deletetodocat':
	$catid = attribute_escape($_GET['id']);
	$message = cleverness_todo_delete_cat($catid);
	break;

} // end switch

function cleverness_todo_categories() {
	global $wpdb, $userdata, $cleverness_todo_option, $message;
   	get_currentuserinfo();

   	$table_name = $wpdb->prefix . 'todolist_cats';
?>
<div class="wrap">
<div id="icon-plugins" class="icon32"></div> <h2><?php _e('To-Do List Categories', 'cleverness-to-do-list'); ?></h2>

	<?php if ( isset($message) ) : ?>
		<div id="message" class="updated fade"><p><?php echo $message; ?></p></div>
	<?php endif; ?>

	<?php
		if ($_GET['action'] == 'edittodocat') {
    	$id = $_GET['id'];
    	$todo = cleverness_todo_get_todo_cat($id);
	?>
	<h3><?php _e('Edit Category', 'cleverness-to-do-list') ?></h3>
    <form name="edittodocat" id="edittodocat" action="" method="post">
	<table class="form-table">
		<tr>
			<th scope="row"><label for="cleverness_todo_cat_name"><?php _e('Category Name', 'cleverness-to-do-list') ?></label></th>
			<td><input type="text" name="cleverness_todo_cat_name" id="cleverness_todo_cat_name" value="<?php echo wp_specialchars($todo->name, 1); ?>" /></td>
		</tr>
		<tr>
			<th scope="row"><label for="cleverness_todo_cat_visibility"><?php _e('Visibility', 'cleverness-to-do-list') ?></label></th>
		  	<td>
        		<select name="cleverness_todo_cat_visibility">
       	 			<option value="0"<?php if ( $todo->visibility == '0' ) echo ' selected="selected"'; ?>><?php _e('Public', 'cleverness-to-do-list') ?>&nbsp;</option>
        			<option value="1"<?php if ( $todo->visibility == '1' ) echo ' selected="selected"'; ?>><?php _e('Private', 'cleverness-to-do-list') ?></option>
        		</select>
				<br /><?php _e('Private categories are not visable using the sidebar widgets or shortcode.', 'cleverness-to-do-list') ?>
		  	</td>
		</tr>
	</table>
	<?php wp_nonce_field( 'todoupdatecat' ) ?>
	<input type="hidden" name="action" value="updatetodocat" />
	<input type="hidden" name="cat_id" value="<?php echo $todo->id ?>" />
    <p class="submit"><input type="submit" name="submit" class="button-primary" value="<?php _e('Edit Category &raquo;', 'cleverness-to-do-list') ?>" /></p>
	</form>

	<p><a href="admin.php?page=cleverness-to-do-list-cats"><?php _e('&laquo; Return to To-Do List Categories', 'cleverness-to-do-list'); ?></a></p>

	<?php } else { ?>

	<h3><?php _e('Add New Category', 'cleverness-to-do-list') ?></h3>
    <form name="addtodocat" id="addtodocat" action="" method="post">
	<table class="form-table">
		<tr>
			<th scope="row"><label for="cleverness_todo_cat_name"><?php _e('Category Name', 'cleverness-to-do-list') ?></label></th>
			<td><input type="text" name="cleverness_todo_cat_name" id="cleverness_todo_cat_name" value="" /></td>
		</tr>
		<tr>
			<th scope="row"><label for="cleverness_todo_cat_visibility"><?php _e('Visibility', 'cleverness-to-do-list') ?></label></th>
		  	<td>
        		<select name="cleverness_todo_cat_visibility">
       	 			<option value="0" selected="selected"><?php _e('Public', 'cleverness-to-do-list') ?>&nbsp;</option>
        			<option value="1"><?php _e('Private', 'cleverness-to-do-list') ?></option>
        		</select>
				<br /><?php _e('Private categories are not visable using the sidebar widgets or shortcode.', 'cleverness-to-do-list') ?>
		  	</td>
		</tr>
	</table>
	<?php wp_nonce_field( 'todoaddcat' ) ?>
	<input type="hidden" name="action" value="addtodocat" />
    <p class="submit"><input type="submit" name="submit" class="button-primary" value="<?php _e('Add Category &raquo;', 'cleverness-to-do-list') ?>" /></p>
	</form>

	<h3><?php _e('Existing Categories', 'cleverness-to-do-list') ?></h3>
	<table class="widefat">
	<thead>
		<tr>
			<th><?php _e('ID', 'cleverness-to-do-list') ?></th>
			<th><?php _e('Name', 'cleverness-to-do-list') ?></th>
	   		<th><?php _e('Visibility', 'cleverness-to-do-list') ?></th>
			<th><?php _e('Action', 'cleverness-to-do-list') ?></th>
		</tr>
	</thead>
	<tfoot>
    	<tr>
			<th><?php _e('ID', 'cleverness-to-do-list') ?></th>
			<th><?php _e('Name', 'cleverness-to-do-list') ?></th>
			<th><?php _e('Visibility', 'cleverness-to-do-list') ?></th>
   			<th><?php _e('Action', 'cleverness-to-do-list') ?></th>
   	 	</tr>
	</tfoot>
	<tbody>
		<?php
		$sql = "SELECT * FROM $table_name ORDER BY name";

   		$results = $wpdb->get_results($sql);
   		if ($results) {
	   		foreach ($results as $result) {
	   	?>
	   <tr>
     		<td><?php echo $result->id; ?></td>
     		<td><?php echo $result->name; ?></td>
     		<td><?php if ( $result->visibility == '0' ) echo __('Public', 'cleverness-to-do-list'); else echo __('Private', 'cleverness-to-do-list'); ?></td>
	 		<td><a href="admin.php?page=cleverness-to-do-list-cats&amp;action=edittodocat&amp;id=<?php echo $result->id; ?>"><?php _e('Edit', 'cleverness-to-do-list') ?></a> |
			 <a href="admin.php?page=cleverness-to-do-list-cats&amp;action=deletetodocat&amp;id=<?php echo $result->id; ?>"><?php _e('Delete', 'cleverness-to-do-list') ?></a></td>
   		</tr>
		<?php } } ?>
	</tbody>
	</table>

	<?php } ?>

</div>
<?php
}
?>