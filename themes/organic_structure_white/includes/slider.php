        <div class="jFlow"> 
        
            <div id="prev_btn">
                <a href="#blank"><img src="<?php bloginfo('template_url'); ?>/images/blank_btn.gif" alt="Previous Tab" class="jFlowPrev" /></a>
            </div>
            <div id="next_btn">
                <a href="#blank"><img src="<?php bloginfo('template_url'); ?>/images/blank_btn.gif" alt="Next Tab" class="jFlowNext" /></a>
            </div>
      
            <div id="slides">
                <?php $recent = new WP_Query("cat=" .ot_option('slider_cat'). "&showposts=" .ot_option('slider_num') ); while($recent->have_posts()) : $recent->the_post();?>
                <div>
                    <span class="jFlowControl"></span>
                    <a href="<?php the_permalink() ?>" rel="bookmark"><?php the_post_thumbnail( 'home-feature' ); ?></a>
                    <h4><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h4>
                    <?php the_excerpt(); ?>
                </div>
                <?php endwhile; ?>
            </div>
            
        </div>