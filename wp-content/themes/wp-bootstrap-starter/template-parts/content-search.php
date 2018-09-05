


<article id="post-<?php the_ID(); ?>" <?php post_class('dotted-bottom mb-3'); ?>>
	<header class="entry-header">
        
        <div class="row d-flex justify-content-between">
          <div class="col-7 col-md-8">
        <div class="type">
        <?php 
            $type= get_post_type( $post );
            if(!empty($type))
            echo '<span class="'.$type.'" >'.affiche_type_content($type);
             if ( 'post' === get_post_type() ): 
                 $categorie_actu= get_field('categorie_actu');      
                 if(!empty($categorie_actu)) echo '  <i class="far fa-angle-right"></i> <strong>'.$categorie_actu->name.'</strong> ';
            endif;
            echo '</span>';
            ?>
        </div>
        </div>
            <div class="col-5 col-md-4">
            <?php 
            if ( get_field( 'rubriques' ) ):
                  echo '<div class="mb-1 float-right">'.affiche_rubriques(get_field( 'rubriques' )).'</div>';
            endif;
            ?>
            </div>
                
        </div>
		<?php the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
     
        
		<?php 

        if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
            
			<?php 
              
            wp_bootstrap_starter_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->

	<footer class="entry-footer">
		<?php //wp_bootstrap_starter_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
