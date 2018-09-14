
<div class="row">

<article id="post-<?php the_ID(); ?>" <?php post_class('col-12'); ?>>


    <div class="content-rubrique-home px-3">
<div class="row mb-5">

	<div class="entry-content col-12 ">
		<?php
			the_content();
		?>
    </div>
     <div class="col-12 sidebar-rubrique mr-0">
         <?php 
         dynamic_sidebar('sidebar-rubrique');
         ?>       
	</div>

</div>
</div>
</article><!-- #post-## -->
    
</div>




