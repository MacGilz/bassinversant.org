

<div class="row">

<article id="post-<?php the_ID(); ?>" <?php post_class('col-12 mb-5'); ?>>

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


</article>
    <div class="col-12 pr-md-5">
    <?php echo do_shortcode('[MWB_PDF_GEN]'); ?>
    </div>
</div>




