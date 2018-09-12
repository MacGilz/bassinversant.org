<?php
/**
 * Template Name: Page avec sidebar
 */

get_header(); ?>


 <?php 
    echo      '
    <div class="container">
    <div class="row">
        <div class="col-12">';
    echo the_breadcrumb();
    echo '</div>
    </div>
    </div>';


?>

<div class="container">

	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

           
        
			<?php
			while ( have_posts() ) : the_post();
          
				get_template_part( 'template-parts/content', 'page-sidebar' );

			endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</section><!-- #primary -->

</div>
<?php
get_footer();
