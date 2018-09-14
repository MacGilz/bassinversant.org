
<div class="row">
        <div class="col-12">
            <?php echo the_breadcrumb();?>
        </div>
</div>
<article id="post-<?php the_ID(); ?>" <?php post_class('dotted-bottom'); ?>>

    <header class="entry-header">
        <?php
            the_title( '<span class="vaguepost"><img src="/wp-content/themes/imgs/vague.svg" /></span><h1 class="entry-title">', '</h1>' );

        if(get_field('evenement' )){
    echo '<div class="evenement mb-2"><p> <i class="fas fa-calendar-check mr-2"></i>'. affiche_date_event(get_field('date_de_debut'),get_field('date_fin')).'</p></div>';
};
 if ( 'post' === get_post_type() ): ?>
        <div class="entry-meta">
            <?php 
            if ( get_field( 'rubriques' ) ):
                  echo '<div class="mb-1">'.affiche_rubriques(get_field( 'rubriques' )).'</div>';
            endif;
            
            wp_bootstrap_starter_posted_on(); 
           
            if (count(get_field( 'thematiques' ))>0 ):
echo '<div class="thematiques mx-0 "> <strong><em>Thématiques : </em></strong>';
$thematiques = get_field('thematiques');
$i=1;
foreach ( $thematiques as $key => $value ) {
    if($i>1) echo '<span class="mx-1 sep"> | </span>';
    echo '<a class="thematique" href="'.get_term_link($value->slug,'thematiques').'" title="'.$value->name.'">'. $value->name .'</a>';

$i ++;
}
echo '</div>';
endif;
            

    ?>

        </div>
        <!-- .entry-meta -->
        <?php
        endif;
        ?>
    </header>
    <!-- .entry-header -->

    <div class="row">
         <div class="col-12 col-sm-8 col-md-9">
        <div class="entry-content text-justify">
            <?php
            if ( get_field( 'chapo' ) ) {
                echo '<div class="chapo" >' . get_field( 'chapo' ) . '</div>';
            }


            if ( has_post_thumbnail( $post->ID ) ):
                    $featured_img_url = get_the_post_thumbnail_url( get_the_ID(), 'full' );
                ?>
            <div class="post-thumbnail float-left">
                <a href="<?php echo $featured_img_url?>">
                    <?php the_post_thumbnail(array(380,380),['class' => 'img-fluid img-thumbnail mr-xs-0 mr-sm-0 mr-md-4']);?>
                    
                    <?php /*?> <p class="clearfloat text-center mt-2">
                        <?php the_title_attribute(); ?>
                    </p><?php */?>
                </a>
            </div>
            <?php endif; 
    
            the_content();
           


		?>
            </div>
<div class="row">
    <div class="col-12 mt-2">

        <footer class="entry-footer">
            <?php wp_bootstrap_starter_entry_footer(); ?>
        </footer>
    </div>
</div>

        </div>
        <!-- .entry-content -->

<aside id="secondary" class="sidebar-right widget-area col-12 col-sm-4 col-md-3" role="complementary" >
    
 <?php if ( have_rows( 'fichiers_joints' ) ) {
    //titre pluriel ou singulier ?
    $fields = get_field_object('fichiers_joints');
	$count = (count($fields['value']));
    $count==1 ? $titre='Fichier joint' : $titre='Fichiers joints' ;

    echo '<div class="fichiers-joints">
          <h3 class="mt-4"><i class="fas fa-file-download mr-2"></i>'.$titre.' </h3>
          <ul class="items">
          ';
          
        while ( have_rows( 'fichiers_joints' ) ) {
            the_row();
            $file = get_sub_field( 'fichiers' );
            // ID, title , filename, filesize, url,link (page du media), alt, autor, description, date, modified, mime_type, subtype, icon
            echo '<li><a href="'.$file['url'].'">'.clean_fichier_title($file['title']).'</a></li>';
        }
    
    echo '</ul>
    </div>';
}
?>
<?php get_sidebar(); ?>
</aside>
    </div>


</article> <!-- #post-## -->

