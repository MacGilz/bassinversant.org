<?php


/*
    the_breadcrumb () 
    affiche_date_event($in,$out)
    clean_fichier_title($fichiertitle)
    texte_limit($texte,$max_char) > renvois le texte reduit
    the_content_limit($max_char) > renvois le content reduis avec habillage et lien lire + 
    affiche_taxonomie_links => Affichage custom taxonomies  
    affiche_rubriques (array(rubriques));
    affiche_type_content ; affiche si c'est une actua(et quelle categorie), si c'est une ressource...

*/

error_reporting( E_ALL );
ini_set( 'display_errors', 1 );


if ( !function_exists( 'wp_bootstrap_starter_setup' ) ):
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function wp_bootstrap_starter_setup() {
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on WP Bootstrap Starter, use a find and replace
         * to change 'wp-bootstrap-starter' to the name of your theme in all the template files.
         */
        load_theme_textdomain( 'wp-bootstrap-starter', get_template_directory() . '/languages' );

        // Add default posts and comments RSS feed links to head.
        add_theme_support( 'automatic-feed-links' );

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support( 'title-tag' );

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support( 'post-thumbnails' );

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus( array(
            'primary' => esc_html__( 'Primary', 'wp-bootstrap-starter' ),
        ) );

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support( 'html5', array(
            'comment-form',
            'comment-list',
            'caption',
        ) );

        // Set up the WordPress core custom background feature.
        add_theme_support( 'custom-background', apply_filters( 'wp_bootstrap_starter_custom_background_args', array(
            'default-color' => 'ffffff',
            'default-image' => '',
        ) ) );

        // Add theme support for selective refresh for widgets.
        add_theme_support( 'customize-selective-refresh-widgets' );

        function wp_boostrap_starter_add_editor_styles() {
            add_editor_style( 'custom-editor-style.css' );
        }
        add_action( 'admin_init', 'wp_boostrap_starter_add_editor_styles' );

    }
endif;
add_action( 'after_setup_theme', 'wp_bootstrap_starter_setup' );



