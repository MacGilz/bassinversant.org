<?php

global $native_settings;
$admin_settings = new emailalertpro_commonclass;

if (isset($_POST['send_email_to_admin']) && $_POST['send_email_to_admin'] !='') {
    do_action('emailalertpro_send_email_to_admin', $_POST['admin_email_address']);
    echo "<script type='text/javascript'>
            jQuery(document).ready(function(){
                 jQuery('#myModal').modal('show');
            });
         </script>";
}
if (isset($_POST['submit'])) {

    $native_settings->set('category_list_not_included', @$_POST['category_to_alllist']);
    $native_settings->set('first_occurance_event', @$_POST['first_occurance_event']);


    if (isset($_POST['email_freq']) && @$_POST['email_freq'] != '') {
        $email_frequency = @$_POST['email_freq'];
        do_action('native_cancel_setup_crons');
        
		$admin_settings->emailalert_email_frequency($email_frequency);
		
        $native_settings->set('emailalert_email_frequency', @$_POST['email_freq']);
        do_action('EmailAlertPro_activation', array('freq' => $email_frequency));
    }
    if (isset($_POST['send_email_new_post_creation'])) {
        $native_settings->set('send_email_new_post_creation', @$_POST['send_email_new_post_creation']);
    }

    if (isset($_POST['send_most_popular_emails'])) {
        $native_settings->set('send_most_popular_emails', @$_POST['send_most_popular_emails']);
    }

    if (isset($_POST['sendername']) && @$_POST['sendername'] != '') {
        $native_settings->set('sendername', @$_POST['sendername']);
    }

    if (isset($_POST['post_count']) && @$_POST['post_count'] != '') {
        $post_count = $_POST['post_count'];
        $native_settings->set('post_count', @$_POST['post_count']);
    }
    if (isset($_POST['emailalert_send_most_viewd']) && @$_POST['emailalert_send_most_viewd'] != '') {
        $native_settings->set('emailalert_send_most_viewd', @$_POST['emailalert_send_most_viewd']);
    }
    if (isset($_POST['email_freq_post_type']) && @$_POST['email_freq_post_type'] != '') {
        $native_settings->set('email_freq_post_type', @$_POST['email_freq_post_type']);
    }



    if (isset($_POST['native_multi_select']) && @$_POST['native_multi_select'] != '') {
        $native_settings->set('native_multi_select', @$_POST['native_multi_select']);
    }


    echo "<script type='text/javascript'>
            jQuery(document).ready(function(){
                    jQuery.support.transition = false;
					jQuery('#myModal').modal('show');
            });
            </script>";
}

$post_count = $native_settings->get('post_count');
$sendername = $native_settings->get('sendername');
$first_occurance_event = $native_settings->get('first_occurance_event');
$emailalert_email_frequency = $native_settings->get('emailalert_email_frequency');
$native_multi_select = $native_settings->get('native_multi_select', 'no');
?>

