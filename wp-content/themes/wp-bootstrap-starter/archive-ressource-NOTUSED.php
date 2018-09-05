<?php
/**
 * ARCHIVES RESSOURCES
 */

get_header(); 
  
?>
<div class="container" id="archives-ressources">
<div class="row">
<?php
//foreach ( (array) $menu_items as $key => $menu_item ) {
//    if ( $menu_item->menu_item_parent == 0 ) :
//        $title = $menu_item->title;
//        $url = $menu_item->url;
//        $menu_output .= '<option value="' . $url . '">' . $prefix . $title . '</option>';
//    endif;
//}

echo the_breadcrumb();

?>

	<section id="primary" class="content-area col-12">
		<main id="main" class="site-main" role="main">

		<?php
		if ( have_posts() ) : ?>

			<header class="page-header">
                <span class="vaguepost"><img src="/wp-content/themes/imgs/vague.svg" /></span>
                	<h1 class="page-title">Ressources</h1>
				<?php
				
					the_archive_description( '<div class="archive-description">', '</div>' );
				?>
			</header><!-- .page-header -->

            <div class="row">
			<?php
            
            
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content', 'ressources' );

			endwhile;

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

            </div>    
                
		</main><!-- #main -->
	</section><!-- #primary -->
			</div><!-- .row -->
		</div><!-- .container -->

<?php
//get_sidebar();
get_footer();
