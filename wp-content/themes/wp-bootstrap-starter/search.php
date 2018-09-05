<?php
/**
 * Template Name: Recherche
 */
get_header(); ?>
  <div class="container">
    <div class="row">
    <div class=" col-12 col-lg-8">
	<section id="search-results" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php

		if (have_posts() ) : ?>

			<header class="page-header">
                 <span class="vaguepost"><img src="/wp-content/themes/imgs/vague.svg" /></span>
               <?php 
                if( get_search_query()!='') : ?>
				<h2 class="search"><?php printf( esc_html__( 'Search Results for: %s', 'wp-bootstrap-starter' ), '<span style="color:#009492">' . get_search_query() . '</span>' ); ?></h2>
                <?php else: ?>
                	<h2 class="search">Résultat de la recherche</h2>
                 <?php endif; ?>
			</header><!-- .page-header -->

        <div id="infinitescroll">
			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();
				get_template_part( 'template-parts/content', 'search' );
			endwhile;

			the_posts_navigation();
        
        echo '</div>';
            
            
		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</section><!-- #primary -->
    </div>
     <div class="col-12 col-md-4">
     Les champs de recherche sont interactifs et vous indiquent le nombre de réponses disponibles en fonction des réponses disponibles.
     <?php  
      echo do_shortcode('[searchandfilter id="526"]');
      get_sidebar();  ?>
    </div>
</div>
<?php
get_footer();
