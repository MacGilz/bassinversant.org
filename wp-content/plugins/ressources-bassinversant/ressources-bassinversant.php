<?php

/*
Plugin Name: Ressources Bassinversant

Description: Format de Post dédiés aà la base de ressources du site Bassinversant.org
Version: 1.0
Copyright 2018 Gilles Coutin info@kingbeestudio.com
Author: Gilles coutin
Author URI: http:kingbeestudio.com

*/



function create_post_ressources() {

    // set up labels
	$labels = array(
 		'name' => 'Ressources',
    	'singular_name' => 'Ressource',
    	'add_new' => 'Ajouter une ressource',
    	'add_new_item' => 'Ajouter une ressource',
    	'edit_item' => 'Modifier la ressource',
    	'new_item' => 'Nouvelle ressource',
    	'all_items' => 'Toutes les ressources',
    	'view_item' => 'Voir la ressource',
    	'search_items' => 'Rechercher une ressource',
    	'not_found' =>  'Aucune ressource trouvée',
    	'not_found_in_trash' => 'Aucune ressource trouvée dans la poubelle', 
    	'parent_item_colon' => '',
    	'menu_name' => 'Ressources',

    );
    
    
    //register post type
	register_post_type( 'ressource', array(
		'labels' => $labels,
		'has_archive' => true,
 		'public' => true,
		'supports' => array( 'title', 'editor', 'thumbnail' ),
        'menu_position' => 5,
        'menu_icon' => 'dashicons-portfolio',
		'taxonomies' => array( 'categories_ressources','post_tag' ),	
		'exclude_from_search' => false,
		'capability_type' => 'post',
		'rewrite' => array( 'slug' => 'ressources' ),

		)
	);
}

add_action( 'init', 'create_post_ressources' );


function ressources_register_taxonomies() {
	
		$taxonomies = array(
/*            array(
				'slug'         => 'categories_ressources',
				'single_name'  => 'Catégorie',
				'plural_name'  => 'Catégories',
				'post_type'    => 'ressource',
				//'rewrite'      => array( 'slug' => 'department' ),
                'new'          => 'Nouvelle',
                'hierarchical' => false,
                'menu_name'    => 'Catégorie ressource',
			),
            */
            array(
				'slug'         => 'mots_cles',
				'single_name'  => 'Mot clé',
				'plural_name'  => 'Mots clés',
				'post_type'    => 'type',
                'new'          => 'Nouveau',
                'hierarchical' => false,
                'menu_name'    => 'Mots clés',
			),
            
            array(
				'slug'         => 'type_document',
				'single_name'  => 'Type document',
				'plural_name'  => 'Types de document',
				'post_type'    => 'type',
				//'rewrite'      => array( 'slug' => 'department' ),
                'new'          => 'Nouveau',
                'hierarchical' => false,
                'menu_name'    => 'Type de doc.',
			),
            
            array(
				'slug'         => 'genre_de_document',
				'single_name'  => 'Genre de document',
				'plural_name'  => 'Genres de document',
				'post_type'    => 'ressource',
				//'rewrite'      => array( 'slug' => 'department' ),
                'new'          => 'Nouveau',
                'hierarchical' => false,
                'menu_name'    => 'Genre de doc.',
			),
            
            array(
				'slug'         => 'langues',
				'single_name'  => 'Langue',
				'plural_name'  => 'Langues',
				'post_type'    => 'ressource',
				//'rewrite'      => array( 'slug' => 'department' ),
                'new'          => 'Nouvelle',
                'hierarchical' => false,
                'menu_name'    => 'Langues',
			),
            
			array(
				'slug'         => 'collection',
				'single_name'  => 'Collection',
				'plural_name'  => 'Collections',
				'post_type'    => 'ressource',
				//'rewrite'      => array( 'slug' => 'department' ),
                'new'          => 'Nouvelle',
                'hierarchical' => false,
                'menu_name'    => 'Collections',
			),
			array(
				'slug'         => 'editeur',
				'single_name'  => 'Editeur',
				'plural_name'  => 'Editeurs',
				'post_type'    => 'ressource',
                 'new'          => 'Nouvel',
                'hierarchical' => false,
                'menu_name'    => 'Editeurs',
			),
           array(
				'slug'         => 'auteurs',
				'single_name'  => 'Auteur',
				'plural_name'  => 'Auteurs',
				'post_type'    => 'ressource',
                 'new'          => 'Nouvel',
                'hierarchical' => false,
                'menu_name'    => 'Auteurs',
			),
            
           array(
				'slug'         => 'description_geographique',
				'single_name'  => 'Description géographique',
				'plural_name'  => 'Descriptions géographiques',
				'post_type'    => 'ressource',
                 'new'          => 'Nouvelle',
                'hierarchical' => false,
                'menu_name'    => 'Descr. géographique',
			),
		);
	
		foreach( $taxonomies as $taxonomy ) {
			$labels = array(
				'name' => $taxonomy['plural_name'],
				'singular_name' => $taxonomy['single_name'],
				'search_items' =>  'Recherche ' . $taxonomy['plural_name'],
				'all_items' => 'Tout ' . $taxonomy['plural_name'],
				'parent_item' => 'Parent ' . $taxonomy['single_name'],
				'parent_item_colon' => 'Parent ' . $taxonomy['single_name'] . ':',
				'edit_item' => 'Modifier ' . $taxonomy['single_name'],
				'update_item' => 'Mettre à jour ' . $taxonomy['single_name'],
				'add_new_item' => 'Ajouter ' . $taxonomy['single_name'],
				'new_item_name' => $taxonomy['new'].' ' . $taxonomy['single_name'] . ' Nom',
				'menu_name' => $taxonomy['menu_name'],
                'meta_box_cb' => false,
			);
			
			$rewrite = isset( $taxonomy['rewrite'] ) ? $taxonomy['rewrite'] : array( 'slug' => $taxonomy['slug'] );
			$hierarchical = isset( $taxonomy['hierarchical'] ) ? $taxonomy['hierarchical'] : true;
		
			register_taxonomy( $taxonomy['slug'], $taxonomy['post_type'], array(
				'hierarchical' => $hierarchical,
				'labels' => $labels,
				'show_ui' => true,
				'query_var' => true,
				'rewrite' => $rewrite,
			));
		}
		
	}
	add_action( 'init', 'ressources_register_taxonomies' );



