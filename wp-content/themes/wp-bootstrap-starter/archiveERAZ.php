<?php
/**
 * The template for displaying archive pages
 */

get_header(); 



    
?>
<div class="container">
<div class="row">
<?php
foreach ( (array) $menu_items as $key => $menu_item ) {
    if ( $menu_item->menu_item_parent == 0 ) :
        $title = $menu_item->title;
        $url = $menu_item->url;
        $menu_output .= '<option value="' . $url . '">' . $prefix . $title . '</option>';
    endif;
}

echo the_breadcrumb();

?>

	<section id="primary" class="content-area col-12">
		<main id="main" class="site-main" role="main">

		<?php
		if ( have_posts() ) : ?>

			<header class="page-header">
				<?php
					the_archive_title( '<h1 class="page-title">', '</h1>' );
					the_archive_description( '<div class="archive-description">', '</div>' );
				?>
			</header><!-- .page-header -->

			<?php
            
            
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', get_post_format() );

			endwhile;

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</section><!-- #primary -->
			</div><!-- .row -->
		</div><!-- .container -->

<?php
//get_sidebar();
get_footer();
