<?php

	add_action('emailalertpro_send_email_new_post_creation', 'call_emailalertpro_send_email_new_post_creation');
	add_action('build_sent_post_email_query', 'build_sent_post_email_query');
	

	function call_emailalertpro_send_email_new_post_creation($post, $post_id) {
		
		die("call_emailalertpro_send_email_new_post_creation");
		
		try {
				emailalertpro_send_email_new_post_creation($post, $post_id);
		} catch (Exception $ex) {
				print($ex->getMessage());
		}
	}

	
		
	function emailalertpro_send_email_new_post_creation($post, $post_id){
		die("emailalertpro_send_email_new_post_creation");	
		global $native_settings;

		/**
		 * * intialize object classes
		 */
		$Core = new emailalertpro_core_email;
		$native_users = new native_users;
		$native_settings->sql_query = array();
		$extra['not_ids'] = '';

		$process_users = isset($_POST['native_post_size']) ? $_POST['native_post_size'] : 100; // array size per tern
		$startIndex = isset($_POST['native_post_edit']) ? $_POST['native_post_edit'] : 0;
		$sender_email = $native_settings->get('sendername');
		$subject = $native_settings->get('emailalertpro_template_email_subject');
		$headers[] = "From: $sender_email" . "\r\n";
		$start = $startIndex * $process_users;
		$end = $process_users;
		$tottal_recipients_array = $native_users->get_active_subscribers_paginated( $start, $end );

		foreach ($tottal_recipients_array as $index => $receiver){

			$native_settings->native_user_id = $user_id = $receiver['id'];
			$recipient = $receiver['email'];

			$post_type = ($receiver['post_type'] != '') ? $receiver['post_type'] : 'post';
			
			$sent_post_ids = ($receiver['sent_post_ids'] != '' && !is_array($receiver['sent_post_ids'])) ? $receiver['sent_post_ids'] : '';
			$extra['not_ids'] = $sent_post_ids;

			$post_objects = $Core->emailalert_get_post_objects_for_user($user_id, $extra, $receiver);
			$email_content = email_alert_pro_send_final_email($post, $post_objects, $user_id);
		
			if (!is_array($email_content) && $email_content != '') {
				$unsubscription_link = $Core->unsubscription_link_for_user($receiver);
				$changeprefrence_link = $Core->changeprefrence_link($receiver);
				$order = array('{EMAIL_ALERT_CURRENT_USER_EMAIL}', '{EMAIL_ALERT_UNSUBSCRIPTION_LINK}', '{unsubscribe_link}', '{changeprefrence_link}');
				$replace = array($recipient, $unsubscription_link, $unsubscription_link, $changeprefrence_link);
				$email_content = str_replace($order, $replace, $email_content);
				emailalertpro_send_email_to_user($recipient, $subject, $email_content, $headers);
			}
		}
		do_action('build_sent_post_email_query');
		//build_sent_post_email_query();
	}

	
	function build_sent_post_email_query(){

		global $native_settings, $wpdb;
		$subquery = array();

		$table2 = $wpdb->prefix . "NativeEmail_sentlist";
		
		
		$query = '';
		$qsize = 1000;

		$send_post_log_data = $native_settings->sql_query; //optimize this
		
		if (count($send_post_log_data)){
		
			$sql_query = "INSERT INTO `$table2` (`id` , `native_user_id` , `post_ids`) VALUES";

			foreach ($send_post_log_data as $user => $sent_log){
				$userid = $sent_log['user_id'];
				$post_id = $sent_log['sent_post'];
				$subquery[] = '( null , ' . $userid . ' , "' . $post_id . '")';
			}

			if (is_array($subquery)){
				$subqueries = array_chunk($subquery, $qsize);
				if (count($subqueries) > 0){
					foreach ($subqueries as $subquery){
						$final_sql_query = $sql_query . implode(",", $subquery);
						$wpdb->query($final_sql_query);
					}
				}
			}
		}
	}

	
	/**********************ONCLICK POST PUBLISHED BUTTON FUNCTION ************************/
		
	add_action("nativeemal_wp_progress_bar" , "native_progress_bar");
	function native_progress_bar(){
?>			
		<style type="text/css">
				.progress-sending-emails{
					display:none;
				}
				.native-acton-cover{
					width:100%;

				}
				.native-acton-cover .left , .native-acton-cover .right{
					width:50%;
				}
		</style>
	<div class="native-acton-cover">
		<div class="left">
			<input type="button" onclick="SendingEmails();"  id="startSendingEmails" value="Send Emails" />
		</div>
			
    </div>    
          
  <div class="progress-sending-emails">
		<div class="right"></div>
		
		<input  type="hidden" id="ajax-batch-sending" value="no">
		
		<input  type="hidden" id="native_start_index" value="0">
		<input  type="hidden" id="native_end_index" value="200">
        
		<progress id='progressor' value="0" max='100' style=""></progress>  
        <span id="percentage-cover"><span id="percentage" style="">0</span>%</span>
		
		<div class="stats-report"></div>
        <div id="results" style=""></div>
	</div>	
	
		<script type="text/javascript">
		
		var es;

function SendingEmails(){
	var pBar = document.getElementById('progressor');
	var native_start_index = jQuery("#native_start_index").val();
	var native_end_index = jQuery("#native_end_index").val();
	
	jQuery(".progress-sending-emails").show();
	
	//var mywindow = window;
	var messagewindow = window.open("" , "MsgWindow" ,  "width=600,height=600");
	
	
	
	jQuery.ajax({
		type:"post",
		url:'<?php echo plugin_dir_url(__DIR__);?>\sse_progress.php',
		data:{
			action:"native_process_users",
			native_post_edit:native_start_index,
			post_id:"<?php echo get_the_ID();?>",
		},
		beforeSend:function(){
				//jQuery(".stats-report").html("processing...");
				jQuery(".progress-sending-emails").show();
				jQuery("#ajax-batch-sending").val("yes");
				messagewindow.document.write("Initiating batch sending emails ...<br/>");
		},
		success:function(response){
			var data =  jQuery.parseJSON(response);
			messagewindow.document.write("users processed <br/>" + data.message);
			
			if(data.users_processed == "no"){
				jQuery("#results").html(data.message);
				pBar.value = data.progress; //max out the progress bar
				jQuery("#percentage").html(data.progress);
				
				jQuery("#native_start_index").val(data.start_index);
				SendingEmails();
			}
			else{
				jQuery("#percentage").html(100);
				pBar.value =100;
				
				jQuery("#ajax-batch-sending").val("no");
				messagewindow.close();
				jQuery(".stats-report").html("processed...");
				alert("Finished");
			}
			
		},
		error:function(data){
				jQuery("#ajax-batch-sending").val("no");
				alert("Request could not be completed");
		}
	});
}
	  
	function addLog(message) {
		jQuery("#results").prepend(message);
	}
	
	//jQuery(window).bind('beforeunload',function(){
	//	alert("return 'Email batch sending in progress , do you want abort process ?';");
	//	return 'Email batch sending in progress , do you want abort process ?';
	//	if(jQuery("#ajax-batch-sending") == "yes"){
	//	}
     //save info somewhere
	//});
	</script>
<?php
	}