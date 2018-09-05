
<div class="d-flex flex-column col-12 col-md-4 items-ressources">
    <article id="post-<?php the_ID(); ?>" <?php post_class('dotted-bottom'); ?>>
        <?php
        $enable_vc = get_post_meta( get_the_ID(), '_wpb_vc_js_status', true );
        if ( !$enable_vc ) {
            ?>
        <header class="entry-header">
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
                    echo '<a href="/' . $value->slug . '/" class="rubrique p-1 ml-2 ' . $value->slug . '">' . $value->name . '</a>';
                }
                 echo '</div>';
             
            endif;
?>
            </div>

<div>
 <?php if (count(get_field( 'categorie' ))>0 ):
echo '<div class="categories-ressources mt-1 mb-2 mx-0 align-self-end">';
$categorie = get_field('categorie');

$i=1;    
foreach ($categorie  as $key => $value ) {
            
    $catinfos = get_term_by( 'id', $value, 'categories_ressources' );
    if($i>1) echo '<span class="mx-1 sep"> | </span>';
    echo '<a class="categorie" href="'.get_term_link($catinfos->term_id,'categories_ressources').'" title="'.$catinfos->name.'">'. $catinfos->name .'</a>';

$i ++;
}
echo '</div>';
else : echo '<hr>';
endif;


    ?>

 </div>

           
            <?php echo the_content_limit(30) ?>
           <p class="date-article text-right mb-1">
                <?php the_date()?>
            </p>
            <?php
            
            wp_link_pages( array(
                'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'wp-bootstrap-starter' ),
                'after' => '</div>',
            ) );
            ?>
            <p class="tags">
                <?php echo affiche_taxonomie_links(get_the_ID(),array('post_tag'),'tags','');?>
            </p>

        </div>
        <!-- .entry-content -->

    </article>
    <!-- #post-## -->
</div>