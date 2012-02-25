<?php

/*  Copyright 2011 Simon Wheatley

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

*/

/**
 * For use within a Participant loop, displays the sessions the current
 * participant is taking part in.
 *
 * @param string $before Optional. Before list.
 * @param string $sep Optional. Separate items using this.
 * @param string $after Optional. After list.
 * @return void (Echoes HTML)
 * @author Simon Wheatley
 **/
function the_sessions( $before = '', $sep = ', ', $after = '' ) {
	$sessions = get_the_sessions( $before, $sep, $after );
	echo apply_filters( 'cs_the_sessions', $sessions, $before, $sep, $after );
}

/**
 * For use within a Participant loop, retrieve a participants
 * sessions as a list with specified format. 
 *
 * @param string $before Optional. Before list.
 * @param string $sep Optional. Separate items using this.
 * @param string $after Optional. After list.
 * @return string The HTML for the sessions list
 * @author Simon Wheatley
 **/
function get_the_sessions( $before = '', $sep = ', ', $after = '' ) {
	global $post;
	$session_term = get_term_by( 'slug', $post->post_name, 'participants' );
	$session_ids = get_objects_in_term( $session_term->term_id, 'participants' );

	$output = '';
	$sessions = array(); 
	foreach ( $session_ids as $s )
		$sessions[] = "<a href='" . get_permalink( $s ) . "'>" . get_the_title( $s ) . "</a>";

	$output = apply_filters( "cs_session_links", $sessions, $session_ids );
	return $before . join( $sep, $sessions ) . $after;
}

/**
 * Whether session has a schedule set, for use within a Session loop.
 *
 * @return bool Returns true if the current session has a schedule
 * @author Simon Wheatley
 **/
function has_schedule() {
	return (bool) get_post_meta( get_the_ID(), '_cs_has_schedule', true );
}

/**
 * Display the time at which the session starts.
 *
 * @param string $time_format Optional Either 'G', 'U', or php date format, defaults to the value specified in this plugin's time_format option.
 * @param string $short_time_format Optional Either 'G', 'U', or php date format defaults to the value specified in this plugin's short_time_format option.
 * @return void (Echoes)
 */
function the_start_time( $time_format = null, $short_time_format = null ) {
	echo apply_filters( 'cs_the_start_time', get_the_start_time( $time_format, $short_time_format ), $time_format, $short_time_format );
}

/**
 * Retrieve the time at which the session starts.
 *
 * @param string $time_format Optional Either 'G', 'U', or php date format, defaults to the value specified in this plugin's time_format option.
 * @param string $short_time_format Optional Either 'G', 'U', or php date format defaults to the value specified in this plugin's short_time_format option.
 * @param int|object $post Optional post ID or object. Default is global $post object.
 * @return string
 */
function get_the_start_time( $time_format = null, $short_time_format = null, $post = null ) {
	$post = get_post( $post );
	$start = get_post_meta( $post->ID, '_cs_schedule_start', true );
	
	$the_start_time = cs_format_time( $start, $time_format, $short_time_format );

	return apply_filters( 'get_the_start_time', $the_start_time, $time_format, $short_time_format, $post );
}

/**
 * Display the time at which the session starts.
 *
 * @param string $time_format Optional Either 'G', 'U', or php date format, defaults to the value specified in this plugin's time_format option.
 * @param string $short_time_format Optional Either 'G', 'U', or php date format defaults to the value specified in this plugin's short_time_format option.
 * @return void (Echoes)
 */
function the_end_time( $time_format = null, $short_time_format = null ) {
	echo apply_filters( 'cs_the_end_time', get_the_end_time( $time_format, $short_time_format ), $time_format, $short_time_format );
}

/**
 * Retrieve the time at which the session starts.
 *
 * @param string $time_format Optional Either 'G', 'U', or php date format, defaults to the value specified in this plugin's time_format option.
 * @param string $short_time_format Optional Either 'G', 'U', or php date format defaults to the value specified in this plugin's short_time_format option.
 * @param int|object $post Optional post ID or object. Default is global $post object.
 * @return string
 */
function get_the_end_time( $time_format = null, $short_time_format = null, $post = null ) {
	$post = get_post( $post );
	$end = get_post_meta( $post->ID, '_cs_schedule_end', true );
	
	$the_end_time = cs_format_time( $end, $time_format, $short_time_format );

	return apply_filters( 'get_the_end_time', $the_end_time, $time_format, $short_time_format, $post );
}

/**
 * Utility function which handles the date formatting for the various schedule star
 * and end time template tags.
 *
 * @param int $timestamp A UNIX timestamp
 * @param string $time_format Optional Either 'G', 'U', or php date format, defaults to the value specified in this plugin's time_format option.
 * @param string $short_time_format Optional Either 'G', 'U', or php date format defaults to the value specified in this plugin's short_time_format option.
 * @return string A formatted date string
 * @author Simon Wheatley
 **/
function cs_format_time( $timestamp, $time_format, $short_time_format ) {
	global $conf_sched;

	if ( $time_format == null )
		$time_format = $conf_sched->get_option( 'time_format' );
	if ( $short_time_format == null )
		$short_time_format = $conf_sched->get_option( 'short_time_format' );

	if ( ! (int) date( 'i', $timestamp ) ) {
		$formatted_time = date( $short_time_format, $timestamp );
	} else {
		$formatted_time = date( $time_format, $timestamp );
	}

	return $formatted_time;
}

?>