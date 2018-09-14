<?php
/**
 * Template Name: Landing Page Sous-site
 */

get_header(); ?>

<div class="container">
	
<section id="primary" class="content-area">
    
<div class="row">
<div class="col-12">   
    <header class="entry-header">
        <span class="vaguepost"><img src="/wp-content/themes/imgs/vague.svg" /></span>
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?> 
	</header>
 </div>
</div>
<div class="row">
<div class="col-12 col-md-4 pl-md-0">
    <section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
           <?php

			the_post();
			get_template_part( 'template-parts/content', 'sous-site-landing-content' );
?>

		</main>
	</section>
    
</div>
<div class="col-12 col-md-4 pt-2" id="liste-actualites">

    <h2>Dernières Actualités</h2>
        
<div class="row">     
<?php
      $rubriques= get_field('rubriques');

      if($rubriques[0]->slug=="aneb") {
            //Actualités epinglées de toutes les rubriques
            get_post_actualites ('',true,3,false,'portrait',$rubriques[0]->term_id,180,100, 'float-left pr-4 mb-5',true );
      }
    else {
           get_post_actualites ('',true,3,false,'portrait',$rubriques[0]->term_id,180,100, 'float-left pr-4 mb-5',false );
    }
            
            ?>
    
</div>
</div>
<div class="col-12 col-md-4" >
<div id="liste-ressources" class="px-xs-4 px-sm-4 px-md-4 pt-2" >
    
    <h2>Dernières Ressources</h2>
    
    <div class="row">
    
              <?php 
              echo get_last_ressources('',10,true,'liste-home-sous-site',$rubriques[0]->term_id,false,false,25);
              ?>
    
        </div>
</div>
</div>
</section>  
</div>

<?php
//get_sidebar();
get_footer(); ?>