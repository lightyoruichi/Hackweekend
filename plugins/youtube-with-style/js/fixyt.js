jQuery(document).ready(function($) {
	totalwidth = (jQuery(".youtube_gallery").width());
	numberdivs = totalwidth/135;
	numberdivs = (numberdivs < 0 ? -1 : 1) * Math.floor(Math.abs(numberdivs))
	spacing = totalwidth - (135*numberdivs);
	jQuery(".youtube_gallery").css({ 'margin-left' : (spacing/2), 'margin-right' : (spacing/2) });
});
