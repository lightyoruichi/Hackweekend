<?php
function wsEscapeString($value) {
	if (version_compare(phpversion(),"4.3.0")=="-1") {
		return mysql_escape_string($value);
	} else {
		return mysql_real_escape_string($value);
	}
}

function qs($value)
{
	if( is_array($value) ) {
		return array_map("quote_smart", $value);
	} else {
		if( get_magic_quotes_gpc() ) {
			$value = stripslashes($value);
		}
		if( $value == '' ) {
			$value = '';
		}
		if( !is_numeric($value) || $value[0] == '0' ) {
			$value = "'".wsEscapeString($value)."'";
		}
		return $value;
	}
}