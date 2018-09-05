<?php

$class = '';

if( is_page() ) { 
	global $post;
        /* les ancetres s'ils existent */
	$parents = get_post_ancestors( $post->ID );
        /* niveau supérieurl page->ID count base 1, array base 0  donc -1 */ 
	$id = ($parents) ? $parents[count($parents)-1]: $post->ID;
	/* page slug (post_name) */
        $parent = get_post( $id );
	 $class = $parent->post_name;
}


?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-TXfwrfuHVznxCssTxWoPZjhcss/hp38gEOH8UPZG/JcXonvBQ6SlsIF49wUzsGno" crossorigin="anonymous">
</head>

<body <?php body_class($class); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'wp-bootstrap-starter' ); ?></a>
    <?php if(!is_page_template( 'blank-page.php' ) && !is_page_template( 'blank-page-with-container.php' )): ?>
	<header id="masthead" class="site-header navbar-static-top <?php echo wp_bootstrap_starter_bg_class(); ?>" role="banner">
    
<div class="container-fluid" id="topheader">
    <div class="container">
        <div class="row">
        <div class="col-12" id="header-searchform">
            <div class=" float-right">
            <?php get_search_form(); ?>
            </div>
        </div>
        </div>

    </div>


</div>
        <div id="bandeau" class="container" >
            <div class="row justify-content-between">
            <div class="navbar-brand col-sm-4">
                 
                        <a href="<?php echo esc_url( home_url( '/' )); ?>">
                           <?php  include "logo-svg.php" ?>                            
                        </a>

                </div>
                
            <div class=" col-sm-4 my-auto">
                <div class="float-right connexion py-2 px-3">
                            
            <?php
            if ( is_user_logged_in() ) {
                $current_user = wp_get_current_user();
                /**
                 * @example Safe usage: $current_user = wp_get_current_user();
                 * if ( !($current_user instanceof WP_User) )
                 *     return;
                 */

                echo '<div> <a href="javascript:;" class="name"><i class="far fa-user-lock mr-1"></i>' . $current_user->display_name . '</a></div>';
                echo '<div> <a href="javascript:;">Mon espace</a> | <a href="javascript:;" class="modal-login-logOutClass">Déconnexion</a></div>';

            }
            if ( !is_user_logged_in() ) {
                echo '<div><a href="javascript:;" class="modal-login-loginClass"><i class="far fa-unlock mr-1"></i> Connexion</a></div>';
                echo '<div><a href="javascript:;" class=""><i class="far fa-user-plus mr-1"></i> Adhérer</a></div>';
            }
            ?>
			
					</div>

                </div>
            </div>
        </div>
           
         	<div id="barrenavigation" class="container-fluid <?php if(!is_front_page()) echo " fixed-header " ;?>">
			<div class="container">
                
            <nav class="navbar navbar-expand-xl p-0">
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-nav" aria-controls="" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
              
               <?php //include('logo-ANEB-svg.php') ?> 
                
                <?php
                wp_nav_menu(array(
                'theme_location'  => 'primary',
                'container'       => 'div',
                'container_id'    => 'main-nav',
                'container_class' => 'collapse navbar-collapse justify-content-end ',
                'menu_id'         => false,
                'menu_class'      => 'navbar-nav',
                'depth'           => 3,
                'fallback_cb'     => 'wp_bootstrap_navwalker::fallback',
                'walker'          => new wp_bootstrap_navwalker()
                ));
                ?>

            </nav>
                    </div>
                </div>
     
    
	</header><!-- #masthead -->

	<div id="content" class="<?php is_front_page()? print 'home-content': print 'site-content';  ?>">
                <?php endif; ?>
                
              