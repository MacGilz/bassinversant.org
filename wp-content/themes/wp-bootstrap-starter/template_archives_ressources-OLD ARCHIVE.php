<?php
/**
 * Template Name: Toutes les ressources
 */

if ( !session_id() )
    session_start();

//initialisation
if ( !isset( $_SESSION[ 'filtres-ressources' ] ) )$_SESSION[ 'filtres-ressources' ] = array( 'rubrique' => '', 'categorie' => '', 'description_geographique' => '', 'type_document' => '','genre_document' => '','editeur' => '','tag' => '', 'datepicker_year' => ''  );

// si soummission formulaire 
if ( isset( $_GET[ 'filtre' ] ) ) $_SESSION[ 'filtres-ressources' ] =
    array( 'rubrique' => $_GET[ 'rubrique' ], 'categorie' => $_GET[ 'categorie' ], 'description_geographique' => $_GET[ 'description_geographique' ],'type_document' => $_GET[ 'type_document' ],'genre_document' => $_GET[ 'genre_document' ],'editeur' => $_GET[ 'editeur' ], 'tag' => $_GET[ 'motcle' ], 'datepicker_year' => $_GET[ 'datepicker_year' ]);

// si on vient d'une page actu ( ex : epage), l'index d'epage est passé directement en GET il faut produire la session
if ( !isset( $_GET[ 'categorie' ] ) && isset( $_GET[ 'rubrique' ] ) ) {
    $_SESSION[ 'filtres-ressources' ][ 'rubrique' ] = $_GET[ 'rubrique' ];
}

// si les valeur session array nulles ET pas de init  on ferme l'accordeon ( si init) $_GET[ 'filtre' ]  est passée
$filtreactif = true;
$accordeon = true;
if ($_SESSION[ 'filtres-ressources' ][ 'rubrique' ] == '' && $_SESSION[ 'filtres-ressources' ][ 'categorie' ] == '' && $_SESSION[ 'filtres-ressources' ][ 'description_geographique' ] == '' && $_SESSION[ 'filtres-ressources' ][ 'type_document' ] == ''  && $_SESSION[ 'filtres-ressources' ][ 'genre_document' ] == '' && $_SESSION[ 'filtres-ressources' ][ 'editeur' ] == '' && $_SESSION[ 'filtres-ressources' ][ 'tag' ] == '' && $_SESSION[ 'filtres-ressources' ][ 'datepicker_year' ] == '' ) $filtreactif = false;

if(!isset( $_GET[ 'filtre' ] ) &&  $filtreactif == false)  $accordeon=false;
if(isset( $_GET[ 'filtre' ] ) &&  $filtreactif == false)  $accordeon=true;

##print_r($_SESSION[ 'filtres-ressources' ] );

// valeurs pour selects
$get_categories =  get_terms([
    'taxonomy' => 'categories_ressources',
    'hide_empty' => false,
]); 
$type_document= get_terms( array(
    'taxonomy' => 'type_document',
    'hide_empty' => false,
) );
$genre_de_document= get_terms( array(
    'taxonomy' => 'genre_de_document',
    'hide_empty' => false,
) );

$editeur= get_terms( array(
    'taxonomy' => 'editeur',
    'hide_empty' => false,
) );
 

