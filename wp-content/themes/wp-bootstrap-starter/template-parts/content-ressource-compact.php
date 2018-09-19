
<div class="d-flex flex-column <?php echo $bootstrapclass ?>  items-ressources my-3">
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <?php
        $enable_vc = get_post_meta( get_the_ID(), '_wpb_vc_js_status', true );
        if ( !$enable_vc ) {
            ?>
        <header class="entry-header">
        
<?php /*?>            <?php if($typePost):?>
            <p class="mb-0 text-right type-contenu"><em>Ressources</em></p>
            <?php endif; ?><?php */?>
            <?php the_title( '<a href="'.get_permalink() .'"><h3 class="entry-title">', '</h3></a>' ); ?>
        </header>
        <!-- .entry-header -->
        <?php } ?>

        <div class="entry-content">
          
            <div class="d-flex justify-content-between mb-3">
        <?php 
     $genre = '';
            if ( get_field( 'genre_de_document' ) ) {
                $getgenre = get_field( 'genre_de_document' );
                $genre = $getgenre->name . '. ';
            }
            echo '<div class="infosgenre">';
            echo  get_field( 'categories_ressources' ) . $genre . get_field( 'annee' );
            echo '</div>';
            
              
            if ($acf_rubriques == 177 OR $acf_rubriques==''):
               $rubriques = get_field( 'rubriques' );
                
                echo '<div class="rubriques">';
                foreach ( $rubriques as $key => $value ) {
                    echo '<a href="/' . $value->slug . '/" class="rubrique  ml-2 ' . $value->slug . '">' . $value->name . '</a>';
                }
                 echo '</div>';
             
            endif;
?>
            </div>

<div>
    
    
 <?php 
    
    if (!empty( get_field( 'thematiques' ) ) > 0 ):
             echo '<div class="thematiques mb-3">';
            $thematiques = get_field( 'thematiques' );

            $i = 1;
            
            foreach ( $thematiques as $key => $value ) {
                if ( $i > 1 )echo '<span class="mx-1 sep"> | </span>';
                echo '<a class="thematique" href="' . get_term_link( $value->slug, 'thematiques' ) . '" title="' . $value->name . '">' . $value->name . '</a>';

                $i++;
            }
            
echo '</div>';
else : echo '<hr>';
endif;
    



    ?>

 </div>

           
            <?php// echo the_content_limit(30) ?>
            
           <p class="date-article text-right mb-1">
                <?php the_date()?>
            </p>
            <p class="tags">
                <?php echo affiche_taxonomie_links(get_the_ID(),array('post_tag'),'tags','');?>
            </p>

        </div>
        <!-- .entry-content -->

    </article>
    <div class="dotted-bottom mt-auto"></div>
    <!-- #post-## -->
</div>