<?php
/**
 * 	all cron jobs are applyed here
 **/ 
add_action('EmailAlertProCron', 'EmailAlertProCron_timely_event');
add_action('set_email_frequency_cron', 'set_email_frequency_cron');
add_action('EmailAlertPro_activation', 'EmailAlertPro_activation');
add_filter('cron_schedules', 'jsf_cron_add_weekly' , 100);
add_action('admin_head', 'add_inter_explorer_style');
add_action('EmailAlertProCron_cron_parts_sendmails', 'EmailAlertProCron_cron_parts_sendmails', 10, 2);
add_action('native_cancel_setup_crons','native_cancel_setup_crons');

function set_email_frequency_cron($args) {

    $event_to_occur = strtotime($_POST['first_occurance_event']);
    $event_to_occur = ( time() > $event_to_occur) ? time() : $event_to_occur;
    update_option('nativeemail_first_occurance_event', $_POST['first_occurance_event']);
	
    wp_clear_scheduled_hook('EmailAlertProCron', array('freq' => 'hourly'));
    wp_clear_scheduled_hook('EmailAlertProCron', array('freq' => 'daily'));
    wp_clear_scheduled_hook('EmailAlertProCron', array('freq' => 'twicedaily'));

    if ($args['freq'] == 'never') {
        wp_clear_scheduled_hook('EmailAlertProCron', array('freq' => 'never', 'freq' => 'hourly', 'freq' => 'daily', 'freq' => 'twicedaily'));
    } else {
		wp_clear_scheduled_hook('EmailAlertProCron', array('freq' => 'never', 'freq' => 'hourly', 'freq' => 'daily', 'freq' => 'twicedaily'));

        $timestamp = $event_to_occur;
        $recurrence = $args['freq'];
        $hook = 'EmailAlertProCron';
        $nargs = array('freq' => $recurrence);
        if ($recurrence != 'never' && $recurrence != '')
            wp_schedule_event($timestamp, $recurrence, $hook, array());
    }
}

function EmailAlertProCron_timely_event() {
    do_action("emailalertpro_send_email_alert");
}

/* 	MAIN FUNCTION TO SEND EMAIL USING CRON  EMAIL */

function emailalertpro_call_to_send_email() {
    global $native_settings;
    $empce = new emailalertpro_core_email;
    $meta_value = $native_settings->get('emailalert_email_frequency');

    if ($meta_value == "never" or $meta_value == "") {
        return false;
    } else {
        /***activate cron parts here ***/
        do_action('nativeemail_divide_cron_parts');
        return true;
    }
}


function EmailAlertProCron_cron_parts_sendmails( $start = '0', $end = 2  , $filters = array()) {

    global $native_settings;
	
	$start = (isset($start) && $start == '')?0:$start;
	
    $native_user = new native_users;
    $eace = new emailalertpro_core_email;
	$native_user->filters = $filters;

    $recipients_array = $native_user->get_active_subscribers_paginated($start, $end);
	
    $sender_email = $native_settings->get('sendername');
    $headers[] = "From: " . $sender_email . "\r\n";
    $subject = stripslashes($native_settings->get('emailalertpro_template_email_subject'));
	
if(count($recipients_array) > 0){

    foreach ($recipients_array as $index => $receiver) {
	
	
        $native_settings->native_user_id = $user_id = $receiver['id'];
        $recipient = $receiver['email'];
		
        $sent_post_ids = ($receiver['sent_post_ids'] != '' && !is_array($receiver['sent_post_ids'])) ? $receiver['sent_post_ids'] : '';
        $extra['not_ids'] = $sent_post_ids;

        $post_objects = $eace->emailalert_get_post_objects_for_user($user_id, $extra, $receiver);
        $email_content = email_alert_pro_send_final_email(null, $post_objects, $user_id);
        $unsubscription_link = $eace->unsubscription_link_for_user($receiver);
        $changeprefrence_link = $eace->changeprefrence_link($receiver);

        $order = array('{EMAIL_ALERT_CURRENT_USER_EMAIL}', '{EMAIL_ALERT_UNSUBSCRIPTION_LINK}', '{unsubscribe_link}', '{changeprefrence_link}');
        $replace = array($recipient, $unsubscription_link, $unsubscription_link, $changeprefrence_link);

        $email_content = str_replace($order, $replace, $email_content);
		
        if (!is_array($email_content) && $email_content != '') {
            emailalertpro_send_email_to_user($recipient, $subject, $email_content, $headers);
        }
    }
	
    do_action('build_sent_post_email_query');
}   
   //build_sent_post_email_query();     
    return true;
}

