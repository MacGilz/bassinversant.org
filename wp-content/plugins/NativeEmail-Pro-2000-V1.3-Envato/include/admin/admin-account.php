<div class="containe">
    <div class="row-app">
        <div class="col-separator-first box">
            <div class="preheading widget">
                <span class="text-left bg-title h3"></span>
            </div>
            <div class="innerLR1">
                <div class="row">
                    <div class="col-md-4">
                        <div class="widget">
                            <div class="widget-body padding-none">
                                <h4 class="innerAll bg-gray border-bottom margin-bottom-none">User info</h4>
                                <div class="innerAll native-email-admin-acount">	
                                    <i class="fa fa-5x icon-documents-line text-muted pull-right"></i>
                                    <div class="row">
                                        <?php
                                        global $current_user;
                                        wp_get_current_user();
                                        $name = ($current_user->display_name == '') ? $current_user->display_name : $current_user->user_login;
                                        ?>
                                        <div class="col-lg-12">	<label>Name :</label><?php print $name; ?></div>
                                        <div class="col-lg-12">	
                                            <label>Email :</label><?php print $current_user->user_email; ?></div>
                                        <div class="col-lg-12">	<label>Account	:</label>Unlimited</div>
                                        <div class="col-lg-12">
                                            <label>Subscriber limit :</label> Unlimited
                                        </div>

                                        <div class="col-lg-12">	<label>Licence: </label>12 Months</div>
                                        <div class="col-lg-12">	<label>Licence key: </label><?php echo get_option(nativeemail_protect_code::$protectionKey , ''); ?></div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php do_action('admin_screen_account_section_first_coulmn'); ?> 
                    </div>

                    <div class="col-md-4">
                        <?php do_action('admin_screen_account_section_second_coulmn'); ?> 	
                    </div>

                    <div class="col-md-4">
							<div class="row">
								<div style="visibility: visible;" class="col-lg-10 bg-gray box-generic animated fadeInUp">
									<div class="innerAll text-center">
										<div class="innerAll">
											<div class="glyphicons glyphicon-xlarge glyphicon-top circle_question_mark">
												<i></i>
												<h4>Have a question?</h4>
												<p>Get your answer.</p>
												<p><a target="_blank" href="http://nativeplugins.com/submit-a-ticket">Click here</a>		

												</p></div>
										</div>
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="widget col-lg-10 advert-widget-cover">
									<div class="row innerAll text-center glyphicon-xlarge glyphicon-top circle_question_mark">
											<h4 class="innerAll margin-padding-none extension-heading">We've made some premium</h4>
											<h4 class="extension-label"><span class="advert-color-text">extensions</span>!</h4>
											<br/>
											<h6 class="extension-name-label"><span>Like Post Subscription Widget.</span></h6>
											<div class="innerAll">
														<img src="<?php echo EAPSITEURL;?>/include/images/advert-image.png"  style="width: 250px;"  alt="native-advert-image" />
											</div>
											<h4>Check them out <a href="http://nativeemail.com/shop/" target="_blank" class="advert-color-text"> here.</a></h4>		
									</div>
								</div>
							</div>
                        <?php do_action('admin_screen_account_section_third_coulmn'); ?> 
                    </div>	

				
                </div>		
            </div>   
            <!-- End Row -->

        </div>

    </div>
</div>