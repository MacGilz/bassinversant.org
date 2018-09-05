<?php
/**
 * Template Name: Actualités Archives
 */


if ( !session_id() )
    session_start();

//initialisation
if ( !isset( $_SESSION[ 'filtres-actualites' ] ) )$_SESSION[ 'filtres-actualites' ] = array( 'rubrique' => '', 'categorie' => '', 'thematique' => '', 'tag' => '', 'datepicker_in' => '', 'datepicker_out' => '' );

// si soummission formulaire 
if ( isset( $_GET[ 'filtre' ] ) )$_SESSION[ 'filtres-actualites' ] =
    array( 'rubrique' => $_GET[ 'rubrique' ], 'categorie' => $_GET[ 'categorie' ], 'thematique' => $_GET[ 'thematique' ], 'tag' => $_GET[ 'motcle' ], 'datepicker_in' => $_GET[ 'datepicker_in' ], 'datepicker_out' => $_GET[ 'datepicker_out' ] );

// si on vient d'une page actu ( ex : epage), l'index d'epage est passé directement en GET il faut produire la session
if ( !isset( $_GET[ 'categorie' ] ) && isset( $_GET[ 'rubrique' ] ) ) {
    $_SESSION[ 'filtres-actualites' ][ 'rubrique' ] = $_GET[ 'rubrique' ];
}

// si les valeur session array nulles on ferme l'accordeon
// si les valeur session array nulles ET pas de init  on ferme l'accordeon ( si init) $_GET[ 'filtre' ]  est passée
$filtreactif = true;
$accordeon = true;
if ( $_SESSION[ 'filtres-actualites' ][ 'rubrique' ] == '' && $_SESSION[ 'filtres-actualites' ][ 'categorie' ] == '' && $_SESSION[ 'filtres-actualites' ][ 'thematique' ] == '' && $_SESSION[ 'filtres-actualites' ][ 'tag' ] == '' && $_SESSION[ 'filtres-actualites' ][ 'datepicker_in' ] == '' && $_SESSION[ 'filtres-actualites' ][ 'datepicker_out' ] == '' ) $filtreactif = false;

