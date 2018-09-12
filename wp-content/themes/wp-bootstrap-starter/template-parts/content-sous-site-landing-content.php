
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
    <?php } ?><div class="content-rubrique-home px-3">
<div class="row mb-5">

	<div class="entry-content col-12 col-md-8 ">
		<?php
			the_content();
		?>
    </div>
     <div class="col-12 col-md-4 sidebar-rubrique mr-0">
         <?php 
         dynamic_sidebar('sidebar-rubrique');
         ?>       
	</div>

</div>
</div>
</article><!-- #post-## -->
    
    
</div>




