

</div><!-- #content dans header -->    
<div class="container-fluid  mt-5 ">
    <div class="row">
<div class="w-100">
         <img src="/wp-content/themes/imgs/footer-vague-large.svg" class="footer-vague img-fluid" />
        </div>
    </div>
</div>
    <?php get_template_part( 'footer-widget' ); ?>
	<footer id="colophon" class="site-footer h-100" role="contentinfo">
		<div class="container pt-3 pb-3">
            <div class="site-info">
                &copy; <?php echo date('Y'); ?> <?php echo '<a href="'.home_url().'">'.get_bloginfo('name').'</a>'; ?>
                <span class="sep"> | </span> ANEB
            </div><!-- close .site-info -->
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->
 <button onclick="topFunction()" id="toTop" title="remonter" class="ombre-bottom"><i class="far fa-arrow-to-top"></i></button> 
<?php wp_footer(); ?>

<script type="text/javascript">
<?php if( get_the_ID()==404){ // archives actualités ?>
        jQuery('#datepicker_in').datepicker({
        format: "mm/yyyy",
        startView: 2,
        minViewMode: 1,
        maxViewMode: 2,
        endDate:'-3m', /* on bloque la selection à - 3 mois */
        todayBtn: false,
        language: "fr",
        autoclose: true,
        toggleActive: true,

    });
        jQuery('#datepicker_out').datepicker({
        format: "mm/yyyy",
        startView: 2,
        minViewMode: 1,
        maxViewMode: 2,
        endDate:'-3m', /* on bloque la selection à - 3 mois */
        todayBtn: false,
        language: "fr",
        autoclose: true,
        toggleActive: true
    });
     
       jQuery("#init-filter").click(function (){
           jQuery("#rubrique,#categorie,#thematique,#motcle,#datepicker_in,#datepicker_out").val('');
           jQuery("#facet-filter").submit();                       
       });
    
<?php }  
if( is_post_type_archive('ressource')){ // archives ressources ?>
        jQuery('#datepicker_year').datepicker({
        format: "yyyy",
        startView: 2,
        viewMode: "years", 
        minViewMode: "years",
        todayBtn: false,
        language: "fr",
        autoclose: true,
        toggleActive: true,

    });
     
       jQuery("#init-filter").click(function (){
           jQuery("#rubrique,#categorie,#description_geographique,#type_document,#genre_document,#editeur,#motcle,#datepicker_year").val('');
           jQuery("#facet-filter").submit();                       
       });
    
<?php } ?>
  jQuery(document).ready(function(){
	
	  jQuery(window).scroll(function(){
		if (  jQuery(this).scrollTop() > 100) 
		{
			  jQuery('#toTop').fadeIn();
		} 
		else 
		{
			  jQuery('#toTop').fadeOut();
		}
	});
	  jQuery('#toTop').click(function(){
		  jQuery('html, body').animate({scrollTop : 0},700);
		return false;
	});
	
});
    </script> 


</body>
</html>
