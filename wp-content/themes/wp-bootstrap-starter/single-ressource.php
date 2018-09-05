<?php
/**
 * TEMPLATE RESSOURCE
 */

get_header(); ?>

<div class="container">

    <div class="row">
        <div class="col-12">
   <?php  echo the_breadcrumb(); ?>
    </div>
    </div>
    
<div class="row">
	<section id="primary" class="content-area col-12">
		<main id="main" class="site-main" role="main">

		<?php
		while ( have_posts() ) : the_post();

			get_template_part( 'template-parts/content-ressource', get_post_format() );

			    the_post_navigation();

		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</section><!-- #primary -->
  <?php
//get_sidebar();
    ?>
			</div><!-- .row -->
		</div><!-- .container -->
<?php

get_footer();
