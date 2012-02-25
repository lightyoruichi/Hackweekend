<?php
 
function sn_dashboard_widget_function() {
global $wpdb;
$table_name = $wpdb->prefix."k_note";
$note = $wpdb->get_var($wpdb->prepare("SELECT note FROM $table_name"));

echo nl2br($note); '<br />';
}

function sn_add_dashboard_widgets() {
	wp_add_dashboard_widget('sn_dashboard_widget', 'Sticky Note - Your personal notes', 'sn_dashboard_widget_function');	
} 

add_action('wp_dashboard_setup', 'sn_add_dashboard_widgets' );

?>