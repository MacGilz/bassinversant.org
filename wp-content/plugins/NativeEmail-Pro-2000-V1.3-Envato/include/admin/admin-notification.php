<?php
global $native_settings;

$emailalertpro_templates = new emailalertpro_templates;

if (isset($_POST['submit']) && !empty($_POST['submit'])) {
    if (!isset($_POST['emailalertpro_get_notification_status']))

    
        $nstatus = (isset($_POST['emailalertpro_get_notification_status']) ? $_POST['emailalertpro_get_notification_status'] : 'no');

    $native_settings->set('emailalertpro_get_notification_status', $nstatus);
    foreach ($_POST as $meta_key => $meta_value):
        $native_settings->set($meta_key, $meta_value);
        //$emailalertpro_templates->email_subscription_templates($meta_key , $meta_value);
    endforeach;

	
	$native_settings->set( 'native_selected_term_type' , $_POST['native_selected_term_type']);
	$native_settings->set( 'native_selected_post_type' , $_POST['native_selected_post_type']);
	$native_settings->set( 'category_to_include' , @$_POST['category_to_include']);
	$native_settings->set( 'category_to_exclude' , @$_POST['category_to_exclude']);
	
    echo "<script type='text/javascript'>
						jQuery(document).ready(function(){
								jQuery('#myModal').modal('show');
						});
						</script>";
}

$emailalertpro_get_notification_status = $native_settings->get('emailalertpro_get_notification_status');
$emailalertpro_Subject_Link = trim(stripslashes($native_settings->get('emailalertpro_Subject_Link')));
$email_confirm_email = trim(stripslashes($native_settings->get('email_confirm_email')));
$native_create_log = $native_settings->get('native_create_log', 'yes');
$nativeemail_per_user_send = $native_settings->get('nativeemail_per_user_send', 100);
$nativeemail_time_per_user_send = $native_settings->get('nativeemail_time_per_user_send', 3);

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
    <form action="" method="post" enctype="multipart/form-data" >
        <div class="row-app">
            <div class="col-separator-first box">
                <!-- // END navbar -->

                <div class="preheading widget">
                    
                    <span class="text-left bg-title h1"></span>
                    
                    <input type="submit" value="Save"  name="submit" class="pull-right button-primary1 emailprobutton pull-right btn btn-primary btn-sm strong"/>
                    <div class="clearfix"></div>
                </div>

                <div class="innerLR1 layout-app notification">

				<div class="row">	
                    <div class="col-md-4" >
                        <div class="widget" style="margin:0 auto 4px;">
                            <div class="widget-head height-auto ">
                                <div class="innerAll">
                                    <h4 class="margin-none  half  pull-left">
                                        <i class="fa fa-fw fa-shield text-primary"></i>
										<?php _e('Notification email', 'nativeemail'); ?>
                                    </h4>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="row  widget-body">
                                <div class="col-app">
                                    <div class="form-group new_post">
                                        <div class="new_post">
                                            <div class="col-sm-12 col-lg-12 col-lg-xl-12">
                                                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8">
                                                    <label><?php _e('Yes', 'nativeemail'); ?></label>
                                                    <input type="radio" name="emailalertpro_get_notification_status" value="yes" <?php echo ($emailalertpro_get_notification_status == 'yes') ? 'checked' : ''; ?>>
                                                    <label><?php _e('No', 'nativeemail'); ?></label>
                                                    <input type="radio" name="emailalertpro_get_notification_status" value="no"  <?php echo ($emailalertpro_get_notification_status == 'no') ? 'checked' : ''; ?>>
                                                </div>
                                            </div>
                                        </div>		

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white innerAll inner-2x ">
                            <div class="row">
                                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <label for="subject" class="control-label">
<?php _e('Subject text', 'nativeemail'); ?>
                                    </label>
                                </div>
                                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                    <div class="input-group">
                                        <input type="text" size="25" value="<?php print $emailalertpro_Subject_Link; ?>" name="emailalertpro_Subject_Link">
                                    </div>
                                </div>
                            </div>

                            <div class="clearfix"></div>

                        </div>
                        <div class="innerAll inner-2x widget" style="float: left; width: 100%; border: 0px none;">
                            <textarea name="email_confirm_email"  class="notebook border-none form-control padding-none" rows="8" placeholder="Write your message here..."><?php print $email_confirm_email; ?></textarea>
                            <div class="clearfix"></div>
                        </div>
