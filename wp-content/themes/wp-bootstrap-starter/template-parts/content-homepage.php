<div class="content-fluid backgrounfullwith-light py-5" >

    <div class="container">
        <div class="row">
            <div class="col-12 col-md-8 pl-md-0 pr-md-4">
                <?php

                echo do_shortcode( '[smartslider3 slider=6]' );
                ?>
                <div class="w100 text-center">
                   
                </div>
            </div>
            <div class="col-12 col-md-4 mt-3 pl-md-5 border border-top-0 border-right-0 border-bottom-0 border-blue">
                <div class="widget-ressources">
                    <img src="/wp-content/uploads/2018/07/ressources-logo.svg" class="img-titre mb-2" alt="Ressources">

                    <?php 
              echo get_last_ressources('',3,false,'widget','',false,false,'','',true);
              ?>
                </div>
 
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-8 pl-md-0">
   
                <div class="w100 text-center">
                    <a href="/ressources/" class="hvr-sweep-to-right button-primary mt-3">Toutes les actualités  <i class="fal fa-angle-right" ></i> </a>
                </div>
            </div>
            <div class="col-12 col-md-4 pl-md-5 border border-top-0 border-right-0 border-bottom-0 border-blue">
                <a href="/ressources/" class="hvr-sweep-to-right button-primary mt-3">Toutes les ressources  <i class="fal fa-angle-right" ></i></a>
            </div>
        </div>
    </div>
</div>
<div class="content-fluid backgrounfullwith-primary entrezcommunautee_home">
    <div class="container">
                <div class="col-12 mb-4">
            <div class="triangle secondary"></div>

        </div>
        <div class="row">
            <div class="col-12">
                <h2 class="text-center h2reveal" data-sr="enter top">Entrez dans la #commun<span style="color:#2A3867">eau</span>té</h2>
            </div>
            
        </div>
       
        <div class="row">
            <div class="col-12 col-md-6 d-flex flex-column">
                 <p class="headline reveal text-justify pr-4" data-sr="enter top"><?php echo get_field('texte_cartouche_communaute') ?></p>
                <a href="#" class="plusbig hvr-sweep-to-right reveal align-self-start mt-auto" data-sr="enter bottom">En savoir plus </a>
            </div>
            <div class="col-12 col-md-6">
               <div class="row"> 
                <div class="col-12 col-md-8 d-flex flex-column">
                <img src="wp-content/uploads/2018/07/picto-reseau-aneb.svg" data-sr="enter center" class="picto-reseau align-self-end">
                </div>
                <div class="col-12 col-md-4 d-flex flex-column">
                <a href="#" class="adhererbig hvr-sweep-to-right reveal mt-auto align-self-start" data-sr="enter top">Adherer</a>
                </div>
                </div>
            </div>
        </div>


</div>
</div>
<div class="container">
    <div class="row">
        <div class="col-4">
            <div class="triangle reveal  d-none d-md-block " ></div>

        </div>
        <div class="col-4">
            <div class="triangle reveal"></div>

        </div>
        <div class="col-4">
            <div class="triangle reveal d-none d-md-block " ></div>

        </div>
    </div>
    
   
    
 <div class="row">
    
        <div class="col-12 col-md-4 cartouches-rubrique my-4" id="home-rub-1"> 
            <a href="<?php  echo get_field('lien_cartouche_1') ?>" class="hvr-grow">
                    <div class="logo-rubrique mx-auto mb-3  reveal">
                    <img src="<?php  echo get_field('image_cartouche_1') ?>" class="d-block" alt="<?php  echo get_field('alt_image_cartouche_1') ?>" />
                    </div>
                    <div class="reveal text-center">
                    <?php  echo get_field('texte_cartouche_1') ?>
                    </div>
              </a>
        </div>   
    
     
        <div class="col-12 col-md-4 cartouches-rubrique my-4" id="home-rub-2">
            <a href="<?php  echo get_field('lien_cartouche_2') ?>" class="hvr-grow">
                    <div class="logo-rubrique mx-auto mb-3  reveal">
                    <img src="<?php  echo get_field('image_cartouche_2') ?>" class="d-block" alt="<?php  echo get_field('alt_image_cartouche_2') ?>" />               
                    </div>
                    <div class="reveal text-center">
                    <?php  echo get_field('texte_cartouche_2') ?>
                    </div>
            </a>
        </div>   
     
            <div class="col-12 col-md-4 cartouches-rubrique my-4" id="home-rub-3">
            <a href="<?php  echo get_field('lien_cartouche_3') ?>" class="hvr-grow">
                    <div class="logo-rubrique mx-auto mb-3  reveal">
                    <img src="<?php  echo get_field('image_cartouche_3') ?>" class="d-block" alt="<?php  echo get_field('alt_image_cartouche_3') ?>" />               
                    </div>
                    <div class="reveal text-center">
                    <?php  echo get_field('texte_cartouche_3') ?>
                    </div>
            </a>
        </div>   
    </div>
    
</div>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="entry-content">
        <?php
        the_content();

        ?>
    </div>


</article> <!-- #post-## -->

</div> <!-- .row -->
</div> <!-- .container -->

<script src="https://unpkg.com/scrollreveal/dist/scrollreveal.min.js"></script>

<script language="javascript">

 (function(){

        var config = {
          enter: 'top',
          wait: '0.5s',
          viewFactor : 0.15,
          duration   : 800,
          distance   : "80px",
          scale      : 0.8,
        }

        window.sr = new ScrollReveal(config)
      })()

sr.reveal('.h2reveal');
sr.reveal('.reveal');

</script>