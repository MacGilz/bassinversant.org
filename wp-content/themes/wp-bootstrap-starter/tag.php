<?php
/**
 * Template Name: Actualités
 */


get_header();

?>



<!-- Modal -->
<div class="modal fade" id="modalmotscles" tabindex="-1" role="dialog" aria-labelledby="modalmotsclesTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalmotsclesTitle">Tous les mots Clés</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php the_widget( "WP_Widget_Tag_Cloud", '','' ); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>
<div class="container">

<article>
    <header class="entry-header">
        <div class="row">
            <div class="col-8 col-md-10">
        <span class="vaguepost"><img src="/wp-content/themes/imgs/vague.svg" /></span>
        <h2 class="mb-0" >Tous les contenus étiquetés</h2>
		<h1 class="entry-title"><?php echo get_query_var('tag') ?></h1> 
        </div>
  <div class="col-4 col-md-2">
        <button type="button" class="btn-mots-cles float-right  " data-toggle="modal" data-target="#modalmotscles">
  <i class="fas fa-tags"></i><br> Tous les mots clés
</button>        </div>
            </div>
	</header>
</article>
    <section id="primary" class="content-area">
        <main id="main" class="site-main" role="main">

                    

<div class="row">

  <div class="col-12 col-sm-6">
      <div class="row" id="liste-actualites">
        <div class="col-12">
        <h2>Actualités</h2>
          </div>
        <div class="col-12">
      <?php echo do_shortcode('
[ajax_load_more  id="tag_actus" posts_per_page="12" container_type="div" post_type="post" tag="'.get_query_var('tag').'" button_label="Voir les plus anciens" button_loading_label="Chargement" scroll="false"]
'); ?>
          </div>
      </div>
  </div>
    
      <div class="col-12 col-sm-6">
      <div class="row" id="liste-ressources">
        <div class="col-12">
        <h2>Ressources</h2>
          </div>
        <div class="col-12">
      <?php echo do_shortcode('
[ajax_load_more  id="tag_actus"  posts_per_page="12" container_type="div" post_type="ressource" tag="'.get_query_var('tag').'" button_label="Voir les plus anciens" button_loading_label="Chargement" scroll="false"]
'); ?>




          </div>
      </div>
  </div>
    <?php

   // echo get_tag_posts(array('ressource','post'),'',2,'','compact','','','','','', get_query_var('tag'),'col-12 col-md-6', true);
    
    ?>



</div>


    <!-- .row -->
</div> <!-- .container -->

<?php

get_footer();?>
  