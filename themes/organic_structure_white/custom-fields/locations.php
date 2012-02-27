<?php

/*
 *	Advanced Custom Fields - New field template
 *	
 *	Create your fields functionality below and use the function:
 *	register_field($class_name, $file_path) to include the field
 *	in the acf plugin.
 *
 */

 
class Location_field extends acf_Field
{
	
	function __construct($parent)
	{
		// do not delete!
    	parent::__construct($parent);
    	
    	// set name / title
    	$this->name = 'location'; // variable name (no spaces / special characters / etc)
		$this->title = __("Location",'acf'); // field label (Displayed in edit screens)
		
   	}
	
	function create_options($key, $field)
	{
		
	}
	
	
	function pre_save_field($field)
	{
		// do stuff with field (mostly format options data)
		
		return parent::pre_save_field($field);
	}
	
		
	function create_field($field)
	{
		echo '<input type="text" value="' . $field['value'] . '" id="' . $field['name'] . '" class="' . $field['class'] . '" name="' . $field['name'] . '" />';
		echo '<div id="map"></div>';
	}
	

	function admin_head()
	{
		?>
		<style type="text/css">
			#map {width: 100%; height: 500px; margin-top: 10px;}
		</style>
		    <script src='http://maps.googleapis.com/maps/api/js?sensor=false' type='text/javascript'></script>
			<script type="text/javascript">
				function load() {
					var exists = 0, marker;
					// get the lat and lng from our input field
					var coords = jQuery('.location').val();
					// if input field is empty, default coords
					if (coords === '') {
						lat = 3.11; 
						lng = 101.6337;
					} else {
						// split the coords by ,
						temp = coords.split(',');
						lat = parseFloat(temp[0]);
						lng = parseFloat(temp[1]);
						exists = 1;
					}
					// coordinates to latLng
					var latlng = new google.maps.LatLng(lat, lng);
					// map Options
					var myOptions = {
					  zoom: 15,
					  center: latlng,
					  mapTypeId: google.maps.MapTypeId.ROADMAP
					};
					//draw a map
					var map = new google.maps.Map(document.getElementById("map"), myOptions);
					
					// if we had coords in input field, put a marker on that spot
					if(exists == 1) {
						marker = new google.maps.Marker({
							position: map.getCenter(),
							map: map,
							draggable: true
						});
					}
					
					// click event
					google.maps.event.addListener( map, 'click', function( point ) {
						if (exists == 0) {
							exists = 1;
							// drawing the marker on the clicked spot
							marker = new google.maps.Marker({
								position: point.latLng,
								map: map,
								draggable: true
							});
							//put the coordinates to input field
							jQuery('.location').val(marker.getPosition().lat() + ',' + marker.getPosition().lng());
							// drag event for add screen
							google.maps.event.addListener(marker, "dragend", function (mEvent) { 
								jQuery('.location').val(mEvent.latLng.lat() + ',' + mEvent.latLng.lng());
							});
						} else {
							// only one marker on the map!
							alert('Marker already on the map! Drag it to desired location.');
						}
					});
					//dragend event for update screen
					if(exists === 1) {
						google.maps.event.addListener(marker, "dragend", function (mEvent) { 
							jQuery('.location').val(mEvent.latLng.lat() + ',' + mEvent.latLng.lng());
						});
					}
					
					// Add another field to handle our Geocoding Search Query
					var geocoder = new google.maps.Geocoder();
					var $mapParent = jQuery('#map').parent();
					
					$mapParent.after('<div class="field" style="overflow:hidden"><label for="locatometer_address" class="field_label">Search Query</label><input id="locatometer_address" name="locatometer_address" type="text" value="Tandemic" /><input type="button" id="locatometer" value="Search" class="button preview" /></div>');

					jQuery('input#locatometer').bind( 'click', function ( )	{
						
						var addr = jQuery('input#locatometer_address').val();

						geocoder.geocode({ address: addr + ', MY'}, function ( results, status )  {
							
							if ( status == google.maps.GeocoderStatus.OK ) {
								map.setCenter( results[0].geometry.location );

								if ( exists === 0) {
									
									exists = 1;
									marker = new google.maps.Marker({
										position: results[0].geometry.location,
										map: map,
										draggable: true
									});

									marker.setMap( map );
									
								}
								else {
									marker.setPosition( results[0].geometry.location );
								}
								
								$mapParent.find('.location').val(marker.getPosition().lat() + ',' + marker.getPosition().lng())
								
							}
							else {
								alert("Imagine the fail Whale, and it's saying : " + status );
							}
							
						});
						
						return false;
					});
					
				}

			jQuery(document).ready(function(){
				if (jQuery('.location').length > 0) {
					load();
				}
			});
			</script>

		<?php
	}
	
	
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