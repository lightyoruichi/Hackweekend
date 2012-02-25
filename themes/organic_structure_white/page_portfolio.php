<?php
/*
Template Name: Portfolio Page
*/
?>

<?php get_header(); ?>

<div id="content">

	<div id="contentwide">
	
		<div class="postarea">
        
        	<h3><?php the_title(); ?></h3>
            
            <?php $wp_query = new WP_Query(array('cat'=>ot_option('portfolio_cat'),'showposts'=>ot_option('portfolio_cat_num'),'paged'=>$paged)); ?>
			<?php if($wp_query->have_posts()) : while($wp_query->have_posts()) : $wp_query->the_post(); ?>
            <?php global $more; $more = 0; ?>
            
            <div class="portfolio">
            
            	<div class="portfolioimg">
                    <a href="<?php the_permalink() ?>" rel="bookmark"><?php the_post_thumbnail( 'portfolio' ); ?></a>
                </div>
            
            	<div class="portfoliotitle">              
                    <h4><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h4>
                    <?php the_excerpt(); ?>
                </div>
            
            </div>
            
            <div style="clear:both;"></div>
							
			<?php endwhile; ?>
            
            <div id="prevLink"><p><?php previous_posts_link(); ?></p></div>
			<div id="nextLink"><p><?php next_posts_link(); ?></p></div>
            
            <?php else : // do not delete ?>

            <h3><?php _e("Page not Found"); ?></h3>
            <p><?php _e("We're sorry, but the page you're looking for isn't here."); ?></p>
            <p><?php _e("Try searching for the page you are looking for or using the navigation in the header or sidebar"); ?></p>

			<?php endif; // do not delete ?>
		
		</div>
		
	</div>
		
</div>

<!-- The main column ends  -->

<?php get_footer(); ?>