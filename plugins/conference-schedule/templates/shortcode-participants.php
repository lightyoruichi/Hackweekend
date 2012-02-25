<?php if (!defined ('ABSPATH')) die ('No direct access allowed'); ?>

<?php if( $participants->have_posts() ) : ?>
	<ul class="participants">
			<?php global $post; while ( $participants->have_posts() ) : $participants->the_post(); ?>
			<li <?php post_class( 'participant vcard participant-' . $post->post_name ); ?> id="participant-<?php the_ID(); ?>">
				<h2 class="participant-title">
					<a href="<?php echo esc_attr( add_query_arg( array( 'cs_referer' => urlencode( $_SERVER['REQUEST_URI'] ) ), get_permalink() ) ); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'twentyten' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
						<?php if ( has_post_thumbnail() ) : ?>
							<?php the_post_thumbnail( 'participant-lineup' ); ?>
						<?php endif; ?>
						<span class="fn"><?php the_title(); ?></span>
					</a>
				</h2>
				<?php the_excerpt(); ?>
			</li>
 		<?php endwhile; ?>
	</ul>
<?php else : ?>
	<p class="no-participants">No participants booked yet.</p>
<?php endif; ?>
<div class="clear"><!--  --></div>
