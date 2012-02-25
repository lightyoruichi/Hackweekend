<?php get_header(); ?>

<div id="content">

	<div id="homepagetop">
        
        <div class="textbanner">
			<?php $recent = new WP_Query("cat=" .ot_option('hp_top_cat'). "&showposts=1"); while($recent->have_posts()) : $recent->the_post();?>
            <h3><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h3>
            <?php endwhile; ?>
        </div>
        
        <div id="homeslider">
        	<?php include(TEMPLATEPATH."/includes/slider.php");?>
        </div>
        
        <div class="homewidgets">
        
            <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Homepage Top Right') ) : ?>
            	<div class="widget">
                    <h4>Widget Area</h4>
                    <p>This section is widgetized. To add widgets here, go to the <a href="<?php echo admin_url(); ?>widgets.php">Widgets</a> panel in your WordPress admin, and add the widgets you would like to <strong>Homepage Top Right</strong>.</p>
                    <p><small>*This message will be overwritten after widgets have been added</small></p>
                </div>
            <?php endif; ?>
        
        </div>
    
    </div>

    <div id="homepage">
    
    	<?php include(TEMPLATEPATH."/sidebar_left.php");?>
        
        <div class="homepagemid">

			<h3><?php echo cat_id_to_name(ot_option('hp_mid_cat')); ?></h3>
			
			<?php $recent = new WP_Query("cat=" .ot_option('hp_mid_cat'). "&showposts=" .ot_option('hp_mid_num') ); while($recent->have_posts()) : $recent->the_post();?>
                
            	<div class="homepagecontent">
                    
                    <a href="<?php the_permalink() ?>" rel="bookmark"><?php the_post_thumbnail( 'home-thumbnail' ); ?></a>
                    <h4><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h4>
                	<?php the_excerpt(); ?>
                
                </div>
                
            <?php endwhile; ?>

        </div>
        
        <?php include(TEMPLATEPATH."/sidebar_right.php");?>

	</div>

</div>

<!-- The main column ends  -->

<?php get_footer(); ?>