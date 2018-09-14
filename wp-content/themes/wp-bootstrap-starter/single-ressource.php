<?php
/**
 * TEMPLATE RESSOURCE
 */

get_header();
?>

<div class="container">

    <div class="row">
        <div class="col-12">
            <?php  echo the_breadcrumb(); ?>
        </div>
    </div>

    <div class="row">
        <section id="primary" class="content-area col-12">
            <main id="main" class="site-main" role="main">

                <?php
                the_post();

                get_template_part( 'template-parts/content-ressource', get_post_format() );

                ?>

                <div class="row my-5">
                    <div class="col-12">
                        <?php echo do_shortcode('[MWB_PDF_GEN]'); ?>
                    </div>
                </div>

                <?php
                the_post_navigation();
                ?>

                
            </main>
            <!-- #main -->
        </section>
        <!-- #primary -->
        <?php
        //get_sidebar();
        ?>
    </div>
    <!-- .row -->


</div> <!-- .container -->
<?php

get_footer();