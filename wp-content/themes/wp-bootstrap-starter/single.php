<?php

get_header();
?>
<div class="container">
    <div class="row">
        <section id="primary" class="content-area col-12">
            <main id="main" class="site-main" role="main">

                <?php
                while ( have_posts() ): the_post();

                $categorie_actu = get_field( 'categorie_actu' );


                switch ( $categorie_actu->slug ) {
                    case 'reseau':
                        $templatecontent = 'actualite';
                        break;
                    case 'au-fil-de-leau':
                        $templatecontent = 'actualite';
                        break;
                    default:
                        $templatecontent = 'content';
                        break;
                }

                get_template_part( 'template-parts/content', $templatecontent );
                ?>
              
                <div class="row my-5">
                    <div class="col-12">
                    <?php echo do_shortcode('[MWB_PDF_GEN]'); ?>
                    </div>
                </div>
                
                <div class="my-5">
                    <?php
                    the_post_navigation();
                    ?>
                </div>
                <?php
                endwhile; // End of the loop.
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