<?php
//Custom Header Image Code -- from the WordPress.com API
define('NO_HEADER_TEXT', true);
define('HEADER_IMAGE', '%s/images/logo.png'); // %s is theme dir uri
define('HEADER_IMAGE_WIDTH', 600);
define('HEADER_IMAGE_HEIGHT', 120);

function header_style() { ?>
<style type="text/css">
#header #title a {
	background: url(<?php header_image(); ?>) no-repeat;
}
</style>
<?php }
function admin_header_style() { ?>
<style type="text/css">
#headimg {
	width: <?php echo HEADER_IMAGE_WIDTH; ?>px;
	height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;
	background-image: url(<?php header_image(); ?>) top left no-repeat;
}
#headimg h1,
#headimg #desc {
	display: none;
}
}
</style>
<?php }
add_custom_image_header('header_style', 'admin_header_style');  //Add the custom header
?>