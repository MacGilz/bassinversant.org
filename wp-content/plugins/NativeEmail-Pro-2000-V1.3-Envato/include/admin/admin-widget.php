<?php 

	$admin_settings = new emailalertpro_commonclass;
global $native_settings;


if(isset($_POST['submit']) && $_POST['submit'] != '' && $_POST['tab'] == 'emailalert')
{
	
	$native_settings->set( 'native_selected_term_fashion' , $_POST['hara']);
	
	
	echo "<script type='text/javascript'>
			jQuery(document).ready(function(){
					jQuery('#myModal').modal('show');
			});
	</script>";
}


			
			$args = array('public' => true, '_builtin' => false);
			$output = 'objects'; 
			$operator = 'or'; 
			$post = get_post_types( $args, $output, $operator ); 
			$cats = get_taxonomies($args , $output , $operator);
			
			$select_post_type	=	$native_settings->get('native_selected_post_type');
			$select_term_type	=	$native_settings->get('native_selected_term_type');
			$fash = $native_settings->get('native_selected_term_fashion');
?>
<div class="container1">
	<form action="" method="post" enctype="multipart/form-data" name="basic-settins" class="form-horizontal">
	
			<div class="row-app">
<!-- // END navbar -->
			<div class="preheading widget">
				  <span class="text-left bg-title h1"></span>
					<input type="submit" class="button1   button-primary1 emailprobutton  btn btn-primary btn-sm strong pull-right" name="submit" value="Save" />
					<div class="clearfix"></div>
            </div>

<div class="innerLR1">
	<div class="row">
		<div class="col-md-4">
			<!-- Widget -->
			<!-- //Widget -->
			<!-- Widget -->
			
			<!-- Widget -->
			<div class="widget widget-body-white padding-none ">
				
				<div class="bg-gray">
						<h4 class="innerAll  border-top  border-bottom margin-bottom-none">Show hierarchy on front end widgets</h4>
					</div>
	
				<div class="innerAll">
					<div class="media half">					  
							<div class="col-sm-8 col-lg-8 col-lg-xl-8">				        	
									<label for="yes">Yes</label>
									<input type="radio" value="yes" id="yes" name="hara" <?php echo ($fash == 'yes')? 'checked="checked"': '';?>/> 
									
									<label for="no">No</label>
									<input type="radio" value="no" id="no" name="hara" <?php echo ($fash == 'no')? 'checked="checked"': '';?> />			
							</div>
					</div>		
               	</div>
			</div>
			
			
			<!-- //Widget -->
			<?php do_action('admin_screen_widget_section_first_coulmn'); ?> 
		</div>
		<!-- //End Col -->
		
		<div class="col-md-4">
			
			<?php do_action('admin_screen_widget_section_second_coulmn'); ?>
			<!-- //Widget -->
			<!-- Widget -->
			
		</div>
		<!-- //End Col -->
		
		<div class="col-md-4">
			
				<!-- //Widget -->
			<!-- //Widget -->
				<?php do_action('admin_screen_widget_section_third_coulmn'); ?>
		</div>
		<!-- //End Col -->
	</div>   
	<!-- End Row -->
</div>
		</div>
	<input type="hidden" name="tab" value="emailalert" />
	
</form>
</div>