get_header();



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
                <div class="col-12">
                    <form method="get" enctype="multipart/form-data" class=" pt-2 pb-1 px-4" id="facet-filter" title="facet-filter" accept-charset="UTF-8">

                        <div id="accordion">

                            <div class="card-header p-0 m-0 <?php if(!$accordeon) echo 'collapsed' ;?>" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                <a class="card-title">
                    <h5 class="mb-2"><i class="far fa-filter"></i> Filtrer les ressources <?php if($filtreactif ) echo ' <span class="filtreactif">[Actif]</span>' ;?></h5>
                </a>
                            
                            </div>


                            <div id="collapseOne" class="collapse <?php if($accordeon) echo 'show' ;?>" aria-labelledby="headingOne" data-parent="#accordion">
                                <div class="card-body">

                                    <div class="form-row">
                                        <div class="form-group col-6 col-md-2 mb-2">
                                            <label for="rubrique" class="w-100">Rubrique</label>
                                            <select name="rubrique" id="rubrique" class="form-control-sm custom-select">
                                                <option value="" <?php if(isset($_SESSION[ 'filtres-ressources'][ 'rubrique'] ) && $_SESSION[ 'filtres-ressources'][ 'rubrique']=='' ) print "selected"; ?>>Toutes</option>
                                                <option value="177" <?php if(isset($_SESSION[ 'filtres-ressources'][ 'rubrique']) && $_SESSION[ 'filtres-ressources'][ 'rubrique']=='177' ) print "selected"; ?>>ANEB</option>
                                                <option value="178" <?php if(isset($_SESSION[ 'filtres-ressources'][ 'rubrique'] ) && $_SESSION[ 'filtres-ressources'][ 'rubrique']=='178' ) print "selected"; ?>>Les EPTB</option>
                                                <option value="180" <?php if(isset($_SESSION[ 'filtres-ressources'][ 'rubrique'] ) && $_SESSION[ 'filtres-ressources'][ 'rubrique']=='180' ) print "selected"; ?>>EPAGE</option>
                                                <option value="179" <?php if(isset($_SESSION[ 'filtres-ressources'][ 'rubrique'] ) && $_SESSION[ 'filtres-ressources'][ 'rubrique']=='179' ) print "selected"; ?>>REZ'EAU</option>
                                            </select>
                                        </div>

                                        <div class="form-group  col-6 col-md-2 mb-2">
                                            <label for="categorie">Catégorie</label>
                                            <select name="categorie" id="categorie" class="form-control-sm custom-select">
                                                <option value="" <?php if(isset($_SESSION[ 'filtres-ressources'][ 'categorie'] ) && $_SESSION[ 'filtres-ressources'][ 'categorie']=='' ) print "selected"; ?>>Toutes</option>
                                                
                                                <?php foreach($get_categories as $k=>$v){
                                                echo '<option value="'.$v->term_id.'"';
                                                if(isset($_SESSION[ 'filtres-ressources'][ 'categorie']) && $_SESSION[ 'filtres-ressources'][ 'categorie']==$v->term_id ) print "selected";
                                                echo '>'.$v->name.'</option>';}?>                                               


                                            </select>
                                        </div>

                                        <div class="form-group  col-6 col-md-4 mb-2">
                                            <label for="description_geographique" class="">Description géographique</label>
                                            <select name='description_geographique' id='description_geographique' class='form-control-sm custom-select'>
                                                <?php

                                                $description_geographique = get_terms( [
                                                    'taxonomy' => 'description_geographique',
                                                    'hide_empty' => false,
                                                ] );
                                                ##print_r($description_geographique);

                                                $select = "<option value='' ";
                                                if ( isset( $_SESSION[ 'filtres-ressources' ][ 'description_geographique' ] ) && $_SESSION[ 'filtres-ressources' ][ 'description_geographique' ] == '' )$select .= "selected";
                                                $select .= " >Toutes</option>";

                                                foreach ( $description_geographique as $key => $value ) {

                                                    $select .= "<option value='" . $value->term_id . "'";
                                                    if ( isset( $_SESSION[ 'filtres-ressources' ][ 'description_geographique' ] ) && $_SESSION[ 'filtres-ressources' ][ 'description_geographique' ] == $value->term_id )$select .= " selected ";
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
                                                if ( isset( $_SESSION[ 'filtres-ressources' ][ 'tag' ] ) && $_SESSION[ 'filtres-ressources' ][ 'tag' ] == '' )$select .= "selected";
                                                $select .= " >Tous</option>";

                                                foreach ( $motcle as $key => $value ) {

                                                    $select .= "<option value='" . $value->slug . "'";
                                                    if ( isset( $_SESSION[ 'filtres-ressources' ][ 'tag' ] ) && $_SESSION[ 'filtres-ressources' ][ 'tag' ] == $value->slug )$select .= " selected ";
                                                    $select .= " >" . $value->name . "</option>";
                                                }

                                                echo $select;
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-row">
 <?php


                                        ?>
                                           <div class="form-group  col-6 col-md-4 mb-2">
                                            <label for="type_document" class="">Type de document</label>
                                            <select name='type_document' id='type_document' class='form-control-sm custom-select'>
                                               <?php


                                                $select = "<option value='' ";
                                                if ( isset( $_SESSION[ 'filtres-ressources' ][ 'type_document' ] ) && $_SESSION[ 'filtres-ressources' ][ 'type_document' ] == '' )$select .= "selected";
                                                $select .= " >Tous</option>";

                                                foreach ( $type_document as $key => $value ) {

                                                    $select .= "<option value='" . $value->term_id . "'";
                                                    if ( isset( $_SESSION[ 'filtres-ressources' ][ 'type_document' ] ) && $_SESSION[ 'filtres-ressources' ][ 'type_document' ] == $value->term_id )$select .= " selected ";
                                                    $select .= " >" . $value->name . "</option>";
                                                }

                                                echo $select;
                                                ?>
                                            </select>
                                        </div>
                                        
                                        <div class="form-group  col-6 col-md-4 mb-2">
                                            <label for="genre_document" class="">Genre de document</label>
                                            <select name='genre_document' id='genre_document' class='form-control-sm custom-select'>
                                               <?php


 
                                                $select = "<option value='' ";
                                                if ( isset( $_SESSION[ 'filtres-ressources' ][ 'genre_document' ] ) && $_SESSION[ 'filtres-ressources' ][ 'genre_document' ] == '' )$select .= "selected";
                                                $select .= " >Tous</option>";

                                                foreach ( $genre_de_document as $key => $value ) {

                                                    $select .= "<option value='" . $value->term_id . "'";
                                                    if ( isset( $_SESSION[ 'filtres-ressources' ][ 'genre_document' ] ) && $_SESSION[ 'filtres-ressources' ][ 'genre_document' ] == $value->term_id )$select .= " selected ";
                                                    $select .= " >" . $value->name . "</option>";
                                                }

                                                echo $select;
                                                ?>
                                            </select>
                                        </div>
                                        
                                        <div class="form-group  col-6 col-md-4 mb-2">
                                            <label for="editeur" class="">Editeur</label>
                                            <select name='editeur' id='editeur' class='form-control-sm custom-select'>
                                               <?php

                                                $select = "<option value='' ";
                                                if ( isset( $_SESSION[ 'filtres-ressources' ][ 'editeur' ] ) && $_SESSION[ 'filtres-ressources' ][ 'editeur' ] == '' )$select .= "selected";
                                                $select .= " >Tous</option>";

                                                foreach ( $editeur as $key => $value ) {

                                                    $select .= "<option value='" . $value->term_id . "'";
                                                    if ( isset( $_SESSION[ 'filtres-ressources' ][ 'editeur' ] ) && $_SESSION[ 'filtres-ressources' ][ 'editeur' ] == $value->term_id )$select .= " selected ";
                                                    $select .= " >" . $value->name . "</option>";
                                                }

                                                echo $select;
                                                ?>
                                            </select>
                                        </div>
                                        
                                        <div class="form-group  col-6 col-md-2 ">
                                            <label for="validationTooltipUsername">Année</label>
                                            <div class="input-group input-group-sm">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="datepicker_yearPrepend"><i class="fal fa-calendar-alt"></i></span>
                                                </div>
                                                <input type="text" class="form-control" name="datepicker_year" id="datepicker_year" value="<?php  if(isset($_SESSION['filtres-ressources']['datepicker_year'] )) echo $_SESSION['filtres-ressources']['datepicker_year'] ?>">
                                            </div>
                                        </div>


                                        <div class="form-group  col-6 col-md-2  offset-md-4  mt-4">
                                            <div class="col-auto">
                                                <button type="submit"   class="btn btn-filter btn-sm mb-0 hvr-sweep-to-right"><i class="far fa-check" ></i> Filtrer</button>
                                            </div>
                                            <input name='filtre' value="" type="hidden">
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
<div class="row ">

       <?php
   //  echo $_SESSION[ 'filtres-ressources' ][ 'editeur' ];
    // 
       get_archives_ressources ('',3,true,$_SESSION[ 'filtres-ressources' ][ 'rubrique' ],$_SESSION[ 'filtres-ressources' ][ 'categorie' ], $_SESSION[ 'filtres-ressources' ][ 'description_geographique' ],$_SESSION[ 'filtres-ressources' ][ 'tag' ] ,$_SESSION[ 'filtres-ressources' ][ 'type_document' ] ,$_SESSION[ 'filtres-ressources' ][ 'genre_document' ],$_SESSION[ 'filtres-ressources' ][ 'editeur' ],$_SESSION[ 'filtres-ressources' ][ 'datepicker_year' ],false,'','','',false);
            
       ?>
    

</div>
</section>           
</div>
<?php
//get_sidebar();
get_footer(); ?>