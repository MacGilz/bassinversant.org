<?php
/**
 * CONTENT RESSOURCE
 
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<?php

			the_title( '  <span class="vaguepost"><img src="/wp-content/themes/imgs/vague.svg" /></span><h1 class="entry-title">', '</h1>' );
        ?>
		<div class="entry-meta">
			<?php 
            
            if ( get_field( 'rubriques' ) ):
                  echo '<div class="mb-1">'.affiche_rubriques(get_field( 'rubriques' )).'</div>';
            endif;
            
             echo '<div>';
            wp_bootstrap_starter_posted_on();
            echo '</div>';
  
            echo affiche_taxonomie_links($post->ID,array('thematiques'),'thematiques','Dans : ')  ;  ?>
       
		</div><!-- .entry-meta -->
        
        


     
	</header><!-- .entry-header -->
    <div class="row">
         <div class="col-12 col-sm-8 col-md-8">
             
	<div class="entry-content mb-5">
        <div class="row">
        <div class="col-12">
    
    <?php if (has_post_thumbnail( $post->ID ) ):
            
         $featured_img_url = get_the_post_thumbnail_url(get_the_ID(),'full'); 
            
            ?>
    <div class="post-thumbnail float-left">
        <a href="<?php echo $featured_img_url?>">
		<?php the_post_thumbnail(array(380,380),['class' => 'img-fluid img-thumbnail mr-xs-0 mr-sm-0 mr-md-4']);
        ?>
        <p class="clearfloat text-center mt-2"> <?php the_title_attribute(); ?></p>
        </a>
	</div>
    <?php endif; ?>
            
		<?php
			the_content();
		?>       
        <div>   
            <p class="tags">
                <?php echo affiche_taxonomie_links(get_the_ID(),array('post_tag'),'tags','');?>
            </p>
        </div> 
        </div>
            

         
          


            
            
        </div>
	</div><!-- .entry-content -->
                    <div class="row">
            <div class="col-12">
                
   <footer class="entry-footer">
        <hr />
        <?php wp_bootstrap_starter_entry_footer(); ?>
    </footer>
            </div>
        </div>
</div>
 <?php      $picto='';
        
            if(!empty( get_field('fichier_local'))) {
                $urlfile=  get_field('fichier_local'); // ATTENTION > array
                $picto='<i class="fas fa-file-download mr-2"></i>';
                $url=$urlfile['url'];
                $target='';
               // print_r($urlfile);
            }
            if(!empty( get_field('lien_ressources'))){
                $urlfile=  get_field('lien_ressources'); // valeur url
                $picto='<i class="far fa-external-link"></i>';
                $url=$urlfile;
                $target=' target="_blank" ';
               //print_r($urlfile);
            }
        
            ?>
        
        
 <?php if(isset($urlfile)): ?>       
  <aside id="secondary" class="sidebar-right widget-area  col-12 col-sm-4 col-md-4" role="complementary" >
<div class="fichiers-joints mt-4">
          <h3 class="mt-0"><?php echo $picto ?> Ressource </h3>
            
            <ul class="items px-3"> 
                
          <li> <a href="<?php echo  $url ?>"  title="<?php echo  get_field('titre_du_lien_de_telechargement') ?>" <?php echo $target ?>> <?php echo  get_field('titre_du_lien_de_telechargement') ?></a></li>
            </ul>
    </div>
<?php endif; ?>
<?php get_sidebar(); ?>
</aside>
</div>
</article><!-- #post-## -->

           