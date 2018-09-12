<?php
/**
 * Template Name: Landing Page Sous-site
 */

get_header(); ?>

<div class="container">
	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
           <?php
// vars	
$rubriques= get_field('rubriques');

##print_r($rubriques);
   
			the_post();

				get_template_part( 'template-parts/content', 'sous-site-landing-content' );

?>

		</main><!-- #main -->
	</section><!-- #primary -->



<section id="primary" class="content-area">
<div class="row">

<div class="col-12 col-md-6" id="liste-actualites">

    <h2>Dernières Actualités</h2>
        
<div class="row">     
<?php
           // paramètres ( slug catégorie; sticky:bool,nombre de posts; pagination:bool; format;Rubrique ACF - si nul tous;thumb w, thumb height, thumbbox class; showcategories:bool;date_in;date_out;$tagslugs:xx,xx; )

      
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
<div class="col-12 col-md-6  " >
<div id="liste-ressources" class="px-xs-4 px-sm-4 px-md-5" >
    
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