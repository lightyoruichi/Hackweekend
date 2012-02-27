<?php

/*
 *	Advanced Custom Fields - New field template
 *	
 *	Create your field's functionality below and use the function:
 *	register_field($class_name, $file_path) to include the field
 *	in the acf plugin.
 *
 *	Documentation: 
 *
 */
 
 
class xa_time_field extends acf_Field
{

	/*--------------------------------------------------------------------------------------
	*
	*	Constructor
	*	- This function is called when the field class is initalized on each page.
	*	- Here you can add filters / actions and setup any other functionality for your field
	*
	*	@author Elliot Condon
	*	@since 2.2.0
	* 
	*-------------------------------------------------------------------------------------*/
	
	function __construct($parent)
	{
		// do not delete!
    	parent::__construct($parent);
    	
    	// set name / title
    	$this->name = 'xa_time_field'; // variable name (no spaces / special characters / etc)
		$this->title = __("Time",'acf'); // field label (Displayed in edit screens)
		
   	}

	
	/*--------------------------------------------------------------------------------------
	*
	*	create_options
	*	- this function is called from core/field_meta_box.php to create extra options
	*	for your field
	*
	*	@params
	*	- $key (int) - the $_POST obejct key required to save the options to the field
	*	- $field (array) - the field object
	*
	*	@author Elliot Condon
	*	@since 2.2.0
	* 
	*-------------------------------------------------------------------------------------*/
	
	function create_options($key, $field)
	{
		// defaults
		$field['time_format'] = isset($field['time_format']) ? $field['time_format'] : '';
		
		?>
		<tr class="field_option field_option_<?php echo $this->name; ?>">
			<td class="label">
				<label><?php _e("Time format",'acf'); ?></label>
				<p class="description"><?php _e("eg. G:i. read more about",'acf'); ?> <a href="http://php.net/manual/en/function.date.php">formatDate</a></p>
			</td>
			<td>
				<input type="text" name="fields[<?php echo $key; ?>][time_format]" value="<?php echo $field['time_format']; ?>" />
			</td>
		</tr>

		<?php
	}
		
	
	

	
	
	/*--------------------------------------------------------------------------------------
	*
	*	pre_save_field
	*	- this function is called when saving your acf object. Here you can manipulate the
	*	field object and it's options before it gets saved to the database.
	*
	*	@author Elliot Condon
	*	@since 2.2.0
	* 
	*-------------------------------------------------------------------------------------*/
	
	function pre_save_field($field)
	{
		// do stuff with field (mostly format options data)
		
		return parent::pre_save_field($field);
	}
	
	
	/*--------------------------------------------------------------------------------------
	*
	*	create_field
	*	- this function is called on edit screens to produce the html for this field
	*
	*	@author Elliot Condon
	*	@since 2.2.0
	* 
	*-------------------------------------------------------------------------------------*/
	
	function create_field($field)
	{
		// vars
		$field['time_format'] = isset($field['time_format']) ? $field['time_format'] : 'G:i';
		
		// html
		echo '<input type="text" value="' . $field['value'] . '" class="xa_timepicker" name="' . $field['name'] . '" data-time_format="' . $field['time_format'] . '" />';

	}
	
	
	/*--------------------------------------------------------------------------------------
	*
	*	admin_head
	*	- this function is called in the admin_head of the edit screen where your field
	*	is created. Use this function to create css and javascript to assist your 
	*	create_field() function.
	*
	*	@author Elliot Condon
	*	@since 2.2.0
	* 
	*-------------------------------------------------------------------------------------*/
	
	function admin_head()
	{
	

		$xapath = get_bloginfo('template_url');
		// add datepicker
		echo '<script type="text/javascript" src="'. $xapath .'/custom-fields/timepicker/jquery.ui.datepicker.js" ></script>';
		echo '<script type="text/javascript" src="'. $xapath .'/custom-fields/timepicker/jquery.ui.slider.js" ></script>';
		echo '<script type="text/javascript" src="'. $xapath .'/custom-fields/timepicker/jquery-ui-timepicker-addon.js" ></script>';
		echo '<link rel="stylesheet" type="text/css" href="'. $xapath .'/custom-fields/timepicker/jquery-ui-timepicker-addon.css" />';
		?>
		<script type="text/javascript">
		(function($){

				
			$('#poststuff input.xa_timepicker').live('focus', function(){

				var input = $(this);
				
				if(!input.hasClass('active'))
				{
					
					// vars
					var format = input.attr('data-time_format') ? input.attr('data-time_format') : 'G:i';
					
					// add date picker and refocus
					input.addClass('active').timepicker({ 
						dateFormat: format 
					})
					
					// set a timeout to re focus the input (after it has the datepicker!)
					setTimeout(function(){
						input.trigger('blur').trigger('focus');
					}, 1);
					
					// wrap the datepicker (only if it hasn't already been wrapped)
					if($('body > #ui-xa_timepicker-div').length > 0)
					{
						$('#ui-xa_timepicker-div').wrap('<div class="ui-acf" />');
					}
					
				}
				
			});
			
		})(jQuery);
		</script>
		<?php
	}
	
	
	/*--------------------------------------------------------------------------------------
	*
	*	admin_print_scripts / admin_print_styles
	*	- this function is called in the admin_print_scripts / admin_print_styles where 
	*	your field is created. Use this function to register css and javascript to assist 
	*	your create_field() function.
	*
	*	@author Elliot Condon
	*	@since 3.0.0
	* 
	*-------------------------------------------------------------------------------------*/
	
	function admin_print_scripts()
	{
	
	}
	
	function admin_print_styles()
	{
		
	}

	
	/*--------------------------------------------------------------------------------------
	*
	*	update_value
	*	- this function is called when saving a post object that your field is assigned to.
	*	the function will pass through the 3 parameters for you to use.
	*
	*	@params
	*	- $post_id (int) - usefull if you need to save extra data or manipulate the current
	*	post object
	*	- $field (array) - usefull if you need to manipulate the $value based on a field option
	*	- $value (mixed) - the new value of your field.
	*
	*	@author Elliot Condon
	*	@since 2.2.0
	* 
	*-------------------------------------------------------------------------------------*/
	
	function update_value($post_id, $field, $value)
	{
		// do stuff with value
		
		// save value
		parent::update_value($post_id, $field, $value);
	}
	
	
	
	
	
	/*--------------------------------------------------------------------------------------
	*
	*	get_value
	*	- called from the edit page to get the value of your field. This function is useful
	*	if your field needs to collect extra data for your create_field() function.
	*
	*	@params
	*	- $post_id (int) - the post ID which your value is attached to
	*	- $field (array) - the field object.
	*
	*	@author Elliot Condon
	*	@since 2.2.0
	* 
	*-------------------------------------------------------------------------------------*/
	
	function get_value($post_id, $field)
	{
		// get value
		$value = parent::get_value($post_id, $field);
		
		// format value
		
		// return value
		return $value;		
	}
	
	
	/*--------------------------------------------------------------------------------------
	*
	*	get_value_for_api
	*	- called from your template file when using the API functions (get_field, etc). 
	*	This function is useful if your field needs to format the returned value
	*
	*	@params
	*	- $post_id (int) - the post ID which your value is attached to
	*	- $field (array) - the field object.
	*
	*	@author Elliot Condon
	*	@since 3.0.0
	* 
	*-------------------------------------------------------------------------------------*/
	
	function get_value_for_api($post_id, $field)
	{
		// get value
		$value = $this->get_value($post_id, $field);
		
		// format value
		
		// return value
		return $value;

	}
	
}

?>