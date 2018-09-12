
    <div class="row">
        <div class="col-12"><a href="/membres/" >Tous les membres</a></div>
    </div>

<div class="row">
<article id="post-<?php the_ID(); ?>" <?php post_class('col-12'); ?>>

    <header class="entry-header">
        <span class="vaguepost"><img src="/wp-content/themes/imgs/vague.svg" /></span>
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?> 
	</header>


    <?php if(!empty(the_content())): ?>
	<div class="entry-content">
		<?php
			the_content();

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'wp-bootstrap-starter' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->
    <?php endif ?>


</article><!-- #post-## -->
    
<?php /*?><aside id="secondary" class="widget-area col-12 col-md-3" role="complementary" >
            <?php get_sidebar(); ?>
</aside><?php */?>
    
</div>




