<?php
/**
 * Template Name: Ressources des structures (EPTB, ANEB....)
 */

get_header();

                    if ( $post->post_parent ) {
                        // si enfant obtenir les parents
                        $anc = get_post_ancestors( $post->ID );
                        // remettre dans le bon ordre
                        $anc = array_reverse( $anc );
                        //on recherche le slug du niveau 0
                        $post = get_post( $anc[ 0 ] );
                        if ( !empty( $post ) )$rub_parente = $post->post_name;
                        //get_the_title($anc[0]);

                        // on part du slug de la page de niveau 0 ( la rubrique) on cherche le slug du terme "rubrique"s lui correspondant et on filtre la requete des actualités.
                        $rubriqueinfos = get_term_by( 'slug', "'" . $post->post_name . "'", 'rubriques' );

                       //EX: WP_Term Object ( [term_id] => 178 [name] => Les EPTB [slug] => les-eptb [term_group] => 0 [term_taxonomy_id] => 178 [taxonomy] => rubriques [description] => [parent] => 0 [count] => 0 [filter] => raw ) 
                    }

?>
  <div class="container">
	<section class="content-area">

			<?php
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content-ressources', 'headcontent' );

			endwhile; // End of the loop.
			?>

	</section><!-- #primary -->
<section id="primary" class="content-area">
<div class="row">
    
   <?php
    // 
      // get_last_ressources ('',3,true,'compact',$rubriqueinfos->term_id,false,'','','',false);
    
     get_archives_ressources(24,false,$rubriqueinfos->term_id,'', '','','','','','',false,'','','',false,'col-12 col-sm-6 col-md-4');

            
       ?>
    

</div>
</section>           
</div>
<?php
//get_sidebar();
get_footer(); ?>