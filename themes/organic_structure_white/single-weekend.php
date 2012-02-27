<?php
/*
Template Name: Weekend
*/
?>
<?
if( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] )) {

	// Do some minor form validation to make sure there is content
	if (isset ($_POST['title'])) {
		$title =  $_POST['title'];
	} else {
		echo 'Please enter a title';
	}
	if (isset ($_POST['description'])) {
		$description = $_POST['description'];
	} else {
		echo 'Please enter the content';
	}
	$tags = $_POST['post_tags'];

	// Add the content of the form to $post as an array
	$post = array(
		'post_title'	=> $title,
		'post_content'	=> $description,
		'post_category'	=> $_POST['cat'],  // Usable for custom taxonomies too
		'tags_input'	=> $tags,
		'post_status'	=> 'publish',			// Choose: publish, preview, future, etc.
		'post_type'	=> 'register'  // Use a custom post type if you want to
	);
	wp_insert_post($post);  // Pass  the value of $post to WordPress the insert function
							// http://codex.wordpress.org/Function_Reference/wp_insert_post
	wp_redirect( home_url() );
} // end IF

// Do the wp_insert_post action to insert it
do_action('wp_insert_post', 'wp_insert_post'); 

?>
<?php get_header(); ?>

<div id="content">

	<div id="contentleft">	

		<div class="postarea">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			<?php
				$start_date_arr = split('/', get_field('start_date'));
				$start_date = date('jS M o', strtotime($start_date_arr[2] . '-' . $start_date_arr[1] . '-' . $start_date_arr[0]));
				if(get_field('start_time'))
					$start_date = get_field('start_time') . ' ' . $start_date;
				$end_date_arr = split('/', get_field('end_date'));
				$end_date = date('jS M o', strtotime($end_date_arr[2] . '-' . $end_date_arr[1] . '-' . $end_date_arr[0]));
				if(get_field('end_time'))
					$end_date = get_field('end_time') . ' ' . $end_date;
			?>
            
        	<div class="posttitle">	
				<h3><?php the_title(); ?></h3>	
				<div class="details">
					<p><?php echo ($start_date == $end_date) ? $start_date : '<b>Starts :</b> ' .$start_date . '<br><b>Ends :</b> ' . $end_date ?></p>
					<?php if(get_field('address')): ?>
						<p>
							<b>Venue:</b><br>
							<?php the_field('address');?>
						</p>
					<?php endif; ?>
				</div>
				<div class="map">
					<?php if(get_field('locations')): ?>
						<div style="width:200px;height:150px"><iframe width="200" height="150" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/maps?f=q&source=s_q&hl=en&geocode=&q=@<?php echo get_field('locations') ?>&ie=UTF8&z=12&t=m&iwloc=addr&output=embed"></iframe><br><table width="425" cellpadding="0" cellspacing="0" border="0"><tr><td align="left"><small><a href="http://maps.google.com/maps?f=q&source=s_q&hl=en&geocode=&q=@<?php echo get_field('locations') ?>&ie=UTF8&z=12&t=m&iwloc=addr">View Larger Map</a></small></td></tr></table></div>
					<?php endif; ?>
				</div>

<!-- New Post Form -->

<div id="postbox">
<form id="new_post" name="new_post" method="post" action="">
<input type="text" id="title" value="<?php global $current_user;
      get_currentuserinfo();

echo '' . $current_user->user_login . "\n";?>" tabindex="1" size="20" name="title" />
</p>
<p><label for="description">Description</label><br />

<textarea id="description" tabindex="3" name="description" cols="50" rows="6">
<?php global $current_user;
      get_currentuserinfo();

echo 'Username: ' . $current_user->user_login . "\n";
      echo 'User email: ' . $current_user->user_email . "\n";
      echo 'User first name: ' . $current_user->user_firstname . "\n";
      echo 'User last name: ' . $current_user->user_lastname . "\n";
      echo 'User display name: ' . $current_user->display_name . "\n";
      echo 'User ID: ' . $current_user->ID . "\n";
      echo 'Hackweekend1: ' . $current_user->hwkl1 . "\n";
      echo 'Hackweekend2: ' . $current_user->hwkl2 . "\n";
      echo 'Reason: ' . $current_user->reason . "\n";
?></textarea>

</p>
<p><label for="post_tags">Tags</label>
<input type="text" value="<?php echo $post->ID; ?>" tabindex="5" size="16" name="post_tags" id="post_tags" /></p>

<?php
if ( is_user_logged_in() ) {
    echo '<p align="left"><input class="info-button" type="submit" value="Apply for Hackweekend" name="submit" /></p>';
} else {
    echo do_shortcode('[wdfb_connect]Login with Facebook[/wdfb_connect]');
    echo 'or connect manually to Apply';
}
?>

<input type="hidden" name="post_type" id="post_type" value="post" />

<input type="hidden" name="action" value="post" />

<?php wp_nonce_field( 'new-post' ); ?>

</form>

</div>

<!--// New Post Form -->
				<br style="clear: both;" />
            </div>

			<?php the_content(__('Read More'));?>

			</br>
			<div style="clear:both;"></div>
			<?php trackback_rdf(); ?>

			<div class="postmeta">
				<p><?php _e("Filed under", 'organicthemes'); ?> <?php the_category(', ') ?> &middot; <?php _e("Tagged with", 'organicthemes'); ?> <?php the_tags('') ?></p>
			</div>

		</div>


		<?php endwhile; else: ?>
		<p><?php _e("Sorry, no posts matched your criteria.", 'organicthemes'); ?></p>
		<?php endif; ?>
		
<h2>List of recent people who registered</h2>
<?php
//Query 5 recent published post in descending order
$args = array( 'numberposts' => '10', 'order' => 'ASC', 'post_type' => 'weekend', 'post_status' => 'publish' );
$recent_posts = wp_get_recent_posts( $args );
//Now lets do something with these posts
foreach( $recent_posts as $recent )
{
	echo '<ul>';
    echo '<li> '.$recent["post_title"];
	echo '</ul>';
    //Do whatever else you please with this WordPress post
}
?>

	</div>

<?php include(TEMPLATEPATH."/sidebar_right.php");?>

</div>

<!-- The main column ends  -->

<?php get_footer(); ?>
