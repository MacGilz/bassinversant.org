<?php

class native_users {

    public $native_user_id;
    public $user_post_type;
    public $term_type;
	public $filters;
	
	
	public function __construct(){
			global $native_settings;
			$post_type = $native_settings->get("native_selected_post_type" , "post"); 
			
			$this->filters["post_type"] = array("key" => "maintb.`post_type`" , "relation"=> "=" , "value" => $post_type);
			
			add_filter('ne_filter_users' , array($this , 'ne_filter_users'),10 ,2);
	}
	
	public function ne_filter_users( $query , $filters = array()){
			
				
				//$this->filters = $filters;
				
				
				
				foreach( $this->filters as $key => $value){
					if(isset($value['usestring']) && $value['usestring'] ==  true){
						$replace_string = "  WHERE ".$value['string']." AND  ";
						$query = str_replace(" WHERE " , $replace_string , $query);	
					} 
					else{
						$replace_string = "  WHERE ".$value['key']."  ".$value['relation']." '".$value['value']."' AND  ";
						$query = str_replace(" WHERE " , $replace_string , $query);	
					}
				
				}
				
				return $query;
	}
    /**
     * get all active subscriber array
     */
    public function get_active_subscribers_array() {
        global $wpdb;
        $table_name = $wpdb->prefix . "emailalertpro";
        $table2 = $wpdb->prefix . "NativeEmail_sentlist";
        $start = 0;
        $end = 10;
        $query = "SELECT group_concat( post_ids ) as sent_post_ids , maintb.`id` , maintb.`email` , maintb.`cat_ids` , maintb.`post_type` ,  maintb.`category` FROM   $table2  AS sectb RIGHT JOIN $table_name AS maintb  ON sectb.`native_user_id` = maintb.`id` where maintb.`active` = 1  group by maintb.`id`";
		$query .= " ORDER BY maintb.`id` DESC";
		
        $results = $wpdb->get_results($query, ARRAY_A);
        return $results;
    }

    public function get_active_subscribers_paginated($start = 0, $end = 0) {

        global $wpdb;
        $table_name = $wpdb->prefix . "emailalertpro";
        $table2 = $wpdb->prefix . "NativeEmail_sentlist";
        $query = "SELECT group_concat( post_ids ) as sent_post_ids , maintb.`id` , maintb.`email` , maintb.`cat_ids` , maintb.`post_type` ,  maintb.`category` FROM   $table2  AS sectb RIGHT JOIN $table_name AS maintb  ON sectb.`native_user_id` = maintb.`id` WHERE maintb.`active` = 1  group by maintb.`id`";
        
		$query .= " ORDER BY maintb.`id` DESC";
		
		if ($end > 0) {
            $query.=" LIMIT $start , $end ";
        }
		
		$query = apply_filters('ne_filter_users' , $query);
		
		
        $results = $wpdb->get_results($query, ARRAY_A);
        return $results;
    }

    public function get_active_subscriber($user_id = 0) {
        global $wpdb;
		
        $table_name = $wpdb->prefix . "emailalertpro";
        $table2 = $wpdb->prefix . "NativeEmail_sentlist";
        //$query = "SELECT * from $table_name where `id` = '$user_id'";

        $query = "SELECT group_concat( post_ids ) as sent_post_ids , maintb.`id` , maintb.`email` , maintb.`cat_ids` , maintb.`post_type` ,  maintb.`category` FROM   $table2  AS sectb RIGHT JOIN $table_name AS maintb  ON sectb.`native_user_id` = maintb.`id` where maintb.`active` = 1 and maintb.`id` = $user_id   group by maintb.`id`";

        $results = $wpdb->get_row($query, ARRAY_A);
        return $results;
    }

    public function get_active_subscribers_count() {
        global $wpdb;
        $table_name = $wpdb->prefix . "emailalertpro";
        $query = "SELECT count(*) FROM   $table_name as maintb  WHERE `active` = 1  group by `id`";
		
			
	
			
		$query = apply_filters('ne_filter_users' , $query );
		
		
		$results = $wpdb->query($query);
        return $results;
    }

    function native_email_fetch_user_detail($native_user_id = 0) {
		
        global $wpdb, $current_user;
        $table = $wpdb->prefix . "emailalertpro";
        $query = true;
        
        if ($native_user_id == 0)
            $native_user_id = get_query_var('native_user_id', false);
	
        $cmaybeemail = isset($_COOKIE['nativevisitor']) ? $_COOKIE['nativevisitor'] : false;
		
        wp_get_current_user();
        $maybeemail = $current_user->user_email;

        if (isset($native_user_id) && $native_user_id > 0) {
			$query = "SELECT * FROM $table WHERE `id` = '$native_user_id'";
            
        } else if ($cmaybeemail) {
			$query = "SELECT * FROM $table WHERE `email` = '$cmaybeemail'";
            
        } else if ($maybeemail != null) {
			$query = "SELECT * FROM $table WHERE `email` = '$maybeemail'";
            
        } else {
			$query = false;
            $native_user_object = false;
        }
        
        if($this->term_type != '' && $query == true){
		/**
		** user will be see same email on diffrent input box,last entered or logged in email
		*/ 
		/*	$query .= " AND `category` = '$this->term_type'"; */
		}

		
        $native_user_object = $wpdb->get_row($query , ARRAY_A);

        return $native_user_object;
    }

}

?>