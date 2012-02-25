<?php

function zing_mailz_footer() {
	$bail_out = ( ( defined( 'WP_ADMIN' ) && WP_ADMIN == true ) || ( strpos( $_SERVER[ 'PHP_SELF' ], 'wp-admin' ) !== false ) );
	if ( $bail_out ) return $footer;

	//Please contact us if you wish to remove the Zingiri logo in the footer
	$f='<div style="clear:both"></div>';
	$f.='<center style="margin-top:0px;font-size:x-small">';
	$f.='Wordpress and <a href ="http://www.phplist.com/" target="_blank">phpList</a> integration by <a href="http://www.zingiri.net" target="_blank">Zingiri</a>';
	$f.='</center>';
	
	return $f;
}
?>