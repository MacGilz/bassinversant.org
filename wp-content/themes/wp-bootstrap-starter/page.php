<?php

get_header(); ?>


 <?php if( !is_front_page() ) {
    echo      '
    <div class="container">
    <div class="row">
        <div class="col-12">';
    echo the_breadcrumb();
    echo '</div>
    </div>
    </div>';
}
?>

 <?php if (!is_front_page()) echo '<div class="container">' ?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">


			<?php
			while ( have_posts() ) : the_post();
          
               if ( is_front_page() ) : 
                get_template_part( 'template-parts/content', 'homepage' );
               else :
				get_template_part( 'template-parts/content', 'page' );


            endif;
            
			endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</section><!-- #primary -->
 <?php if (!is_front_page()) echo '</div>' ?>
<?php
//get_sidebar();
get_footer();
