

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

		?>
	</div><!-- .entry-content -->
    <?php endif ?>


</article><!-- #post-## -->
    
<?php /*?><aside id="secondary" class="widget-area col-12 col-md-3" role="complementary" >
            <?php get_sidebar(); ?>
</aside><?php */?>
    
</div>




