<div class="row">

    <article id="post-<?php the_ID(); ?>" <?php post_class( 'col-12'); ?>>

        <header class="entry-header">
            <span class="vaguepost"><img src="/wp-content/themes/imgs/vague.svg" /></span>
            <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
        </header>

        <div class="row">
            <div class="col-12 col-md-8  pr-md-5">



                <div class="entry-content">



                    <?php if (has_post_thumbnail( $post->ID ) ):
            
         $featured_img_url = get_the_post_thumbnail_url(get_the_ID(),'full'); 
   ?>
     
        <a href="<?php echo $featured_img_url?>">
		<?php the_post_thumbnail(array(380,380),['class' => ' img-thumbnail float-left mr-xs-0 mr-sm-0 mr-md-4']);
        ?>

        </a>

                
                    <?php endif; ?>

                    <?php               
                    the_content();
                    ?>

                </div>
                <!-- .entry-content -->

            </div>
            <div class="col-12 col-md-4">
                <aside id="secondary" class="widget-area" role="complementary">
                    <?php get_sidebar(); ?>
                </aside>
            </div>
        </div>
    </article>
    <!-- #post-## -->



</div>