// Fonction de recuperation des ressources 
// paramètres ( slug catégorie; nombre de posts,nopagination,format,Rubriques ACF - si nul tous, showcategories, monthago, resume (bool),limit_resume(int),tag_liste(bool) )

// utilisé en accueil
function get_last_ressources(
    $cat_ressources = '',
    $postperpage = 3,
    $nopagination = false, // sur false pour que posts_per_page fonctionne
    $format = "widget", //ou widget,liste-home-sous-site
    $acf_rubriques = '',
    $showcategories = false,
    $monthago = '3 month ago', // pour les tetes de rubrique
    $resume = false,
    $limit_resume = '',
    $sticky=false) {


    $args = array(
        'post_type' => 'ressource',
        'posts_per_page' => $postperpage,
        'nopaging' => $nopagination,
        //'post__in' => get_option( 'sticky_posts' ),
         );
        
            // si page archives
    if ( $format != 'archives' ) {     
        //si page actualité

         $args += [ 
                'date_query' => array(
            array(
                'column' => 'post_date_gmt',
                'after' => $monthago,
            ),
        )
          , ];
    }


    
    $rubriques=array(); // stockage de la recherche sur rubrique
     if ( $acf_rubriques != '177' ) {
                   $rubriques= array(
                        'key' => 'rubriques',
                        'value' => $acf_rubriques,
                        'type' => 'INT',
                        'compare' => 'LIKE'
                    );
        } 

    
        if ($sticky ) {         
            $args += [
                'meta_query' => array(
                    'relation' => 'AND',
                    array(
                        'key' => 'sticky',
                        'value' => 1,
                        'type' => 'INT',
                        'compare' => '='
                    ),              
                    $rubriques,
                    
                ),
                
            ];
        }  else {
            
             $args += [
                'meta_query' => array(
                    'relation' => 'AND',
                    $rubriques,
                ),
                
            ];
        }
    
    
            //arguments de requete WP_Query si aneb  id 177  on prend toutes les rubriques ( eptb, epage...)

    
      $args += [array(
        'orderby' => 'date',
        'order' => 'DESC' )];


    $query = new WP_Query( $args );
    ##print_r($query);
    ##  echo "Last SQL-Query: {$query->request}";
    //
    if ( $query->have_posts() ) {

        while ( $query->have_posts() ) {

            $query->the_post();

            include(locate_template('template-parts/content-ressource-'.$format.'.php')); // permet de recuperer les variables
			//get_template_part( 'template-parts/content', 'ressources' );

        }
    }
    wp_reset_query();
}



