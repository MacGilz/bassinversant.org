<?php
if(file_exists("../../../wp-load.php")){

		require_once("../../../wp-load.php");
//LONG RUNNING TASK

	
		global $native_settings;
		$response = array();
		/**
		 * * intialize object classes
		 */
		$response["message"] = 'Sending batch email starts <br/>';
		
		$Core = new emailalertpro_core_email;
		$native_users = new native_users;
		$native_settings->sql_query = array();
		$extra['not_ids'] = '';

		
		$native_selected_term_type = $native_settings->get("native_selected_term_type" , "category");
		
		

		$process_users = isset($_REQUEST['native_post_size']) ? $_REQUEST['native_post_size'] : 10; // array size per tern
		$startIndex = isset($_REQUEST['native_post_edit']) ? $_REQUEST['native_post_edit'] : 0;
		$post_id = isset($_REQUEST['post_id']) ? $_REQUEST['post_id'] : 0;
		
		$post_terms = get_the_terms( $post_id , $native_selected_term_type);
		
		//if(!empty($post_terms)){	
				$cats = array();
				foreach ( $post_terms as $term ) {
						$cats[] = "FIND_IN_SET('".$term->term_id."',`cat_ids`)";
				}
				
				$native_users->filters[] =  array("usestring" => true , "string" => "(".implode(" OR " , $cats)." )");
				
				//$post_selected_term_ids = implode("," , $post_selected_term_ids);
				//$native_users->filters[] =  array("key" => "FIND_IN_SET_X" , "relation" => "" , "value" => "(".$post_selected_term_ids.",`cat_ids`)" , "usestring" => true);
				//$native_users->filters[] =  array("usestring" => true , "string" => " FIND_IN_SET_X('".$post_selected_term_ids."',`cat_ids`) ");
		//}		
				
		
		
		$sender_email = $native_settings->get('sendername');
		$subject = $native_settings->get('emailalertpro_template_email_subject');
		$headers[] = "From: $sender_email" . "\r\n";
		
		$start = $startIndex * $process_users;
		$end = $process_users;
		
		$total_active = $native_users->get_active_subscribers_count();
		
		if($total_active > 0 ){
			$response["progress"] = round(($start/$total_active)*100 , 2);
		
			$total_active_subscribers = $native_users->get_active_subscribers_paginated( $start, $end );
		
			$endlimit = $start+$end;
		
			$response["message"] = count($total_active_subscribers) ."found between $start and $endlimit <br/>";
		
			$response["total_users_found"] = count($total_active_subscribers);
	
	
				if(count($total_active_subscribers)){
					
					foreach ( $total_active_subscribers as $index => $receiver){
					
						$native_settings->native_user_id = $user_id = $receiver['id'];
						$recipient = $receiver['email'];

						$post_type = ($receiver['post_type'] != '') ? $receiver['post_type'] : 'post';
						
						$sent_post_ids = ($receiver['sent_post_ids'] != '' && !is_array($receiver['sent_post_ids'])) ? $receiver['sent_post_ids'] : '';
						$extra['not_ids'] = $sent_post_ids;

						$post_objects = $Core->emailalert_get_post_objects_for_user($user_id, $extra, $receiver);
						$post = array();
						$email_content = email_alert_pro_send_final_email( $post , $post_objects, $user_id);
					
						if (!is_array($email_content) && $email_content != '') {
							$unsubscription_link = $Core->unsubscription_link_for_user($receiver);
							$changeprefrence_link = $Core->changeprefrence_link($receiver);
							$order = array('{EMAIL_ALERT_CURRENT_USER_EMAIL}', '{EMAIL_ALERT_UNSUBSCRIPTION_LINK}', '{unsubscribe_link}', '{changeprefrence_link}');
							$replace = array($recipient, $unsubscription_link, $unsubscription_link, $changeprefrence_link);
							$email_content = str_replace($order, $replace, $email_content);
							
							emailalertpro_send_email_to_user($recipient, $subject, $email_content, $headers);
							
							$response["message"] .= "$user_id => $recipient id processed <br/>";
						}
					}
							
							do_action('build_sent_post_email_query');
							
							$response["start_index"] = $startIndex+1;
							//$response["end_index"] = $start+$end+$end;
							
							$response["users_processed"] = "no";
				}
			else{
					$response["users_processed"] = "yes";
					//end("users proceesed");
			}	
		}
		else{
			$response["message"] .= " No user found <br/>";
			$response["users_processed"] = "yes";
		}
//}
		//build_sent_post_email_query();
	echo json_encode($response);
	sleep(5);
	exit;
    
}