function EmailAlertPro_activation($args) {
    
	global $emailalertpro;
    wp_clear_scheduled_hook('EmailAlertProCron');
    
	$date = new DateTime($_POST['first_occurance_event']);
	$timstamp = $date->getTimestamp();
	$timestamp = (isset($timstamp) && $timstamp > 0)?$timstamp:time();
	
	//$timestamp = time();
    
	$recurrence = $args['freq'];
    $hook = 'EmailAlertProCron';
    $nargs = array('freq' => $recurrence);
   
	
	
	if ($recurrence != 'never'){
			native_cancel_setup_crons();
			$data = wp_schedule_event($timestamp, $recurrence, $hook, $nargs);
		}
		
}


function jsf_cron_add_weekly($schedules) {
    // Adds once weekly to the existing schedules.
    $schedules['monthly'] = array(
        'interval' => 2592000,
        'display' => __('Once Monthly')
    );
    $schedules['twiceweekly'] = array(
        'interval' => 1209600,
        'display' => __('Twice Weekly')
    );
	$schedules['weekly'] = array(
        'interval' => 604800,
        'display' => __('Once Weekly')
    );
    return $schedules;
}



function native_cancel_setup_crons() {
	
    $crons = _get_cron_array();
    
	
	$tempMainArray  = $crons;
	foreach( $crons as $mdfivetime => $cron){
				//$tempcron = $cron;	
				foreach($cron as $key => $event){
					if($key == 'EmailAlertProCron'){
						unset($cron[$key]);
					}
				}
				if(count($cron) > 0){
					$tempMainArray[$mdfivetime] = $cron;	
				}
				else{
					unset($tempMainArray[$mdfivetime]);
				}
				
				//$cron = $tempcron;
    }
        _set_cron_array($tempMainArray);
	
}

function add_inter_explorer_style() {
    ?>
    <!--[if IE]>
    <style type="text/css">
           .container
    {
       display:table;
       width: 100%;
    }

    .row
    {
      
     display: table-row;
    }
    .col-md-4 , .col-lg-4 ,.col-md-8 , .col-lg-8
    { 
       display: table-cell;
    }
                                   
                                   
    </style>

    <![endif]-->
    <!--[if lt IE 9]>
    <![endif]-->
    <?php
}

$crons = new Manage_Cron_Users;


class Manage_Cron_Users {

    private $users;
    private $native;
	public $filters;

    function __construct() {
        $this->users = new native_users;
        $this->native = new Native_All_Settings;
        add_action('nativeemail_divide_cron_parts', array($this, 'nativeemail_divide_cron_parts'));
		
    }

	
	
    function nativeemail_divide_cron_parts() {
		$this->users->filters = $this->filters;
        $total_no_users = $this->users->get_active_subscribers_count();
        $user_per_tern = $this->native->get('nativeemail_per_user_send', 200);
        $schedule_tern = $this->native->get('emailalert_email_frequency', 'daily');
        $time = time();
		if ($total_no_users > $user_per_tern) {
		
            $terns = ceil($total_no_users / $user_per_tern);
			// process users
			
            for( $i = 0; $i <= $terns; $i++ ) {
			
                $start = $i * $user_per_tern;
				//print "showing from $start to $user_per_tern<br/>";
				
                $time = $time + 3 * 60;
				// run only once 
				wp_clear_scheduled_hook('EmailAlertProCron_cron_parts_sendmails', array('start' => $start, 'end' => $user_per_tern , 'filters' => $this->filters));
                wp_schedule_single_event($time , 'EmailAlertProCron_cron_parts_sendmails', array('start' => $start, 'end' => $user_per_tern , 'filters' => $this->filters ));
            
			}		
        }
		else{
				$start = 0;
                $time = $time + 1 * 60;
				// run only once 
				wp_clear_scheduled_hook('EmailAlertProCron_cron_parts_sendmails', array('start' => $start, 'end' => $user_per_tern , 'filters' => $this->filters));
                wp_schedule_single_event($time , 'EmailAlertProCron_cron_parts_sendmails', array('start' => $start, 'end' => $user_per_tern , 'filters' => $this->filters ));
		}
    }

}

?>