<div class="container1">
    <div class="row-app">
        <div class="col-separator-first box"> 
            <!-- // END navbar -->
            <div id="row">
                <form method="post" action="" name="email_settings" enctype="multipart/form-data" class="">
                    <div class="preheading widget">
                        <div class="col-lg-9">
                            <div class="col-lg-12">
                                <input type="text" name="admin_email_address" placeholder="Enter email address" value="" style="float:right;line-height: 28px; max-width: 220px;">
                            </div>
                        </div>
                        <input type="submit" name="send_email_to_admin" class="button1   button-primary1 emailprobutton  btn btn-primary btn-sm strong" value="Send test"  />
                        <input type="submit" class="button1   button-primary1 emailprobutton  btn btn-primary btn-sm strong pull-right" name="submit" value="Save" />
                        <div class="clearfix"></div>
                    </div>
                    <div class="layout-app">
                        <div class="row-app">
                            <div class="row">
                                <div class="bg-gray"> 
                                    <!-- col -->
                                    <div class="col-md-4">
                                        <div class="widget">
                                            <div class="widget-body padding-none">
                                                <div class="widget-head height-auto ">
                                                    <div class="innerAll">
                                                        <h4 class="margin-none innerT half  pull-left"> <i class="fa fa-fw fa-shield text-primary"></i>Settings: </h4>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                </div>
                                                <div id="metrics">
                                                    <table style="font-size:smaller;color:#3695d5" class="metricsDrawHook">
                                                        <tbody>
                                                            <tr>
                                                                <td class=""><label class="control-label">Sent from:</label></td>
                                                                <td class=""><div class="">
                                                                        <input type="text" name="sendername" value="<?php echo $sendername; ?>"  />
                                                                    </div></td>
                                                            </tr>
                                                            <tr>
                                                                <td class=""><label class="control-label">Number of Posts</label></td>
                                                                <td class=""><div class="">
                                                                        <div class="">
                                                                            <input type="text" name="post_count" value="<?php echo $post_count; //$admin_settings->get_number_post_send(); ?>"  />
                                                                        </div>
                                                                    </div></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="widget">
                                            <div class="widget-head height-auto ">
                                                <div class="innerAll">
                                                    <h4 class="margin-none innerT half  pull-left"><i class="fa fa-fw fa-shield text-primary"></i>First event occurance:</h4>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>
                                            <div class="widget-body">
                                                <div id="metrics">
                                                    <link rel="stylesheet" type="text/css" href="<?php echo plugin_dir_url(__FILE__) ?>js/src/DateTimePicker.css" />
                                                    <script type="text/javascript" src="<?php echo plugin_dir_url(__FILE__) ?>js/src/DateTimePicker.js"></script> 
                                                    <script type="text/javascript">
                                                        jQuery(document).ready(function ()
                                                        {
                                                            jQuery("#dtBox").DateTimePicker({isPopup: false});
                                                        });
                                                    </script>
                                                    <label class="control-label">Custom Scheduler: </label>
                                                    <div class="fa-ul innerAll form-group">
                                                        <input type="text" data-field="datetime" readonly name="first_occurance_event" value="<?php print $first_occurance_event; ?>">
                                                        <div id="dtBox"></div>
                                                        <div id="abc"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="widget">
                                            <div class="widget-head height-auto ">
                                                <div class="innerAll">
                                                    <h4 class="margin-none innerT half  pull-left"><i class="fa fa-fw fa-shield text-primary"></i> Send emails :</h4>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>
                                            <div class="row  widget-body">
                                                <div class="col-app">
                                                    <div class="form-group new_post">
                                                        <div class="new_post">
                                                            <div class="col-sm-12 col-lg-8 col-lg-xl-8">
                                                                <label>
                                                                    <input name="email_freq" value="never"  <?php echo ($emailalert_email_frequency == 'never') ? 'checked' : ''; ?> type="radio">
                                                                    Straight away 
																</label>
                                                                <br>
                                                                <label>
                                                                    <input name="email_freq" value="hourly" <?php echo ($emailalert_email_frequency == 'hourly') ? 'checked' : ''; ?> type="radio">
                                                                    Hourly </label>
                                                                <br>
                                                                <label>
                                                                    <input name="email_freq" value="twicedaily" <?php echo ($emailalert_email_frequency == 'twicedaily') ? 'checked' : ''; ?> type="radio">
                                                                    Twice daily</label>
                                                                <br>
                                                                <label>
                                                                    <input name="email_freq" value="daily" <?php echo ($emailalert_email_frequency == 'daily') ? 'checked' : ''; ?> type="radio">
                                                                    Once daily</label>
                                                                <br>
                                                                <label>
                                                                    <input name="email_freq" value="weekly" <?php echo ($emailalert_email_frequency == 'weekly') ? 'checked' : ''; ?> type="radio">
                                                                    Weekly</label>
                                                                <br />
                                                                <label>
                                                                    <input name="email_freq" value="twiceweekly" <?php echo ($emailalert_email_frequency == 'twiceweekly') ? 'checked' : ''; ?> type="radio">
                                                                    Two Weeks</label>
                                                                <br />
                                                                <label>
                                                                    <input name="email_freq" value="monthly" <?php echo ($emailalert_email_frequency == 'monthly') ? 'checked' : ''; ?> type="radio">
                                                                    Monthly</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php do_action('native_admin_content_control_c1'); ?>
                                    </div>

                                    <!-- // END col --> 
                                    <!-- col -->
                                    <div class="col-md-4">
										<!-- // END widget -->
                                        <div class="widget">
                                            <div class="widget-head height-auto ">
                                                <div class="innerAll">
                                                    <h4 class="margin-none innerT half  pull-left"><i class="fa fa-fw fa-shield text-primary"></i> Optimisation :</h4>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>
                                            <div class="widget-body">
                                                <div class="col-app">
                                                    <div class="form-group new_post">
                                                        <?php $checked = $native_settings->get('emailalert_send_most_viewd'); ?>
                                                        <ul>
                                                            <li>
                                                                <input id="most_commented" type="radio" value="most_commented" <?php print ($checked == 'most_commented') ? 'checked' : ''; ?>  name="emailalert_send_most_viewd"/>
                                                                <label for="most_commented">Most commented</label>
                                                            </li>
                                                            <li>
                                                                <input id="most_viewd" type="radio" value="most_viewd"    <?php print ($checked == 'most_viewd') ? 'checked' : ''; ?>  name="emailalert_send_most_viewd"    />
                                                                <label for="Most Viewed">Most viewed</label>
                                                            </li>
                                                            <li>
                                                                <input id="most_commented_viewed" type="radio" value="most_commented_viewed" <?php print ($checked == 'most_commented_viewed') ? 'checked' : ''; ?>  name="emailalert_send_most_viewd"/>
                                                                <label for="most_commented_viewed">Most commented  and most viewed</label>
                                                            </li>
                                                            <li>
                                                                <input id="all" type="radio" value="all" <?php print ($checked == 'all') ? 'checked' : ''; ?>  name="emailalert_send_most_viewd"/>
                                                                <label for="all">Most recent</label>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
										
                                        <div class="widget">
                                            <div class="widget-head height-auto ">
                                                <div class="innerAll">
                                                    <h4 class="margin-none innerT half  pull-left"> <i class="fa fa-fw fa-shield text-primary"></i>
													Select categories to exclude<span id="">&nbsp;&nbsp;&nbsp;&nbsp;<a target="_blank" class="button button-small" href="<?php echo admin_url('admin.php?page=nativeemailpro&tab=widget'); ?>"> Change Category Type</a></span></h4>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>
                                            <div class="widget-body">
												<?php echo $admin_settings->checkbox_selection_process();?> 
                                                <div class="col-app"> <?php echo $admin_settings->get_all_category_list('alllist'); ?> </div>
                                            </div>
                                        </div>
                                        

                                        <!-- // END widget --> 
                                    </div>
                                    <!-- // END col -->
                                    <?php do_action('native_admin_content_control_c2'); ?>
                                </div>
                                <!-- // END col --> 
                                <!-- col -->
                                <div class="col-md-4">
                                    <?php do_action('native_admin_content_control_c3'); ?>
                                </div>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>