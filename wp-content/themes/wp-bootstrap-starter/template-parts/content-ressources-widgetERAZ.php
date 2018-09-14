<?php /*?>HOME WIDGET<?php */?>
<div class="row">
<div class="d-flex flex-column col-12">
    <a href="<?php echo get_permalink()  ?>">
    <article id="post-<?php the_ID(); ?>" class="item-ressource ">

        <header class="entry-header">
            <?php the_title( '<h3 class="entry-title">', '</h3>' ); ?>
        </header>

            <div class="d-flex justify-content-between">
        <?php 
     $genre = '';
            if ( get_field( 'genre_de_document' ) ) {
                $getgenre = get_field( 'genre_de_document' );
                $genre = $getgenre->name . '. ';
            }
            echo '<div class="taxonomies">';
            echo  get_field( 'categories_ressources' ) . $genre . get_field( 'annee' );
            echo '</div>';
            

               $rubriques = get_field('rubriques' );
                
                echo '<div class="rubriques">';
                foreach ( $rubriques as $key => $value ) {
                    echo '<a href="/' . $value->slug . '/" class="rubrique px-1 mr-2 ' . $value->slug . '">' . $value->name . '</a>';
                }
                 echo '</div>';

?>
            </div>


<?php /*?>           <p class="date-article text-right mb-1">
                <?php the_date()?>
            </p>
<?php */?>
    </article>
        </a>
    <!-- #post-## -->
</div>
</div>