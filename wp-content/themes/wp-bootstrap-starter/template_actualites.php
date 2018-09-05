<?php
/**
 * Template Name: Actualités
 */

error_reporting( E_ALL );
ini_set( 'display_errors', 1 );


get_header();



?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <?php echo the_breadcrumb();?>
        </div>
    </div>

    <section id="primary" class="content-area">
        <main id="main" class="site-main" role="main">

                    <?php

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

                    }



            ?>


<div class="row">


<article id="post-<?php the_ID(); ?>" <?php post_class('col-12'); ?>>
	<?php
    $enable_vc = get_post_meta(get_the_ID(), '_wpb_vc_js_status', true);
    if(!$enable_vc ) {
    ?>
    <header class="entry-header">
        <div class="row">
        <div class="col-12 col-sm-9">
        <span class="vaguepost"><img src="/wp-content/themes/imgs/vague.svg" /></span>
		<?php the_title( '<h1 class="entry-title">Actualités ', '</h1>' ); ?>
        </div>
        <div class="col-12 col-sm-3 d-flex flex-column">
            <a href="/archives-des-actualites/?rubrique=<?php echo $rubriqueinfos->term_taxonomy_id ?>" class="button-archives-actus hvr-sweep-to-right mt-auto align-self-end" title="archives des actualités <?php echo $rubriqueinfos->name ?>" ><i class="fas fa-archive"></i> Archives des actualités</a>
        </div>
        </div>
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


            <div class="row">
                <div class="col-12 col-md-12 ">

                    <div class="row" id="liste-actualites">

                        <div class="col-12 col-sm-6">
                            <h2>Réseau</h2>
                            <div class="row">
                            <?php
                            get_post_actualites( 3929, false, 0, 'true', 'portrait', $rubriqueinfos->term_id, 150, 150, 'float-left mr-4' );
                            ?>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6">
                            <h2>Au Fil de L'eau</h2>
                             <div class="row">
                            <?php
                            get_post_actualites( 3930, false, 0, 'true', 'portrait', $rubriqueinfos->term_id, 150, 150, 'float-left mr-4' );

                            ?>
                             </div>
                        </div>

                    </div>
                </div>

                <?php
             //   get_sidebar();
                ?>
        </main>
        <!-- #main -->

    </section>
    <!-- #primary -->


    </div>
    <!-- .row -->
</div> <!-- .container -->
<?php

get_footer();
?>