if(!isset( $_GET[ 'filtre' ] ) &&  $filtreactif == false)  $accordeon=false;
if(isset( $_GET[ 'filtre' ] ) &&  $filtreactif == false)  $accordeon=true;


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
            //           // recup infos rubrique parent ( ex:  ANEB , EPTB    )
            //            if ( $post->post_parent ) {
            //                // si enfant obtenir les parents
            //                $anc = get_post_ancestors( $post->ID );
            //                // remettre dans le bon ordre
            //                $anc = array_reverse( $anc );
            //                //on recherche le slug du niveau 0
            //                $post = get_post( $anc[ 0 ] );
            //                if ( !empty( $post ) )$rub_parente = $post->post_name;
            //                //get_the_title($anc[0]);
            //
            //                // on part du slug de la page de niveau 0 ( la rubrique) on cherche le slug du terme "rubrique" lui correspondant et on filtre la requete des actualités.
            //                $rubriqueinfos = get_term_by( 'slug', "'" . $post->post_name . "'", 'rubriques' );
            //
            //            }

            // recup infos filtre ( passé dans le GET, par defaukt ANEB id 177
            if ( isset( $_GET[ 'rubrique' ] ) && !empty( $_GET[ 'rubrique' ] ) ) {
                $rubriquefiltreinfos = get_term_by( 'id', $_GET[ 'rubrique' ], 'rubriques' );
            } else {
                $rubriquefiltreinfos = get_term_by( 'id', 177, 'rubriques' );
            }



            ?>

            <div class="row">
                <?php the_post();?>
                <article id="post-<?php the_ID(); ?>" <?php post_class( 'col-12'); ?>>
                    <?php
                    $enable_vc = get_post_meta( get_the_ID(), '_wpb_vc_js_status', true );
                    if ( !$enable_vc ) {
                        ?>
                    <header class="entry-header">
                        <div class="row">
                            <div class="col-12 col-sm-9">
                                <span class="vaguepost"><img src="/wp-content/themes/imgs/vague.svg" /></span>
                                <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

                            </div>

                            <?php 
                        
                            ?>
                            <div class="col-12 col-sm-3 d-flex flex-column">
                                <a href="<?php echo $rubriqueinfos->slug ?>/actualites/" class="button-archives-actus hvr-sweep-to-right mt-auto align-self-end" title="Actualités <?php echo $rubriquefiltreinfos->name ?>"><i class="fas fa-clock"></i> Dernières actualités <?php echo $rubriquefiltreinfos->name ?></a>
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
                            'after' => '</div>',
                        ) );
                        ?>
                    </div>
                    <!-- .entry-content -->
                    <?php endif ?>


                </article>
                <!-- #post-## -->

            </div>

            <div class="row">
                <div class="col-12">
                    <form enctype="multipart/form-data" id="facet-filter" class=" pt-2 pb-2 px-4" title="facet-filter" accept-charset="UTF-8">

                        <div id="accordion">

                            <div class="card-header p-0 m-0 <?php if(!$accordeon) echo 'collapsed' ;?>" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                <a class="card-title">
                    <h5 class="mb-0"><i class="far fa-filter"></i> Filtrer les actualités <?php if($filtreactif) echo ' <span class="filtreactif">[Actif]</span>' ;?></h5>
                </a>
                            
                            </div>


                            <div id="collapseOne" class="collapse <?php if(!$accordeon) echo 'show' ;?>" aria-labelledby="headingOne" data-parent="#accordion">
                                <div class="card-body">

                                    <div class="form-row">
                                        <div class="form-group col-6 col-md-2 mb-2">
                                            <label for="rubrique" class="w-100">Rubrique</label>
                                            <select name="rubrique" id="rubrique" class="form-control-sm custom-select">
                                                <option value="" <?php if(isset($_SESSION[ 'filtres-actualites'][ 'rubrique'] ) && $_SESSION[ 'filtres-actualites'][ 'rubrique']=='' ) print "selected"; ?>>Toutes</option>
                                                <option value="177" <?php if(isset($_SESSION[ 'filtres-actualites'][ 'rubrique']) && $_SESSION[ 'filtres-actualites'][ 'rubrique']=='177' ) print "selected"; ?>>ANEB</option>
                                                <option value="178" <?php if(isset($_SESSION[ 'filtres-actualites'][ 'rubrique'] ) && $_SESSION[ 'filtres-actualites'][ 'rubrique']=='178' ) print "selected"; ?>>Les EPTB</option>
                                                <option value="180" <?php if(isset($_SESSION[ 'filtres-actualites'][ 'rubrique'] ) && $_SESSION[ 'filtres-actualites'][ 'rubrique']=='180' ) print "selected"; ?>>EPAGE</option>
                                                <option value="179" <?php if(isset($_SESSION[ 'filtres-actualites'][ 'rubrique'] ) && $_SESSION[ 'filtres-actualites'][ 'rubrique']=='179' ) print "selected"; ?>>REZ'EAU</option>
                                            </select>
                                        </div>

                                        <div class="form-group  col-6 col-md-2 mb-2">
                                            <label for="categorie">Catégorie</label>
                                            <select name="categorie" id="categorie" class="form-control-sm custom-select">
                                                <option value="" <?php if(isset($_SESSION[ 'filtres-actualites'][ 'categorie'] ) && $_SESSION[ 'filtres-actualites'][ 'categorie']=='' ) print "selected"; ?>>Toutes</option>
                                                <option value="3929" <?php if(isset($_SESSION[ 'filtres-actualites'][ 'categorie']) && $_SESSION[ 'filtres-actualites'][ 'categorie']=='3929' ) print "selected"; ?>>Réseau</option>
                                                <option value="3930" <?php if(isset($_SESSION[ 'filtres-actualites'][ 'categorie'] ) && $_SESSION[ 'filtres-actualites'][ 'categorie']=='3930' ) print "selected"; ?>>Au fil de l’eau</option>
                                            </select>
                                        </div>

                                        <div class="form-group  col-6 col-md-4 mb-2">
                                            <label for="thematique" class="">Thématique</label>
                                            <select name='thematique' id='thematique' class='form-control-sm custom-select'>
                                                <?php

                                                $thematiques = get_terms( [
                                                    'taxonomy' => 'thematiques',
                                                    'hide_empty' => false,
                                                ] );

                                                $select = "<option value='' ";
                                                if ( isset( $_SESSION[ 'filtres-actualites' ][ 'thematique' ] ) && $_SESSION[ 'filtres-actualites' ][ 'thematique' ] == '' )$select .= "selected";
                                                $select .= " >Toutes</option>";

                                                foreach ( $thematiques as $key => $value ) {

                                                    $select .= "<option value='" . $value->term_id . "'";
                                                    if ( isset( $_SESSION[ 'filtres-actualites' ][ 'thematique' ] ) && $_SESSION[ 'filtres-actualites' ][ 'thematique' ] == $value->term_id )$select .= " selected ";
                                                    $select .= " >" . $value->name . "</option>";
                                                }

                                                echo $select;
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group  col-6 col-md-3 mb-2">
                                            <label for="motcle" class="">Mot clé</label>
                                            <select name='motcle' id='motcle' class='form-control-sm custom-select'>
                                                <?php


                                                $motcle = get_terms( array(
                                                    'taxonomy' => 'post_tag',
                                                    'hide_empty' => false,
                                                ) );

                                                $select = "<option value='' ";
                                                if ( isset( $_SESSION[ 'filtres-actualites' ][ 'tag' ] ) && $_SESSION[ 'filtres-actualites' ][ 'tag' ] == '' )$select .= "selected";
                                                $select .= " >Tous</option>";

                                                foreach ( $motcle as $key => $value ) {

                                                    $select .= "<option value='" . $value->slug . "'";
                                                    if ( isset( $_SESSION[ 'filtres-actualites' ][ 'tag' ] ) && $_SESSION[ 'filtres-actualites' ][ 'tag' ] == $value->slug )$select .= " selected ";
                                                    $select .= " >" . $value->name . "</option>";
                                                }

                                                echo $select;
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-row">

                                        <div class="form-group  col-6 col-md-2 ">
                                            <label for="validationTooltipUsername">De (mois/année)</label>
                                            <div class="input-group input-group-sm">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="datepicker_inPrepend"><i class="fal fa-calendar-alt"></i></span>
                                                </div>
                                                <input type="text" class="form-control" name="datepicker_in" id="datepicker_in" value="<?php  if(isset($_SESSION['filtres-actualites']['datepicker_in'] )) echo $_SESSION['filtres-actualites']['datepicker_in'] ?>">
                                            </div>
                                        </div>

                                        <div class="form-group  col-6 col-md-2 ">
                                            <label for="validationTooltipUsername">À (mois/année)</label>
                                            <div class="input-group input-group-sm">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="datepicker_outPrepend"><i class="fal fa-calendar-alt"></i></span>
                                                </div>
                                                <input type="text" class="form-control" name="datepicker_out" id="datepicker_out" value="<?php if(isset($_SESSION['filtres-actualites']['datepicker_out'] ))  echo $_SESSION['filtres-actualites']['datepicker_out'] ?>">
                                            </div>
                                        </div>

                                        <div class="form-group  col-6 col-md-2  offset-md-4  mt-4">
                                            <div class="col-auto">
                                                <button type="submit" class="btn btn-filter btn-sm mb-0 hvr-sweep-to-right" ><i class="far fa-check"></i> Filtrer</button>
                                                <input name='filtre' value="" type="hidden">
                                            </div>
                                        </div>
                                        <div class="form-group  col-6 col-md-2  mt-4">
                                            <div class="col-auto">
                                                <button type="button" value="init-filter" id="init-filter" class="btn btn-sm btn-initfilter mb-0 hvr-sweep-to-right"><i class="far fa-ban"></i> Initialiser</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>




                </div>
            </div>

            <div class="row">
                <div class="col-12">

                    <div class="row" id="liste-actualites">

                        <?php

                        get_post_actualites( $_SESSION[ 'filtres-actualites' ][ 'categorie' ], false, 0, 'true', 'archives', $_SESSION[ 'filtres-actualites' ][ 'rubrique' ], 150, 150, 'float-left mr-4', false, $_SESSION[ 'filtres-actualites' ][ 'datepicker_in' ], $_SESSION[ 'filtres-actualites' ][ 'datepicker_out' ], $_SESSION[ 'filtres-actualites' ][ 'thematique' ], $_SESSION[ 'filtres-actualites' ][ 'tag' ] );
                        ?>




                    </div>
                </div>

                <?php
                // get_sidebar();
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