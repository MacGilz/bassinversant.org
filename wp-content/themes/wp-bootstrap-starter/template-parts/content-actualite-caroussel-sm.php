
<div class="carousel-item  px-4 py-2 items-actualites-<?php echo $format ?> <?php echo $carousselclass ?> <?php echo $bootstrapclass ?>" >

    <article id="post-<?php the_ID(); ?>" <?php post_class( ); ?>>

        
        <div class="row">
            
                            <?php    // chapo et image
            if ( has_post_thumbnail() ) {
                
                $classcol2="col-7";
                
                //attributs vignette
                $attr = array(
                    'class' => "img-fluid hvr-bounce-in mb-2 mt-1",
                    'alt' => get_the_title()
                );

                echo '<div class="col-5"><a href="';
                echo the_permalink();
                echo '" >';
                the_post_thumbnail( '', $attr );
                echo '
                ';
                echo '</a></div>';
            }
            else{
                $classcol2="col-12";
            }
        ?>
            
            <div class="<?php echo $classcol2 ?>">
                        <header>
            <?php       
            // titre
            echo '<a href="';
            echo the_permalink();
            echo '" >';
            
            echo '<h3>';
            the_title();
            echo '</h3>
            </a>';

  
    
            if ( get_field( 'evenement' ) ) {
                echo '<div class="evenement mb-2"><p> <i class="fas fa-calendar-check mr-2"></i>' . affiche_date_event( get_field( 'date_de_debut' ), get_field( 'date_fin' ) ) . '</p></div>';
            };
    
           
           if ( !empty( get_field( 'thematiques' ) ) > 0 ):
                echo '<div class="thematiques mb-2">';
            $thematiques = get_field( 'thematiques' );

            $i = 1;
            foreach ( $thematiques as $key => $value ) {
                if ( $i > 1 )echo '<span class="mx-1 sep"> | </span>';
                echo '<a class="thematique" href="' . get_term_link( $value->slug, 'thematiques' ) . '" title="' . $value->name . '">' . $value->name . '</a>';

                $i++;
            }
            echo '</div>';
            endif;
    
    ?>
        </header>
           
            
                  <div class="item-content">



            <div class="text-justify chapo">

                <?php  (!empty(get_field( 'chapo' )))? print '<p>'.get_field( 'chapo' ).'</p>': print '<p>'.wp_trim_words( get_the_content(), 50, '...' ).'</p>';
        ?>

            </div>

            <div class="row">
                <div class="col-12">
                    <div class="date_insert text-right">
                        <p class="text-right">Posté le
                            <?php   the_date() ?>
                        </p>
                    </div>
                </div>
            </div>
 </div>
        </div>  
        </div>
        
    </article>  
    <!-- #post-## -->
</div>