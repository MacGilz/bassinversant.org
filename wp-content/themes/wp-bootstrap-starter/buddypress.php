<?php

get_header(); ?>



<div class="container">

	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">


			<?php
			while ( have_posts() ) : the_post();
          if (bp_is_user()){
				get_template_part( 'template-parts/buddy', 'membre' );

          }
            elseif(bp_is_group()){
               get_template_part( 'template-parts/buddy', 'groupe' ); 
            }
            else{
             get_template_part( 'template-parts/content', 'page' );   
            }
			endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</section><!-- #primary -->
</div>
<?php
//get_sidebar();
get_footer();