/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *d'
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function wp_bootstrap_starter_content_width() {
    $GLOBALS[ 'content_width' ] = apply_filters( 'wp_bootstrap_starter_content_width', 1170 );
}
add_action( 'after_setup_theme', 'wp_bootstrap_starter_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function wp_bootstrap_starter_widgets_init() {
    register_sidebar( array(
        'name' => esc_html__( 'Sidebar', 'wp-bootstrap-starter' ),
        'id' => 'sidebar-1',
        'description' => esc_html__( 'Add widgets here.', 'wp-bootstrap-starter' ),
        'before_widget' => '<section id="%1$s" class="sidebar widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );
    register_sidebar( array(
        'name' => esc_html__( 'Footer 1', 'wp-bootstrap-starter' ),
        'id' => 'footer-1',
        'description' => esc_html__( 'Ajouter des widget.', 'wp-bootstrap-starter' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );
    register_sidebar( array(
        'name' => esc_html__( 'Footer 2', 'wp-bootstrap-starter' ),
        'id' => 'footer-2',
        'description' => esc_html__( 'Ajouter des widget.', 'wp-bootstrap-starter' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );
    register_sidebar( array(
        'name' => esc_html__( 'Footer 3', 'wp-bootstrap-starter' ),
        'id' => 'footer-3',
        'description' => esc_html__( 'Ajouter des widget.', 'wp-bootstrap-starter' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );
    register_sidebar( array(
        'name' => esc_html__( 'Accueils Rubriques', 'wp-bootstrap-starter' ),
        'id' => 'sidebar-rubrique',
        'description' => esc_html__( 'Ajouter des widget.', 'wp-bootstrap-starter' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );
}
add_action( 'widgets_init', 'wp_bootstrap_starter_widgets_init' );



/**
 * Enqueue scripts and styles.
 */
function wp_bootstrap_starter_scripts() {
    // load bootstrap css
    wp_enqueue_style( 'wp-bootstrap-starter-bootstrap-css', get_template_directory_uri() . '/inc/assets/css/bootstrap.min.css' );
    //wp_enqueue_style( 'wp-bootstrap-pro-fontawesome', get_template_directory_uri() . '/css/fontawesome.min.css' );
    // load bootstrap css
    // load AItheme styles
    // load WP Bootstrap Starter styles
    wp_enqueue_style( 'wp-bootstrap-starter-style', get_stylesheet_uri() );
    // wp_enqueue_style( 'hover-style-css', get_template_directory_uri() . '/css/hover.css' );

    if ( get_theme_mod( 'theme_option_setting' ) && get_theme_mod( 'theme_option_setting' ) !== 'default' ) {
        wp_enqueue_style( 'wp-bootstrap-starter-' . get_theme_mod( 'theme_option_setting' ), get_template_directory_uri() . '/inc/assets/css/presets/theme-option/' . get_theme_mod( 'theme_option_setting' ) . '.css', false, '' );
    }
    if ( get_theme_mod( 'preset_style_setting' ) === 'ubuntu' ) {
        wp_enqueue_style( 'wp-bootstrap-starter-Ubuntu-font', 'https://fonts.googleapis.com/css?family=Ubuntu+Condensed|Ubuntu:300,400,500,700' );
    }
    if ( get_theme_mod( 'preset_style_setting' ) === 'poppins-lora' ) {
        wp_enqueue_style( 'wp-bootstrap-starter-poppins-lora-font', 'https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i|Poppins:300,400,500,600,700' );
    }
    if ( get_theme_mod( 'preset_style_setting' ) === 'montserrat-merriweather' ) {
        wp_enqueue_style( 'wp-bootstrap-starter-montserrat-merriweather-font', 'https://fonts.googleapis.com/css?family=Merriweather:300,400,400i,700,900|Montserrat:300,400,400i,500,700,800' );
    }
    if ( get_theme_mod( 'preset_style_setting' ) === 'poppins-poppins' ) {
        wp_enqueue_style( 'wp-bootstrap-starter-poppins-font', 'https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700' );
    }
    if ( get_theme_mod( 'preset_style_setting' ) === 'roboto-roboto' ) {
        wp_enqueue_style( 'wp-bootstrap-starter-roboto-font', 'https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900,900i' );
    }
    if ( get_theme_mod( 'preset_style_setting' ) === 'arbutusslab-opensans' ) {
        wp_enqueue_style( 'wp-bootstrap-starter-arbutusslab-opensans-font', 'https://fonts.googleapis.com/css?family=Arbutus+Slab|Open+Sans:300,300i,400,400i,600,600i,700,800' );
    }
    if ( get_theme_mod( 'preset_style_setting' ) === 'oswald-muli' ) {
        wp_enqueue_style( 'wp-bootstrap-starter-oswald-muli-font', 'https://fonts.googleapis.com/css?family=Muli:300,400,600,700,800|Oswald:300,400,500,600,700' );
    }
    if ( get_theme_mod( 'preset_style_setting' ) === 'montserrat-opensans' ) {
        wp_enqueue_style( 'wp-bootstrap-starter-montserrat-opensans-font', 'https://fonts.googleapis.com/css?family=Montserrat|Open+Sans:300,300i,400,400i,600,600i,700,800' );
    }
    if ( get_theme_mod( 'preset_style_setting' ) === 'robotoslab-roboto' ) {
        wp_enqueue_style( 'wp-bootstrap-starter-robotoslab-roboto', 'https://fonts.googleapis.com/css?family=Roboto+Slab:100,300,400,700|Roboto:300,300i,400,400i,500,700,700i' );
    }
    //    Charge le css de typo , pas necessaire ici, on rapatrie tout dans styles.css

    //    if(get_theme_mod( 'preset_style_setting' ) && get_theme_mod( 'preset_style_setting' ) !== 'default') {
    //        wp_enqueue_style( 'wp-bootstrap-starter-'.get_theme_mod( 'preset_style_setting' ), get_template_directory_uri() . '/inc/assets/css/presets/typography/'.get_theme_mod( 'preset_style_setting' ).'.css', false, '' );
    //    }


    wp_enqueue_script( 'jquery' );

    // Internet Explorer HTML5 support
    /*    wp_enqueue_script( 'html5hiv', get_template_directory_uri() . '/inc/assets/js/html5.js', array(), '3.7.0', false );
        wp_script_add_data( 'html5hiv', 'conditional', 'lt IE 9' );
    */
    // load bootstrap js
    wp_enqueue_script( 'wp-bootstrap-starter-popper', get_template_directory_uri() . '/inc/assets/js/popper.min.js', array(), '', true );
    wp_enqueue_script( 'wp-bootstrap-starter-bootstrapjs', get_template_directory_uri() . '/inc/assets/js/bootstrap.min.js', array(), '', true );
    wp_enqueue_script( 'wp-bootstrap-starter-themejs', get_template_directory_uri() . '/inc/assets/js/theme-script.min.js', array(), '', true );

    wp_enqueue_script( 'wp-bootstrap-starter-skip-link-focus-fix', get_template_directory_uri() . '/inc/assets/js/skip-link-focus-fix.min.js', array(), '20151215', true );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'wp_bootstrap_starter_scripts' );


function conditionnal_enqueue() {
    // boostrap datepicker  (archives actu 404; ) ou archive-ressource
    if ( in_array( get_queried_object_id(), array( 404 ) ) || is_post_type_archive( 'ressource' ) ) {

        wp_enqueue_style( 'bootstrap-datepicker', get_template_directory_uri() . '/bootstrap-datepicker/css/bootstrap-datepicker3.min.css' );

        wp_enqueue_script( 'bootstrap-datepicker', get_template_directory_uri() . '/bootstrap-datepicker/js/bootstrap-datepicker.min.js', array(), '', true );

        wp_enqueue_script( 'bootstrap-datepickerjs', get_template_directory_uri() . '/bootstrap-datepicker/locales/bootstrap-datepicker.fr.min.js', array(), '', true );
    }


}

add_action( 'wp_enqueue_scripts', 'conditionnal_enqueue' );



/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load plugin compatibility file.
 */
require get_template_directory() . '/inc/plugin-compatibility/plugin-compatibility.php';

/**
 * Load custom WordPress nav walker.
 */
if ( !class_exists( 'wp_bootstrap_navwalker' ) ) {
    require_once( get_template_directory() . '/inc/wp_bootstrap_navwalker.php' );
}




/*====KBS=====*/

/* 2.1 */
function the_breadcrumb() {

    //page sans contenus servant de noeud dans l'arborescence et ne pouvant être cliquables
    $pageNoLink = array();

    // Settings
    $separator = ' <i class="fal fa-angle-right"></i>';
    $id = 'breadcrumbs';
    $class = 'breadcrumbs';
    $home_title = 'Accueil';
    $parents = '';

    // Get the query & post information
    global $post, $wp_query;
    $category = get_the_category();

    // Build the breadcrums
    echo '<nav class="hidden-xs">
<ul id="' . $id . '" class="' . $class . '">';

    // Do not display on the homepage
    if ( !is_front_page() ) {


        if ( is_single() ) {

            if ( is_singular( 'ressource' ) ) {

                echo '<li class="item-cat "><a class="bread-cat " href="/ressources" title="Les ressources Bassin-versant ANEB">Les ressources</a></li>';

            } else {
                // Single post (n'affiche que la première categorie)

                echo '<li class="item-cat item-cat-' . $category[ 0 ]->term_id . ' item-cat-' . $category[ 0 ]->category_nicename . '"><a class="bread-cat bread-cat-' . $category[ 0 ]->term_id . ' bread-cat-' . $category[ 0 ]->category_nicename . '" href="' . get_category_link( $category[ 0 ]->term_id ) . '" title="' . $category[ 0 ]->cat_name . '">' . $category[ 0 ]->cat_name . '</a></li>';

                echo '<li class="separator separator-' . $category[ 0 ]->term_id . '"> ' . $separator . ' </li>';

                echo '<li class="item-current item-' . $post->ID . '"><em class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . texte_limit( get_the_title(), 70 ) . '</em></li>';

            }

        } else if ( is_category() ) {

            // Category page
            echo '<li class="item-current item-cat-' . $category[ 0 ]->term_id . ' item-cat-' . $category[ 0 ]->category_nicename . '"><em class="bread-current bread-cat-' . $category[ 0 ]->term_id . ' bread-cat-' . $category[ 0 ]->category_nicename . '">' . $category[ 0 ]->cat_name . '</em></li>';

        } else if ( is_page() ) {

            // Standard page
            if ( $post->post_parent ) {

                // If child page, get parents
                $anc = get_post_ancestors( $post->ID );

                // Get parents in the right order
                $anc = array_reverse( $anc );

                // Parent page loop
                foreach ( $anc as $ancestor ) {

                    if ( in_array( $ancestor, $pageNoLink ) ) {


                        $parents .= '<li class="item-parent item-parent-' . $ancestor . ' breadcrumb_' . $ancestor . '" ><em>' . get_the_title( $ancestor ) . '</em></li>';
                        $parents .= '<li class="separator separator-' . $ancestor . '"> ' . $separator . ' </li>';

                    } else {

                        $parents .= '<li class="item-parent item-parent-' . $ancestor . '"><a class="bread-parent bread-parent-' . $ancestor . '" href="' . get_permalink( $ancestor ) . '" title="' . get_the_title( $ancestor ) . '">' . get_the_title( $ancestor ) . '</a></li>';
                        $parents .= '<li class="separator separator-' . $ancestor . '"> ' . $separator . ' </li>';


                    }
                }

                // Display parent pages
                echo $parents;

                // Current page
                echo '<li class="item-current item-' . $post->ID . '"><em title="' . get_the_title() . '"> ' . get_the_title() . '</em></li>';

            } else {

                // Just display current page if not parents
                //   echo '<li class="item-current item-' . $post->ID . '"><em class="bread-current bread-' . $post->ID . '"> ' . get_the_title() . '</em></li>';

            }

        } else if ( is_tag() ) {

            // Tag page

            // Get tag information
            $term_id = get_query_var( 'tag_id' );
            $taxonomy = 'post_tag';
            $args = 'include=' . $term_id;
            $terms = get_terms( $taxonomy, $args );

            // Display the tag name
            echo '<li class="item-current item-tag-' . $terms[ 0 ]->term_id . ' item-tag-' . $terms[ 0 ]->slug . '"><em class="bread-current bread-tag-' . $terms[ 0 ]->term_id . ' bread-tag-' . $terms[ 0 ]->slug . '">' . $terms[ 0 ]->name . '</em></li>';

        } elseif ( is_day() ) {

            // Day archive

            // Year link
            echo '<li class="item-year item-year-' . get_the_time( 'Y' ) . '"><a class="bread-year bread-year-' . get_the_time( 'Y' ) . '" href="' . get_year_link( get_the_time( 'Y' ) ) . '" title="' . get_the_time( 'Y' ) . '">' . get_the_time( 'Y' ) . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time( 'Y' ) . '"> ' . $separator . ' </li>';

            // Month link
            echo '<li class="item-month item-month-' . get_the_time( 'm' ) . '"><a class="bread-month bread-month-' . get_the_time( 'm' ) . '" href="' . get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) . '" title="' . get_the_time( 'M' ) . '">' . get_the_time( 'M' ) . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time( 'm' ) . '"> ' . $separator . ' </li>';

            // Day display
            echo '<li class="item-current item-' . get_the_time( 'j' ) . '"><em class="bread-current bread-' . get_the_time( 'j' ) . '"> ' . get_the_time( 'jS' ) . ' ' . get_the_time( 'M' ) . ' Archives</em></li>';

        } else if ( is_month() ) {

            // Month Archive

            // Year link
            echo '<li class="item-year item-year-' . get_the_time( 'Y' ) . '"><a class="bread-year bread-year-' . get_the_time( 'Y' ) . '" href="' . get_year_link( get_the_time( 'Y' ) ) . '" title="' . get_the_time( 'Y' ) . '">' . get_the_time( 'Y' ) . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time( 'Y' ) . '"> ' . $separator . ' </li>';

            // Month display
            echo '<li class="item-month item-month-' . get_the_time( 'm' ) . '"><em class="bread-month bread-month-' . get_the_time( 'm' ) . '" title="' . get_the_time( 'M' ) . '">' . get_the_time( 'M' ) . ' Archives</em></li>';

        } else if ( is_year() ) {

            // Display year archive
            echo '<li class="item-current item-current-' . get_the_time( 'Y' ) . '"><em class="bread-current bread-current-' . get_the_time( 'Y' ) . '" title="' . get_the_time( 'Y' ) . '">' . get_the_time( 'Y' ) . ' Archives</em></li>';

        } else if ( is_author() ) {

            // Auhor archive

            // Get the author information
            global $author;
            $userdata = get_userdata( $author );

            // Display author name
            echo '<li class="item-current item-current-' . $userdata->user_nicename . '"><em class="bread-current bread-current-' . $userdata->user_nicename . '" title="' . $userdata->display_name . '">' . 'Author: ' . $userdata->display_name . '</em></li>';

        } else if ( get_query_var( 'paged' ) ) {

            // Paginated archives
            echo '<li class="item-current item-current-' . get_query_var( 'paged' ) . '"><em class="bread-current bread-current-' . get_query_var( 'paged' ) . '" title="Page ' . get_query_var( 'paged' ) . '">' . __( 'Page' ) . ' ' . get_query_var( 'paged' ) . '</em></li>';

        } else if ( is_search() ) {

            // Search results page
            echo '<li class="item-current item-current-' . get_search_query() . '"><em class="bread-current bread-current-' . get_search_query() . '" title="Search results for: ' . get_search_query() . '">Search results for: ' . get_search_query() . '</em></li>';

        } elseif ( is_404() ) {

            // 404 page
            echo '<li>' . 'Error 404' . '</li>';
        }

    }

    echo '</ul>

</nav>';

}


function create_rubriques_taxonomy() {

    $labels = array(
        "name" => __( "Rubriques", "wp-bootstrap-starter" ),
        "singular_name" => __( "Rubrique", "wp-bootstrap-starter" ),
    );

    $args = array(
        "label" => __( "Rubriques", "wp-bootstrap-starter" ),
        "labels" => $labels,
        "public" => true,
        "hierarchical" => false,
        "label" => "rubriques",
        "show_ui" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        'show_in_quick_edit' => false,
        'meta_box_cb' => false,
        "query_var" => true,
        "rewrite" => array( 'slug' => 'rubriques', 'with_front' => true, ),
        "show_admin_column" => false,
        "show_in_rest" => false,
        "rest_base" => "rubriques",
        "show_in_quick_edit" => true,
        'all_items' => __( 'Toutes Rubriques' ),
        'edit_item' => __( 'Modifier Rubrique' ),
        'update_item' => __( 'Modifier Rubrique' ),
        'add_new_item' => __( 'Ajouter Rubrique' ),
        'new_item_name' => __( 'Nouveau nom de Rubrique' ),
        'menu_name' => __( 'Rubriques' )
    );
    register_taxonomy( "rubriques", array( 'post', 'ressource' ), $args );
}

add_action( 'init', 'create_rubriques_taxonomy' );



function actualites_register_taxonomies() {

    $taxonomies = array(

        array(
            'slug' => 'thematiques',
            'single_name' => 'Thématique',
            'plural_name' => 'Thématiques',
            'post_type' => 'post',
            //'rewrite'      => array( 'slug' => 'department' ),
            'new' => 'Nouvelle',
            'hierarchical' => false,
            'menu_name' => 'Thématiques',
        ),

        array(
            'slug' => 'categories_actus',
            'single_name' => 'categorie_actus',
            'plural_name' => 'categories_actus',
            'post_type' => 'post',
            'new' => 'Nouvelles',
            'hierarchical' => false,
            'menu_name' => 'Catégories Actus',
        ),


    );

    foreach ( $taxonomies as $taxonomy ) {
        $labels = array(
            'name' => $taxonomy[ 'plural_name' ],
            'singular_name' => $taxonomy[ 'single_name' ],
            'search_items' => 'Recherche ' . $taxonomy[ 'plural_name' ],
            'all_items' => 'Tout ' . $taxonomy[ 'plural_name' ],
            'parent_item' => 'Parent ' . $taxonomy[ 'single_name' ],
            'parent_item_colon' => 'Parent ' . $taxonomy[ 'single_name' ] . ':',
            'edit_item' => 'Modifier ' . $taxonomy[ 'single_name' ],
            'update_item' => 'Mettre à jour ' . $taxonomy[ 'single_name' ],
            'add_new_item' => 'Ajouter ' . $taxonomy[ 'single_name' ],
            'new_item_name' => $taxonomy[ 'new' ] . ' ' . $taxonomy[ 'single_name' ] . ' Nom',
            'menu_name' => $taxonomy[ 'menu_name' ],


        );

        $rewrite = isset( $taxonomy[ 'rewrite' ] ) ? $taxonomy[ 'rewrite' ] : array( 'slug' => $taxonomy[ 'slug' ] );
        $hierarchical = isset( $taxonomy[ 'hierarchical' ] ) ? $taxonomy[ 'hierarchical' ] : true;

        register_taxonomy( $taxonomy[ 'slug' ], $taxonomy[ 'post_type' ], array(
            'hierarchical' => $hierarchical,
            'labels' => $labels,
            'show_ui' => true,
            'query_var' => true,
            'rewrite' => $rewrite,
            'meta_box_cb' => false,
            'public' => true,
            'publicly_queryable' => true,
            'show_in_menu' => true,
            'show_in_nav_menus' => true,
            'show_in_rest' => false,
            'show_tagcloud' => false,
            'show_in_quick_edit' => false,
            'show_admin_column' => false,
        ) );
    }

}
add_action( 'init', 'actualites_register_taxonomies' );



// si date debut == fin , on affiche que début
function affiche_date_event( $in, $out ) {

    if ( $in == $out ) {
        return 'Le ' . $out;
    } else {

        return 'Du ' . $in . ' au ' . $out;
    }

}
// customise tag cloud widget
add_filter( 'widget_tag_cloud_args', 'all_tag_cloud_widget_parameters' );

function all_tag_cloud_widget_parameters() {
    $args = array(
        'smallest' => 1,
        'largest' => 1.333,
        'unit' => 'rem',
        //        'number' => '',
        //        'format' => 'flat', 
        'separator' => " | ",
        'orderby' => 'name',
        'order' => 'ASC',
        //        'exclude' => '', 
        //        'include' => '', 
        //        'link' => 'view', 
        'taxonomy' => 'post_tag',
        //   'post_type' => '', 
        //   'echo' => false //retrait titre
    );
    return $args;
}


/*TEXTES*/
function clean_fichier_title( $fichier ) {
    $search = array( '_', '-' );
    $replace = array( ' ', ' ' );
    return str_replace( $search, $replace, $fichier );

}

//reduit un texte simple sur nb caracteres ( ex titre dans le breadcrumb) . Retourne sans html
function texte_limit( $texte, $max_char ) {
    if ( ( strlen( $texte ) > $max_char ) && ( $espace = strpos( $texte, " ", $max_char ) ) ) {
        $texte = substr( $texte, 0, $espace );
        $texte = $texte;
        return $texte . "...";
    } else {
        return $texte;
    }
}


function the_content_limit( $limit ) {

    $content = explode( ' ', get_the_content(), $limit );
    if ( count( $content ) >= $limit ) {
        array_pop( $content );
        $content = implode( " ", $content ) . '...';
    } else {
        $content = implode( " ", $content );
    }
    $content = preg_replace( '/\[.+\]/', '', $content );
    $content = apply_filters( 'the_content', $content );
    $content = str_replace( ']]>', ']]&gt;', $content );
    return wp_strip_all_tags( $content );
}

if ( function_exists( 'acf_add_options_page' ) ) {

    acf_add_options_page( array(
        'page_title' => 'Configurations',
        'menu_title' => 'Configurations',
        'menu_slug' => 'config-actus',
        'capability' => 'manage_options',
        'redirect' => false
    ) );


    /*	sub page
    acf_add_options_sub_page(array(
    		'page_title' 	=> 'Theme Footer Settings',
    		'menu_title'	=> 'Footer',
    		'parent_slug'	=> 'theme-general-settings',
    	));*/

}

function get_tag_posts(
    $post_type = '',
    $cat_actu = '',
    $postperpage = 10,
    $nopagination = true,
    $format = "compact", //ou paysage ou archives
    $acf_rubriques = '',
    $thumbW = 360,
    $thumbH = 250,
    $thumbBoxClass = "w-100",
    $showcategories = false, // affiche  reseau, fil de l'eau...
    $tagslugs = '',
    $bootstrapclass = 'col-12',
    $typePost = false // affichage du type ressources ou actu
) {

    $args = array(
        'post_type' => $post_type,
        'posts_per_page' => $postperpage,
        'posts_per_archive_page' => $postperpage,
        'nopaging' => $nopagination,
        'tag' => $tagslugs, // ('tag1,tag2)   
        'orderby' => 'date',
        'order' => 'DESC' );


    $query = new WP_Query( $args );
    //print_r($query);
    //


    if ( $query->have_posts() ) {


        ( $query->found_posts > 1 ) ? print '<div class="col-12 foundpost">' . $query->found_posts . ' contenus trouvés.</div>' : print '<div class="col-12 foundpost">' . $query->found_posts . ' contenu trouvé.</div>';

        $col_Actus = '  <div class="col-12 col-sm-6">
      <div class="row" id="liste-actualites">
        <div class="col-12">
        <h2>Actualités</h2>
          </div>';

        $col_Ressources = '  <div class="col-12 col-sm-6">
      <div class="row" id="liste-ressources">
        <div class="col-12">
        <h2>Ressources</h2>
          </div>';

        while ( $query->have_posts() ) {

            $query->the_post();
            switch ( get_post_type() ) {
                case 'post':
                    ob_start();
                    include( locate_template( 'template-parts/content-actualite-' . $format . '.php' ) );
                    $col_Actus .= ob_get_clean();
                    break;
                case 'ressource':
                    ob_start();
                    include( locate_template( 'template-parts/content-ressource-' . $format . '.php' ) );
                    $col_Ressources .= ob_get_clean();
                    break;

                default:
                    break;
            }

        }
        $col_Actus .= '      </div>
  </div>';
        $col_Ressources .= '      </div>
  </div>';

        echo $col_Actus . $col_Ressources;

    }
    wp_reset_query();

}
// Fonction de recuperation des actualités 
// paramètres ( slug catégorie: term_id; sticky:bool,nombre de posts; pagination:bool; format;Rubrique ACF - si nul tous;thumb w, thumb height, thumbbox class; showcataegories:bool;date_in;date_out;$tagslugs:xx,xx; )

function get_post_actualites(
    $cat_actu = '',
    $stickyOnly = true,
    $postperpage = 0,
    $nopagination = false,
    $format = "portrait", //ou compact,paysage,archives
    $acf_rubriques = '',
    $thumbW = 360,
    $thumbH = 250,
    $thumbBoxClass = "w-100",
    $showcategories = false, // affiche  reseau, fil de l'eau...
    $date_in = '', // pour archives
    $date_out = '', // pour archives
    $thematique = '',
    $tagslugs = '',
    $bootstrapclass = 'col-12' ) //liste à virgule
{

    //geré par la page options ACF
    $monthago = get_field( 'nombre_unites_duree_actus', 'option' ) . ' ' . get_field( 'unite_duree_actus', 'option' ) . ' ago';

    if ( $postperpage == 0 )$postperpage = ''; //  0 == tout

    //traitement des dates de recherches, on separe le mois de l'année
    if ( !empty( $date_in ) ) {
        // si date in entrée
        $date_in = '01/' . $date_in;
        list( $day_in, $month_in, $year_in ) = explode( "/", $date_in );

        //si date out pas entrée on prend date_in
        if ( empty( $date_out ) ) {
            //$day_out=$day_in;
            $month_out = $month_in;
            $year_out = $year_in;

        } else {
            $date_out = '01/' . $date_out;
            list( $day_out, $month_out, $year_out ) = explode( "/", $date_out );
        }
    }

    /************/

    $args = array(

        'posts_per_page' => $postperpage,
        'nopaging' => $nopagination,
        'tag' => $tagslugs,

    );

    // si page archives
    if ( $format === 'archives' ) {

        $args += [

            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key' => 'rubriques',
                    'value' => $acf_rubriques,
                    'type' => 'INT',
                    'compare' => 'LIKE'
                ),
                array(
                    'key' => 'categorie_actu',
                    'value' => $cat_actu,
                    'compare' => 'LIKE',
                    'type' => 'INT'
                ),
                array(
                    'key' => 'thematiques',
                    'value' => $thematique,
                    'type' => 'INT',
                    'compare' => 'LIKE'
                ),


            ),
        ];


        // si pas de filtrage sur date
        if ( !empty( $year_in ) && !empty( $year_out ) ) {
            $args += [ 'date_query' => array(
                array(
                    'after' => array(
                        'year' => $year_in,
                        'month' => $month_in,
                    ),
                    'before' => array(
                        'year' => $year_out,
                        'month' => $month_out,
                    ),
                    'inclusive' => true,
                )
            ), ];
        } else {


            $args += [
                'date_query' => array(
                    array(
                        'column' => 'post_date_gmt',
                        'before' => $monthago,
                    ),
                ),
            ];

        }

    } else {

        //si page actualité

        //arguments de requete WP_Query si aneb id 177  on prend toutes les rubriques ( eptb, epage...)
        if ( $acf_rubriques != '177' ) {
            $args += [
                'meta_query' => array(
                    'relation' => 'AND',
                    array(
                        'key' => 'rubriques',
                        'value' => $acf_rubriques,
                        'type' => 'INT',
                        'compare' => 'LIKE'
                    ),
                    array(
                        'key' => 'categorie_actu',
                        'value' => $cat_actu,
                        'compare' => 'LIKE',
                        'type' => 'INT'
                    ),

                ),
            ];
        } else {

            $args += [
                'meta_query' => array(
                    'relation' => 'AND',
                    array(
                        'key' => 'categorie_actu',
                        'value' => $cat_actu,
                        'compare' => 'LIKE',
                        'type' => 'INT'
                    ),

                ),
            ];
        }

    }


    if ( $stickyOnly ) {

        $sticky = get_option( 'sticky_posts' ); // array tous les articles mise en avant  
        $args += [ 'post__in' => $sticky ];

    } else {

        $args += [
            'date_query' => array(
                array(
                    'column' => 'post_date_gmt',
                    'after' => $monthago,
                ),
            ),
        ];
        $args += [ 'ignore_sticky_posts' => 1 ];
    }

    $args += [
        array(
            'orderby' => 'date',
            'order' => 'DESC' )
    ];


    ## AJOUTER CONDITION NO ARCHIVES !!!!


    /***********/

    #print_r( $args );

    $query = new WP_Query( $args );

    ##echo $query->request;
    ##echo $query->found_posts;
    // habillage format    
    switch ( $format ) {
        case 'archives':

            //nb actus
            $nbActus = $query->found_posts;
            $nbActus > 1 ? print '<div class="col-12"><div class="nombre_posts text-center">' . $nbActus . ' actualités</div></div>': print '<div class="col-12"><div class="nombre_posts col-12 text-center">' . $nbActus . ' actualité</div></div>';
            break;
            default:
            break;
    }


    $i = 1;

    if ( $query->have_posts() ) {

        while ( $query->have_posts() ) {

            $query->the_post();

            include( locate_template( 'template-parts/content-actualite-' . $format . '.php' ) ); // permet de recuperer les variables

            $i++;
        }
    } else {

        echo '<div class="mx-auto"><p class="nopost text-center"><i class="fas fa-exclamation"></i> <br>Aucune actualité dans cette rubrique pour le moment</p></div>';
    }

    wp_reset_query();
    wp_reset_postdata();
}


function get_actus_carrousel(
    $stickyOnly = true,
    $posts_per_page=3,
    $acf_rubriques = '',
    $thumbW = 360,
    $thumbH = 250
) 
{
    $args = array(

        'post_type' => 'post',
        'posts_per_page' =>$posts_per_page,
        'ignore_sticky_posts' => true,
        'post__in' =>get_option( 'sticky_posts' ),
        //par defaut les sticky post sont toujours ajoutés au debut de chaque requete, qu'elle les reclame ou non !
       
    );


            //arguments de requete WP_Query si aneb id 177  on prend toutes les rubriques ( eptb, epage...)
        if ( $acf_rubriques != '177' ) {
            $args += [
                'meta_query' => array(
                    'relation' => 'AND',
                    array(  
                        'key' => 'rubriques',
                        'value' => $acf_rubriques,
                        'type' => 'INT',
                        'compare' => 'LIKE'
                    ),
                   

                ),
            ];
        } 

    $args += [
        array(
            'orderby' => 'date',
            'order' => 'DESC' )
    ];


    /***********/

    //print_r( $args );

    $caroussel_query = new WP_Query( $args );

    ##echo $caroussel_query->request;
    ##echo '<br>' . $caroussel_query->found_posts . '<br>';

    $indicators='<ul class="carousel-indicators">';
   
    $i = 0;
    $carousselclass = '';
    $slides='';

    if ( $caroussel_query->have_posts() ) {

        while ( $caroussel_query->have_posts() ) {
            
           
            $caroussel_query->the_post();

            ( $i == 0 ) ? $carousselclass = ' active ': $carousselclass = '';
            
            if($caroussel_query->found_posts>1){
            $indicators.='<li data-target="#caroussel-actus" data-slide-to="'.$i.'" class="'.$carousselclass.'"></li>';}
            
            ob_start();
            include(locate_template('template-parts/content-actualite-caroussel-sm.php')); // permet de recuperer les variables
            $slides .= ob_get_clean();
            
            $i++;
        }
        
        
    } else {

        echo '<div class="mx-auto"><p class="nopost text-center"><i class="fas fa-exclamation"></i> <br>Aucune actualité dans cette rubrique pour le moment</p></div>';
    }
    
       $indicators.='
       </ul>';
      $caroussel=$indicators.'
                <div class="carousel-inner">'.
          $slides.'
                </div>';
    
if($caroussel_query->found_posts>1){
  $caroussel.='<a class="carousel-control-prev" href="#caroussel-actus" data-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </a>
  <a class="carousel-control-next" href="#caroussel-actus" data-slide="next">
    <span class="carousel-control-next-icon"></span>
  </a>';
}
    
    return $caroussel;

    wp_reset_query();
    wp_reset_postdata();
}



// Affichage custom taxonomies  dans les posts  !! et get_the_tag_list XXXX:!!!
function affiche_taxonomie_links( $post_id = '', $arrayslugs = array(), $class = '', $before = '', $after = '', $sep = ' ' ) {

    $terms = wp_get_object_terms( $post_id, $arrayslugs );

    ##    print_r($arrayslugs);

    // init counter
    $i = 1;
  

    if ( count( $terms ) > 0 ) {

        $vue = '<div class="' . $class . '" >' . $before;
        foreach ( $terms as $term ) {
            $term_link = get_term_link( $term, $arrayslugs );
            
           
            
            if ( is_wp_error( $term_link ) )
            continue;
            $vue .= '<a href="/tag/' . $term->slug . '" class="' . $term->taxonomy . '">' . $term->name . '</a>';
            //  ajout separateur
            $vue .= ( $i < count( $terms ) ) ? $sep : "";
            //  compteur
            $i++;

        }
        $vue .= '</div>';
        
        return $vue;
    }

}

add_action( 'init', 'affiche_taxonomie_links' );



function affiche_rubriques( $rubriques ) {
    if ( !empty( $rubriques ) ) {
        $view = '';
        foreach ( $rubriques as $key => $value ) {
            $view .= '<a href="/' . $value->slug . '" class="rubrique hvr-sweep-to-right ' . $value->slug . ' mr-2">' . $value->name . '</a>';
        }
        return $view;
    }
}

function affiche_type_content( $type ) {
    $infos = "";
    switch ( $type ) {
        case 'ressource':
            $infos = "Ressource";
            break;
        case 'post':
            $infos = "Actualité";
            break;
        case 'attachment':
            $infos = "Fichier média";
            break;
        default:
            $infos = "Page";
            break;
    }

    return $infos;
}

/*===============
SEARCH & FILTER FORM
================*/
function search_form_filter( $input_object, $sfid ) {


    if ( ( $input_object[ 'type' ] == 'select' ) ) {
        $input_object[ 'attributes' ][ 'class' ] = 'form-control form-control-sm';
        return $input_object;
    }

    if ( $input_object[ 'name' ] == '_sf_search' ) {
        $input_object[ 'attributes' ][ 'class' ] = 'form-control form-control-sm';
        return $input_object;
    }
    if ( $input_object[ 'type' ] == 'submit' ) {
        $input_object[ 'attributes' ][ 'class' ] = 'btn btn-primary';
        return $input_object;
    }

}
//add_filter('sf_input_object_pre', 'search_form_filter', 10, 2);

// recherche seulement dans les pdf
function filter_function_name( $query_args, $sfid ) {
    print_r( $query_args );
    if ( $sfid == 526 ) {
        //modify $query_args here before returning it
        $query_args[ 'post_mime_type' ] = array( 'NULL', 'application/pdf', 'image/jpg' );
    }

    return $query_args;
}
//add_filter( 'sf_edit_query_args', 'filter_function_name', 20, 2 );




/*===============
QUFORM  gestion des dependances js et css dans les pages
================*/

//function my_quform_scripts( $enqueue ) {
//    if ( !in_array( get_queried_object_id(), array( 149 ) ) ) { //liste des ids avec formulaires   
//        $enqueue = false;
//    }
//
//    return $enqueue;
//}
//add_filter( 'quform_enqueue_scripts', 'my_quform_scripts' );
//add_filter( 'quform_enqueue_styles', 'my_quform_scripts' );


/*===============
BUDDY PRESS 
================*/


// Permet de recupere les groupes dans acf ( declarer un champ et uiliser sont slug ci-dessous ex : bp_group)
function acf_load_bp_groups( $field ) {
    // Reset choices
    $field[ 'choices' ] = array();
    $user_id = get_current_user_id();
    $groups = array();
    if ( bp_has_groups( 'user_id=' . $user_id ) ):
        while ( bp_groups() ): bp_the_group();
    $groups[] = bp_get_group_name() . '_' . bp_get_group_id();
    endwhile;
    endif;

    // Populate choices
    foreach ( $groups as $group ) {
        $groupvalues = explode( '_', $group );
        $field[ 'choices' ][ $groupvalues[ 1 ] ] = $groupvalues[ 0 ];
    }

    // Return choices
    return $field;

}
// Populate select field using filter
add_filter( 'acf/load_field/name=bp_group', 'acf_load_bp_groups' );


//Types de groupes
function my_bp_custom_group_types() {
    bp_groups_register_group_type( 'structure', array(
        'labels' => array(
            'name' => 'Structures',
            'singular_name' => 'Structure'
        ),

        // New parameters as of BP 2.7.
        'has_directory' => 'structures',
        'show_in_create_screen' => true,
        'show_in_list' => true,
        'description' => '',
        'create_screen_checked' => true
    ) );
}
add_action( 'bp_groups_register_group_types', 'my_bp_custom_group_types' );


// Role par defaut
add_filter( 'pre_option_default_role', function ( $default_role ) {
    // You can also add conditional tags here and return whatever
    return 'subscriber'; // This is changed
    return $default_role; // This allows default
} );

// add order options to members loop
function ch_member_order_options() {
    ?>
    <option value="contributing">
        <?php _e( 'Contributing Members', 'buddypress' ); ?>
    </option>
    <?php
}
add_action( 'bp_members_directory_order_options', 'ch_member_order_options' );


// filter ajax members by contributing
function ch_filter_ajax_querystring( $querystring = '', $object = '' ) {

    if ( $object != 'members' )
        return $querystring;

    $defaults = array(
        'type' => 'active',
        'action' => 'active',
        'scope' => 'all',
        'page' => 1,
        'user_id' => 0,
        'search_terms' => '',
        'exclude' => false,
    );

    $ch_querystring = wp_parse_args( $querystring, $defaults );

    if ( $ch_querystring[ 'type' ] == 'contributing' ) {

        // to get members by xprofile field, you need some custom sql here
        // here's an example: 
        //https://codex.buddypress.org/developer/loops-reference/the-members-loop/#code-examples

        $users = get_users( array( 'fields' => array( 'ID' ), 'role' => 'administrator' ) );

        $users_str = '';
        foreach ( $users as $user ) {
            $users_str .= $user->ID . ',';
        }
        $users_str = rtrim( $users_str, "," );

        $ch_querystring[ 'include' ] = $users_str;
        $ch_querystring[ 'type' ] = 'alphabetical';

        return $ch_querystring;

    } else
        return $querystring;

}
add_filter( 'bp_ajax_querystring', 'ch_filter_ajax_querystring', 20, 2 );


// get ID des users avec roles en parametres
//fonction utilisée dans le template members-loop.php
function exclude_by_role( $exclude_roles ) {

    $memberArray = array();

    if ( bp_has_members() ):
        while ( bp_members() ): bp_the_member();
    $user = new WP_User( bp_get_member_user_id() );
    $user_role = $user->roles[ 0 ];
    foreach ( $exclude_roles as $exclude_role ) {
        if ( $exclude_role == $user_role ) {
            array_push( $memberArray, $user->ID );
            break;
        }
    }
    endwhile;
    endif;

    $theExcludeString = implode( ",", $memberArray );

    return $theExcludeString;
}



// CHAMPS CUSTOM BuddyPress Groups   
//it's important to check if the Groups component is active
if ( bp_is_active( 'groups' ) ):

    class bpgmq_feature_group {

        public
        function __construct() {
            $this->setup_hooks();
        }

        private
        function setup_hooks() {
            // in Group Administration screen, you add a new metabox to display a checkbox to featured the displayed group
            add_action( 'bp_groups_admin_meta_boxes', array( $this, 'admin_ui_edit_featured' ) );
            // Once the group is saved you store a groupmeta in db, the one you will search for in your group meta query
            add_action( 'bp_group_admin_edit_after', array( $this, 'admin_ui_save_featured' ), 10, 1 );
        }

        /**
         *  Declaration de la metabox
         */
        public
        function admin_ui_edit_featured() {
            add_meta_box(
                'bpgmq_feature_group_mb',
                __( 'Adresse' ),
                array( & $this, 'admin_ui_metabox_adresse' ),
                get_current_screen()->id,
                'normal', // position dnas l'editeur 
                'high' //priorite haute, au dessus du texte
            );

        }

        /**
         * Displays the meta box
         */
        public
        function admin_ui_metabox_adresse( $item = false ) {
            if ( empty( $item ) )
                return;

            // Requete recupération des valeurs
            $is_featured = groups_get_groupmeta( $item->id, '_rue' );
            $meta_ville = groups_get_groupmeta( $item->id, '_ville' );
            $meta_cp = groups_get_groupmeta( $item->id, '_cp' );
            $meta_site = groups_get_groupmeta( $item->id, '_site' );
            $meta_tel = groups_get_groupmeta( $item->id, '_tel' );
            ?>
            <p>
                <label>
                    <?php _e( 'Adresse' );?>
                    <input type="text" style="width:100%" id="group_rue" name="group_rue" value="<?php echo  $is_featured ;?>">
                </label>
            </p>
            <p>
                <label>
                    <?php _e( 'Ville' );?>
                </label>
                <input type="text" id="group_ville" name="group_ville" value="<?php echo  $meta_ville ;?>">
            </p>
            <p>
                <label>
                    <?php _e( 'Code postal' );?>
                </label>
                <input type="text" id="group_cp" name="group_cp" value="<?php echo  $meta_cp ;?>">
            </p>
            <p>
                <label>
                    <?php _e( 'Téléphone' );?>
                </label>
                <input type="text" id="group_tel" name="group_tel" value="<?php echo  $meta_tel ;?>">

            </p>
            <p>
                <label>
                    <?php _e( 'Url site web' );?> (sans protocole)
                    <input type="text" style="width:100%" id="group_site" name="group_site" value="<?php echo  $meta_site ;?>">
                </label>
            </p>
            <?php
            // sbpgmq-featured-cbassure que le contenu du formulaire proviens bien du site !
            wp_nonce_field( 'bpgmq_featured_save_' . $item->id, 'bpgmq_featured_admin' );
        }

        function admin_ui_save_featured( $group_id = 0 ) {
            if ( 'POST' !== strtoupper( $_SERVER[ 'REQUEST_METHOD' ] ) || empty( $group_id ) )
                return false;

            check_admin_referer( 'bpgmq_featured_save_' . $group_id, 'bpgmq_featured_admin' );



            // Sauvegarde des valeurs formulaire
            $adresse = !empty( $_POST[ 'group_rue' ] ) ? $_POST[ 'group_rue' ] : '';
            $ville = !empty( $_POST[ 'group_ville' ] ) ? $_POST[ 'group_ville' ] : '';
            $cp = !empty( $_POST[ 'group_cp' ] ) ? $_POST[ 'group_cp' ] : '';
            $site = !empty( $_POST[ 'group_site' ] ) ? $_POST[ 'group_site' ] : '';
            $telephone = !empty( $_POST[ 'group_tel' ] ) ? $_POST[ 'group_tel' ] : '';

            if ( !empty( $adresse ) )
                groups_update_groupmeta( $group_id, '_rue', $adresse );
            if ( !empty( $ville ) )
                groups_update_groupmeta( $group_id, '_ville', $ville );
            if ( !empty( $cp ) )
                groups_update_groupmeta( $group_id, '_cp', $cp );
            if ( !empty( $site ) )
                groups_update_groupmeta( $group_id, '_site', $site );
            if ( !empty( $telephone ) )
                groups_update_groupmeta( $group_id, '_tel', $telephone );
        }

    }

/**

 * Using bp_is_active() in this case is not needed
 * But i think it's a good practice to use this kind of check
 */
function bpgmq_feature_group() {
    if ( bp_is_active( 'groups' ) )
        return new BPGMQ_Feature_Group();
}

add_action( 'bp_init', 'bpgmq_feature_group' );
endif;

/*changer la taille des avatars groupe*/
if ( !defined( 'BP_AVATAR_THUMB_WIDTH' ) )
    define( 'BP_AVATAR_THUMB_WIDTH', 80 );

if ( !defined( 'BP_AVATAR_THUMB_HEIGHT' ) )
    define( 'BP_AVATAR_THUMB_HEIGHT', 55 );

if ( !defined( 'BP_AVATAR_FULL_WIDTH' ) )
    define( 'BP_AVATAR_FULL_WIDTH', 520 );

if ( !defined( 'BP_AVATAR_FULL_HEIGHT' ) )
    define( 'BP_AVATAR_FULL_HEIGHT', 360 );



/*===============
OPTIMISATION FRONTEND
================*/

/**
 * Supprime les fonctions inutiles de l'entête
 */
add_action( 'init', 'clean_head' );

function clean_head() {
    remove_action( 'wp_head', 'wp_generator' );
    remove_action( 'wp_head', 'feed_links', 2 ); // Affiche les liens des flux RSS pour les Articles et les commentaires.
    remove_action( 'wp_head', 'feed_links_extra', 3 ); // Affiche les liens des flux RSS supplémentaires comme les catégories de vos articles.
    remove_action( 'wp_head', 'rsd_link' ); // Affiche le lien RSD (Really Simple Discovery). Je ne l'ai jamais utilisé mais si vous êtes certain d'en avoir besoin, laissez-le.
    remove_action( 'wp_head', 'wlwmanifest_link' ); // Affiche le lien xml dont a besoin Windows Live Writer pour accéder à votre blog. Si vous ne publiez pas vos articles avec ce logiciel, il ne vous sert à rien.
    remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 ); // Affiche les liens relatifs vers les articles suivants et précédents. (<kbd> <link title=" href=" rel="prev" /></kbd> et <kbd> <link title="" href=""" rel="next" /></kbd>). Ces liens peuvent parfois affecter votre SEO.

    remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 ); // Affiche l'url raccourcie de la page ou vous vous situez.

    /**
     * On en profite pour supprimer le style en trop ajouté par le widget "Commentaires récents"
     */
    global $wp_widget_factory;
    remove_action( 'wp_head', array( $wp_widget_factory->widgets[ 'WP_Widget_Recent_Comments' ], 'recent_comments_style' ) );
}



/*===============
ADMIN CONFIG
================*/

//CSS
function admin_css() {

    $admin_handle = 'admin_css';
    $admin_stylesheet = get_template_directory_uri() . '/css/admin.css';

    wp_enqueue_style( $admin_handle, $admin_stylesheet );
}
add_action( 'admin_print_styles', 'admin_css', 11 );



//logo  custom
function custom_loginlogo() {
    echo '<style type="text/css">
h1 a {background-image: url(' . content_url() . '/uploads/2018/07/logo-bassinversant.svg) !important; width:100% !important;background-size:contain !important}
</style>';
}
add_action( 'login_head', 'custom_loginlogo' );

/**
 * On supprime les widgets inutiles du dashboard WordPress
 */
function clean_dashboard_widgets() {
    remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' ); // Plugins populaires
    remove_meta_box( 'dashboard_primary', 'dashboard', 'normal' ); // Feed du Blog WordPress.org
    remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' ); // Des news de WordPress
    remove_meta_box( 'dashboard_quick_press', 'dashboard', 'normal' ); // Publiez rapidement un article
    remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'normal' ); // Vos récents brouillons
    remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' ); // Liens entrants
}
add_action( 'admin_init', 'clean_dashboard_widgets' );


/*Retrait WordPress menu  de l'admin bar*/
add_action( 'admin_bar_menu', 'remove_wp_logo', 999 );

function remove_wp_logo( $wp_admin_bar ) {
    $wp_admin_bar->remove_node( 'wp-logo' );
}

//retrait messages footer admin
add_filter( 'admin_footer_text', '__return_empty_string', 11 );
add_filter( 'update_footer', '__return_empty_string', 11 );


/*desactive alerte mise a jour WP*/
if ( !current_user_can( 'edit_users' ) ) {
    add_action( 'init', create_function( '$a', "remove_action( 'init', 'wp_version_check' );" ), 2 );
    add_filter( 'pre_option_update_core', create_function( '$a', "return null;" ) );

}