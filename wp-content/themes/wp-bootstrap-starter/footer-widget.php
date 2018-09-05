
        <div id="footer-widget" class="row m-0 py-4">
            <div class="container">
                <div class="row">
                        <div class="col-12 col-md-4 "><?php dynamic_sidebar( 'footer-1' ); ?></div>
                    
                    
                        <div class="col-12 col-md-4"><?php dynamic_sidebar( 'footer-2' ); ?></div>
                    
                    
                        <div class="col-12 col-md-4">
                        <a href="<?php echo esc_url( home_url( '/' )); ?>">
                           <?php  include "logo-svg.php" ?>                            
                        </a> 
                        <?php dynamic_sidebar( 'footer-3' ); ?>
                          
                    </div>
                    
                </div>
            </div>
        </div>

