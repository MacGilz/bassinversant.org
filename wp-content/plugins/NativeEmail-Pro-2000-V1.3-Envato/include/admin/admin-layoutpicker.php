<?php
global $native_settings;
$admin_settings 		 =  new emailalertpro_commonclass;
$emailalertpro_templates =  new emailalertpro_templates;

if(isset($_POST['submit']) && $_POST['submit'] != ''){
/*
	if(isset($_FILES['file']['name']) && $_FILES['file']['name'] !=''){
					$admin_settings->email_add_header_image($_FILES['file']);
	}
*/	
	if(	isset($_POST) && !empty($_POST)	){
			foreach($_POST as $meta_key => $meta_value):
				$meta_value	=	($meta_value == '')? '':$meta_value;
				$meta_value	=	stripslashes($meta_value);
				//print($meta_value.'<br/>');
						//$emailalertpro_templates->email_subscription_templates($meta_key , $meta_value);
						$native_settings->set($meta_key , $meta_value);
				endforeach;
	}
	
	echo "<script type='text/javascript'>
						jQuery(document).ready(function(){
								jQuery('#myModal').modal('show');
						});
						</script>";
						
}
	

?>


		<div class="inner_wrap">


<?php  $layout =  $native_settings->get('template_selection'); ?>
        
		<div class="container1 layout-picker">

<form  name="template" action="" method="post">


<div class="row-app">
<div class="col-separator-first box">
		
<!-- // END navbar -->
		<div class="preheading widget">
		  
			<span class="text-left bg-title h1 col-lg-9"><?php //echo "Selected layout $layout";?></span>			
		  
						<input type="submit" value="Save" name="submit" class="pull-right button-primary1 emailprobutton pull-right btn btn-primary btn-sm strong" />
					<div class="clearfix"></div>
			</div>
		
		
		<div class="bg-gray innerAll">
                <div class="row row-app">
                        <div class="col-separator col-separator-first box">
						<div class="bg-gray innerAll">
             <div class="email_template_select">	
             		 <input type="hidden" name="redirect" value="redirect" />
			<div class="outer_box row">	
		<div class="col-lg-12">	
				<div class="box col-lg-3">  
						<h4 class="innerAll bg-gray border-bottom margin-bottom-none">
							<div class="native">
								<label for="first"><h3>Layout 1</h3></label>
								<input type="radio" name="template_selection" value="1" id="first" 
							<?php echo ($layout == 1)?'checked':''; ?>>
							</div>
						</h4>
                     <div class="img_cover">
                     	 <img src="<?php echo EAPSITEURL;?>include/admin/templates/layout1-page.png" alt="layout1" />
                     </div>
                    
                </div>
                <div class="box col-lg-3">                    
                     <h4 class="innerAll bg-gray border-bottom margin-bottom-none">
													<div class="native">
													<label for="second"><h3>Layout 2</h3></label>
														 <input type="radio" name="template_selection" value="2" id="second"  <?php echo ($layout == 2)?'checked':''; ?>>
													</div>
						</h4>
					 
					 <div class="img_cover">
                         <img src="<?php echo EAPSITEURL;?>include/admin/templates/layout2-page.png" alt="layout2" />					
                     </div>
                   
                </div>
                <div class="box col-lg-3">                    
						<h4 class="innerAll bg-gray border-bottom margin-bottom-none">
													<div class="native">
													<label for="third"><h3>Layout 3</h3></label>
														 <input type="radio" name="template_selection" value="3" id="third"  <?php echo ($layout == 3)?'checked':''; ?>>
													</div>
						</h4>
                    	<div class="img_cover">
							<img src="<?php echo EAPSITEURL;?>include/admin/templates/layout3-page.png" alt="layout3" />
						</div>
                </div>
				
		</div>
		<div class="col-lg-12"> 
                <div class="box col-lg-3">                    
						<h4 class="innerAll bg-gray border-bottom margin-bottom-none">
													<div class="native">
													<label for="forth"><h3>Layout 4</h3></label>
														 <input type="radio" name="template_selection" value="4" id="forth"  <?php echo ($layout == 4)?'checked':''; ?>>
													</div>
						</h4>
                    <div class="img_cover">
                     	<img src="<?php echo EAPSITEURL;?>include/admin/templates/layout4-page.png" alt="layout4" />
                     </div>
                </div>
                <div class="box col-lg-3">                    
					<h4 class="innerAll bg-gray border-bottom margin-bottom-none">
													<div class="native">
													<label for="five"><h3>Layout 5</h3></label>
														 <input type="radio" name="template_selection" value="5" id="five"  <?php echo ($layout == 5)?'checked':''; ?>>
													</div>
						</h4>
                    <div class="img_cover">
						<img src="<?php echo EAPSITEURL;?>include/admin/templates/layout5-page.png" alt="layout5" />
                     </div>
                </div>
                <div class="box col-lg-3">                    
<h4 class="innerAll bg-gray border-bottom margin-bottom-none">
													<div class="native">
													<label for="six"><h3>Text only</h3></label>
														 <input type="radio" name="template_selection" value="Text only (default)" id="six"  <?php echo ($layout == 'Text only (default)')?'checked':''; ?>/>
													</div>
						</h4>
                    <div class="img_cover">
                     <!-- <img src="<?php echo EAPSITEURL;?>/include/admin/templates/layout6-page.png" alt="layout6" />-->
					 </div>
                </div>
		</div>
				<?php do_action('admin_screen_layout_section_row'); ?> 
			</div>
         </div>
	</div>		 
					 
				

				</div>
             </div>
		</div> 
		</div>      
				</div>
        
           </form>   
		</div>