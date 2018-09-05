<?php

/*
contenus du header des pages ressources ( titre, texte intro...)
*/
     
?>


<div class="row">

    
<article id="post-<?php the_ID(); ?>" <?php post_class('col-12'); ?>>
	<?php
    $enable_vc = get_post_meta(get_the_ID(), '_wpb_vc_js_status', true);
    if(!$enable_vc ) {
    ?>
    <header class="entry-header">
        <span class="vaguepost"><img src="/wp-content/themes/imgs/vague.svg" /></span>
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?> 
	</header>
    <?php } ?>

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
    

</div>