// paramètres ( slug catégorie; nombre de posts,nopagination,format,Rubriques ACF - si nul tous, showcategories, monthago, resume (bool),limit_resume(int),tag_liste(bool) )

function get_archives_ressources(
    $postperpage = 12,
    $nopagination = false, // sur false pour que posts_per_page fonctionne
    $acf_rubriques = '',
    $categorie='',
    $description_geographique='',
    $tagslugs = '',
    $type_document='',
    $genre_document='',
    $editeur='',    
    $year = '', 
    $showcategories = false,
    $resume = false,
    $limit_resume = '',
    $tag_liste = false,
    $typePost=false,
    $bootstrapclass='') {


    $args = array(
        'post_type' => 'ressource',
        'posts_per_page' => $postperpage,
        'nopaging' => $nopagination,
        'tag' => $tagslugs,
         );
        
  

    
    
//arguments de requete WP_Query si aneb  id 177  on prend toutes les rubriques ( eptb, epage...)
    if ( $acf_rubriques != '177' ) {
            $rub=  array(
                        'key' => 'rubriques',
                        'value' => $acf_rubriques,
                        'type' => 'INT',
                        'compare' => 'LIKE'
                    );
        } 
    else{
        $rub="";}
    
    if ( $categorie != '' ) {
            $cat=   array(
                'key' => 'categorie',
                'value' =>  $categorie,
                'compare' => 'LIKE',
                'type' => 'INT'
            );
        } 
    else{
        $cat="";}   
    
   if ( $description_geographique != '' ) {
            $descr=   array(
                'key' => 'description_geographique',
                'value' =>  $description_geographique ,
                'compare' => 'LIKE',
                'type' => 'INT'
            );
        } 
    else{
        $descr="";}  
    
   if ( $type_document != '' ) {
            $type_doc=   array(
                'key' => 'type_document',
                'value' =>  $type_document ,
                'compare' => '=',
                'type' => 'INT'
            );
        } 
    else{
        $type_doc="";} 
    
  if ( $genre_document != '' ) {
            $genre_doc=   array(
                'key' => 'genre_de_document',
                'value' =>  $genre_document ,
                'compare' => '=',
                'type' => 'INT'
            );
        } 
    else{
        $genre_doc="";} 
    
  if ( $editeur != '' ) {
            $edit=   array(
                'key' => 'genre_de_document',
                'value' =>  $editeur ,
                'compare' => '=',
                'type' => 'INT'
            );
        } 
    else{
         $edit="";} 
    
  if ( $year != '' ) {
            $year_=   
     array(
                'key' => 'annee',
                'value' =>  $year ,
                'compare' => '=',
                'type' => 'INT'
            );
        } 
    else{
         $year_="";}    
                
        $args += [ 
            
            'meta_query' => array(
            'relation' => 'AND',
            $rub, $cat,$descr,$type_doc,$genre_doc, $edit,$year_
            

        ), ];
     

      $args[] = array(
        'orderby' => 'date',
        'order' => 'DESC' );


    $query = new WP_Query( $args );
    ##print_r($query);
   ##echo "{$query->request}";
    //
    if ( $query->have_posts() ) {

        while ( $query->have_posts() ) {

            $query->the_post();

            include(locate_template('template-parts/content-ressource-compact.php')); // permet de recuperer les variables
			//get_template_part( 'template-parts/content', 'ressources' );

        }
    }
    else {
          include(locate_template('template-parts/content-no-result.php')); // 
    }
    wp_reset_query();
}



/*===============
ADMIN CONFIG
================*/
function remove_custom_meta_boxes() {
    // id metabox (dom) , post typ, position(sidebar)
    remove_meta_box( 'tagsdiv-langues', 'ressource', 'side' );
    remove_meta_box( 'tagsdiv-genre_de_document', 'ressource', 'side' );
    remove_meta_box( 'tagsdiv-collection', 'ressource', 'side' );
    remove_meta_box( 'tagsdiv-editeur', 'ressource', 'side' );
    remove_meta_box( 'tagsdiv-auteurs', 'ressource', 'side' );
    remove_meta_box( 'tagsdiv-categories_ressources', 'ressource', 'side' );
    remove_meta_box( 'tagsdiv-post_tag', 'ressource', 'side' );
    remove_meta_box( 'tagsdiv-description_geographique', 'ressource', 'side' );
}
add_action( 'admin_menu' , 'remove_custom_meta_boxes' );


?>