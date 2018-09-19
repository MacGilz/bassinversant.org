<?php
/**
 * Template Name: Landing Page Sous-site
 */

get_header();

$rubriques = get_field( 'rubriques' );

?>

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
            <div class="col-12 col-md-8">
                <div class="row">
                    <div class="col-12">
                        <div id="caroussel-actus" class="carousel slide py-3  px-2 mb-4" data-ride="carousel">
                            <?php  echo  get_actus_carrousel(true, 3, $rubriques[ 0 ]->term_id, 180, 180 );?>
                        </div>
                    </div>
                </div>
            

            <div class="row">
                <div class="col-12 col-md-6 pt-2" id="liste-actualites">

                    <h2>Dernières Actualités</h2>

                    <div class="row">
                        <?php

                        if ( $rubriques[ 0 ]->slug == "aneb" ) {
                            //Actualités epinglées de toutes les rubriques
                            get_post_actualites( '', false, '', false, 'portrait', $rubriques[ 0 ]->term_id, 180, 100, 'float-left pr-4 mb-5', true );
                        } else {
                            get_post_actualites( '', false, '', false, 'portrait', $rubriques[ 0 ]->term_id, 180, 100, 'float-left pr-4 mb-5', false );
                        }

                        ?>
                    <div class="col-12 text-right"> 
                        
                    <a href="<?php echo get_field('url_page_actus_'.$rubriques[ 0 ]->slug, 'option') ?>" class="hvr-sweep-to-right button-primary mt-3">Toutes les actualités <i class="fal fa-angle-right" ></i> </a>
                </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div id="liste-ressources" class="px-xs-4 px-sm-4 px-md-4 pt-2">

                        <h2>Dernières Ressources</h2>

                        <div class="row">

              <?php
              echo get_last_ressources('',10,true,'liste-home-sous-site',$rubriques[0]->term_id,false,false,25);
              ?>

                <div class="col-12 text-right pb-3">
                    <a href="<?php echo get_field('url_page_ressources_'.$rubriques[ 0 ]->slug, 'option') ?>" class="hvr-sweep-to-right button-primary mt-3">Toutes les ressources <i class="fal fa-angle-right" ></i> </a>
                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
</div>

<?php
//get_sidebar();
get_footer();
?>