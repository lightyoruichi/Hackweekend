<?php 
	add_action('admin_menu', 'plugin_admin_add_page');
	function plugin_admin_add_page() {
	add_options_page('Sticky Note Options', 'Sticky Note Options', 'manage_options', 'sticky-note', 'plugin_options_page');
	}
?>
<?php // display the admin options page
function plugin_options_page() {
?>
<style>
.text { font-size:11px; color:#000; font-family:Arial, Helvetica, sans-serif; }
</style>
<h2 style="font-weight:100; font-family:Arial, Helvetica, sans-serif;">Sticky Note Options</h2>
<div class="text"> 
  <p><strong>HTML Allowed.<br>
  Automatic Line Break:</strong> On</p>
  <form method="post" action="/wp-content/plugins/sticky-note/options.php">
  <?php wp_nonce_field('update-options'); ?>

<?php global $wpdb;
$table_name = $wpdb->prefix."k_note";
$note = $wpdb->get_var($wpdb->prepare("SELECT note FROM $table_name"));
?>
    
    Edit your personal note below:<br>
  <textarea name="k_note" cols="70" rows="10"><?php echo ($note); ?></textarea>
  <input type="hidden" name="action" value="update" />
  <input type="hidden" name="page_options" value="k_note" /><br><br>
  <input type="submit" class="button-primary" value="<?php _e('Save Note') ?>" />
    
</form>
</div>

<?php
}?>