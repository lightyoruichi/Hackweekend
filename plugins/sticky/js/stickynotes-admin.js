// JavaScript Document
jQuery(document).ready(function(){
	jQuery('.color-box').each(function(){
		var color_box = jQuery(this);
		var bg = '#'+jQuery(this).find('.bg').val();
		var border = '#'+jQuery(this).find('.border').val();
		var text = '#'+jQuery(this).find('.text').val();
		
		jQuery(this).find('.bg').ColorPicker({
			color: bg,
			onSubmit: function(hsb, hex, rgb, el) {jQuery(el).val(hex);jQuery(el).ColorPickerHide();},
			onBeforeShow: function () {color_box.find(this).ColorPickerSetColor(this.value);},
			onChange: function (hsb, hex, rgb) {color_box.find('.bg').val(hex);color_box.find('.color-box-box').css('backgroundColor', '#' + hex);}
		}).bind('keyup', function(){jQuery(this).ColorPickerSetColor(this.value);});
		
		jQuery(this).find('.border').ColorPicker({
			color: border,
			onSubmit: function(hsb, hex, rgb, el) {jQuery(el).val(hex);jQuery(el).ColorPickerHide();},
			onBeforeShow: function () {color_box.find(this).ColorPickerSetColor(this.value);},
			onChange: function (hsb, hex, rgb) {color_box.find('.border').val(hex);color_box.find('.color-box-box').css('borderColor', '#' + hex);}
		}).bind('keyup', function(){jQuery(this).ColorPickerSetColor(this.value);});
		
		jQuery(this).find('.text').ColorPicker({
			color: text,
			onSubmit: function(hsb, hex, rgb, el) {jQuery(el).val(hex);jQuery(el).ColorPickerHide();},
			onBeforeShow: function () {color_box.find(this).ColorPickerSetColor(this.value);},
			onChange: function (hsb, hex, rgb) {color_box.find('.text').val(hex);color_box.find('.color-box-box').css('color', '#' + hex);}
		}).bind('keyup', function(){jQuery(this).ColorPickerSetColor(this.value);});
	});
	
	jQuery("#stickynote_style").click(function(){
		var style = jQuery("#stickynote_style option:selected").attr('style');
		jQuery("#stickynote_style").attr('style', style);
	});
});