<div class="items-actualites-<?php echo $format ?> <?php echo $bootstrapclass ?> d-flex flex-column pb-2 mb-3">

    <article id="post-<?php the_ID(); ?>" <?php post_class( 'dotted-bottom pb-2'); ?>>

        <header>
            
 
            <?php   
            
           if($showcategories){
             $categorie_actu= get_field('categorie');   
               if(isset($categorie_actu[0]->name))
                echo '<p class="categorie">'.$categorie_actu[0]->name.'</p>';
                
            }
            
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
    
           
           if ( count( get_field( 'thematiques' ) ) > 0 ):
                echo '<div class="thematiques mb-3">';
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
            <?php    // chapo et image
            if ( has_post_thumbnail() ) {
                //attributs vignette
                $attr = array(
                    'class' => "img-fluid hvr-bounce-in mb-2 mt-1",
                    'alt' => get_the_title()
                );

                echo '<a href="';
                echo the_permalink();
                echo '" >';

                echo '<div class="' . $thumbBoxClass . '">';
                the_post_thumbnail( array( $thumbW, $thumbH ), $attr );
                echo '</div>';
                echo '</a>';
            }
        ?>


            <div class="text-justify chapo">

                <?php    (!empty(get_field( 'chapo' )))? print '<p>'.get_field( 'chapo' ).'</p>': print '<p>'.wp_trim_words( get_the_content(), 50, '...' ).'</p>';
        ?>

            </div>

            <div class="row">
                <div class="col-12 d-flex flex-row justify-content-between">

                    <?php   
      // affichage rubriques si aneb ( qui affiche tout) - pas besoin si autres puisqu'on est dans la rubrique
//            if ( $acf_rubriques == '177' ):
//                  if ( get_field( 'rubriques' ) ):
//                            echo '<div class="rubriques d-flex flex-row justify-content-end">';
//                    $rubriques = get_field( 'rubriques' );
//                    foreach ( $rubriques as $key => $value ) {
//                        echo '<a href="/'. $value->slug .'/" class="rubrique px-1 mr-2 ' . $value->slug . '">' . $value->name . '</a>';
//                    }
//                    echo '</div>';
//                    endif;
//            endif; 
            ?>


                    <div class="date_insert text-right justify-content-end">
                        <p>Posté le
                            <?php   the_date() ?>
                        </p>
                    </div>
                </div>
            </div>

        </div>
        <footer class="mt-2">
            <?php  echo get_the_tag_list( '<p class="tags">', ' ', '</p>' ); ?>
        </footer>
    </article>
    <!-- #post-## -->
</div>