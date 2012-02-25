<!-- begin footer -->

<div style="clear:both;"></div>
    <div id="footertopbg">    
                <div id="footertop">
                            <div class="footertopleft">
                            				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer Left') ) : ?>
                            				                <?php endif; ?>
                            </div>
                            <div class="footertopmidleft">
                                  				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer Mid Left') ) : ?>
                                  				            <?php endif; ?>
                           </div>
                           <div class="footertopmidright">
                                      				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer Mid Right') ) : ?>
                                      				          <?php endif; ?>
                           </div>
                           <div class="footertopright">
                           				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer Right') ) : ?>
                           				                <?php endif; ?>
                          </div>
                          </div>
                          </div>
                          <div id="footerbg">
                          <div id="footer">
                          <div class="footerleft">
                          <div class="footertop">
                          <p><?php _e("Copyright", 'organicthemes'); ?> <?php echo date('Y'); ?> · <a href="<?php bloginfo('rss_url'); ?>" target="_blank">RSS Feed</a> · <?php wp_loginout(); ?></p>
                          </div>
                          <div class="footerbottom">
                          <p><fb:like href="http://www.facebook.com/pages/Hackweekend/168750623185734" send="true" layout="button_count" width="200" show_faces="false" colorscheme="dark" font="lucida grande"></fb:like></p>
                          </div>
                          </div>
                          <div class="footerright">
                     <a href="http://www.weekend.my" target="_blank">
                     <img src="http://hack.weekend.my/images/logo-white-horizontal.png" alt="The *Weekend Movement" /></a>
                            </div>
                           	</div>	
                           </div>
                           </div>
                           <?php do_action('wp_footer'); ?>
                           <?php echo stripslashes(ot_option('tracking')); // tracking code ?>
</body></html>