<?php do_action('admin_screen_notification_section_first_coulmn'); ?> 
                    </div>

                    <div class="col-md-4">
                        <div class="widget">
                            <div class="widget-head height-auto ">
                                <div class="innerAll">
                                    <h4 class="margin-none  half  pull-left">
                                        <i class="fa fa-fw fa-shield text-primary"></i>
										<?php _e('Users per send', 'nativeemail'); ?>
                                    </h4>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="row  widget-body">
                                <div class="col-app">
                                    <div class="form-group new_post">
                                        <div class="new_post">
                                            <div class="col-sm-12 col-lg-12 col-lg-xl-12">
                                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                                    <input type="text" name="nativeemail_per_user_send" value="<?php echo $nativeemail_per_user_send; ?>" />
                                                </div>
                                            </div>
                                        </div>		

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="widget">
                            <div class="widget-head height-auto ">
                                <div class="innerAll">
                                    <h4 class="margin-none half  pull-left">
                                        <i class="fa fa-fw fa-shield text-primary"></i>
										<?php _e('Process time (in minutes)', 'nativeemail'); ?>
                                    </h4>

                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="row  widget-body">
                                <div class="col-app">
                                    <div class="form-group new_post">
                                        <div class="new_post">
                                            <div class="col-sm-12 col-lg-12 col-lg-xl-12">
                                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                                     <input type="text" name="nativeemail_time_per_user_send" value="<?php echo $nativeemail_time_per_user_send; ?>" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
						<!-- Widget -->
							<div class="widget border-top-none">
								<div class="bg-gray">
									<h4 class="innerAll  border-top  border-bottom margin-bottom-none">
										Categories to exclude in subscription display list
									</h4>
								</div>
								
								<div class="innerAll">
									<div class="media half">
										<div class="category_to_exclude">
											<div class="col-sm-12 col-lg-8 col-lg-xl-8">
												<div class="category_to_exclude">
													<?php echo $admin_settings->checkbox_selection_process();?> 
													<?php echo $admin_settings->get_all_category_list('exclude'); ?>
												</div> 
											</div>
										</div>
									
									</div>
								</div>
							</div>
							
							<?php do_action('admin_screen_notification_section_second_coulmn'); ?> 
                    </div>

					<div class="col-md-4">
						<div class="widget">
							<div class="widget-body padding-none">
									<h4 class="innerAll bg-gray border-bottom margin-bottom-none"> <i class="fa fa-fw fa-shield text-primary"></i>Post type</h4>
									<div class="row  widget-body">
									<div class="col-app">
										<div class="form-group new_post">
											<div class="new_post">
												<div class="col-sm-12 col-lg-12 col-lg-xl-12">
													<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
														<?php
															echo '<select name="native_selected_post_type" id="select2_2" class="">';
															foreach ( $post  as $key => $cat ) {
																$selected  = '';
																if($cat->name == $select_post_type) $selected = 'selected="selected"';
																	echo '<option value="'.$cat->name.'" '.$selected.'>' . $cat->label  . '</option>';
																}
															echo '</select>';
														?>	
													</div>
												</div>
											</div>		

										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- //Widget -->
						<!-- Widget -->
						<div class="widget">
							<div class="widget-body padding-none">
								<h4 class="innerAll bg-gray border-bottom margin-bottom-none">Category type</h4>						
									<div class="innerAll">	
									<div class="">
											<?php
											
												echo '<select name="native_selected_term_type" id="select2_1" class="">';
												foreach ( $cats  as $key => $cat ) {
													$selected  = '';
													if($cat->name == $select_term_type) $selected = 'selected="selected"';
												   echo '<option value="'.$cat->name.'" '.$selected.'>' . $cat->label  . '</option>';
												}
												echo '</select>';
												
												
											?>
										 </div>
									</div>	 
							</div>
						</div>
						<!-- Widget	 -->
						<div class="widget widget-body-white padding-none ">
							
							<div class="bg-gray">
									<h4 class="innerAll  border-top  border-bottom margin-bottom-none">Categories to include in subscription display list</h4>
								</div>
				
							<div class="innerAll">
								<div class="media half">
								 <div class="category_to_include">
									<!--<strong>Category to include will take priority from exclude</strong>-->
									<div class="col-sm-12 col-lg-8 col-lg-xl-8">
										<?php echo $admin_settings->checkbox_selection_process();?> 
										<?php echo $admin_settings->get_all_category_list('include'); ?>
									</div>
								</div>
								</div>		
							</div>
						</div>
						<?php do_action('admin_screen_notification_section_third_coulmn'); ?> 
					</div>
                </div>
				
				</div>
				
				<div class="row">
                                                             <!----   
																<div class="col-lg-10">
                                                                    <table class="message-shortcode">

                                                                        <tr>
                                                                            <td></td>
                                                                            <td><h4><?php _e('Message shortcodes', 'nativeemail'); ?></h4></td>
                                                                            <td></td>
                                                                        </tr>

                                                                        <tr>
<?php
echo "<td><dt><b>[SUBSCRIBEREMAIL]</b></dt><dd>";
_e('Susciber email', 'nativeemail');
echo "</dd></td>";
echo "<td><dt><b>[BLOGNAME]</b></dt><dd>" . get_option('blogname') . "</dd></td>";
echo "<td><dt><b>[BLOGLINK]</b></dt><dd>" . get_option('home') . "</dd></td>";
?>
                                                                        </tr>
                                                                    </table>
                                                                </div>

                                                                <div class="col-lg-9">
                                                                </div>  
																--->
                </div>
			</div>
         </div>                                                 
	</form>
</div>
<style type="text/css">
.message-shortcode tr td {
	padding: 0 0 0 66px;
	text-align: center;
}
</style>