<?php

class emailalert_posts extends emailalertpro_commonclass {

    /**
     * @updates 'include_children' => false , custom taxonomy , published posts
     * @global type $native_settings
     * @param type $nargs
     * @param type $type
     * @return type
     */
    public  function emailalert_get_default_email_posts($nargs = null, $type = null) {
        	
        global $native_settings;
        $slider_view = $return = false;
        $subscriber_id = $nargs["user_id"];
        
        // for slider viewing and template pervewing
        if(isset($_GET['t']) && $_GET['t'] > 0 or @$_GET['action'] == 'get_email_perview' && @$_GET['native_user_id'] == null){
				$slider_view = true;
          }    
		
        $post_count = $this->get_number_post_send();
        $category_not_in = parent::get_category_list_not_included();
        
        // for default category
        $category_include = isset($nargs['category_include'])?$nargs['category_include']:'';
        
        //$args['category__not_in'] = ($category_not_in != false)?$category_not_in:''; // filter post according to new logic , post__not_in
        
        // order list selection sort
        $checked = emailalertpro_commonclass::get_emailalert_send_most_comment_view();
		
        if ($checked == 'most_viewd') { //Most Commented
            $args['meta_key'] = 'emailalertpro_post_views_count';
            $args['orderby'] = 'meta_value_num';
        } else if ($checked == 'most_commented') {//Most Viewed 
            $args['orderby'] = 'comment_count';
        } else if ($checked == 'most_commented_viewed') { //Most Commented and Most Viewed
            $args['orderby'] = 'meta_value_num comment_count';
        } else { // All 
            $args['orderby'] = 'ID';
        }
        $args['order'] = 'DESC';


        if ($category_include != '') {
            $category_include = explode(",", $nargs['category_include']);
			$taxonomy = $nargs['user_object']['category'];
			$args['tax_query'][] = array('taxonomy' => $taxonomy, 'field' => 'id', 'terms' => $category_include , 'include_children' => false);
        }
		if ($category_not_in != '') {
            $category_not_in = explode(",", $category_not_in);
			$taxonomy = $nargs['user_object']['category'];
			$args['tax_query'][] = array('taxonomy' => $taxonomy, 'field' => 'id', 'terms' => $category_not_in , 'operator'  => 'NOT IN');
			$args['tax_query']["relation"] =  'AND';
        }

        
		
        if (isset($nargs['user_object']['post_type']) && $nargs['user_object']['post_type'] != '') {
            $args['post_type'] = $nargs['user_object']['post_type'];
        } else {
            $args['post_type'] = $native_settings->get('native_selected_post_type', 'post');
        }
        
        
         
        
        if (isset($nargs['not_ids']) && $nargs['not_ids'] != '') {
            $args['post__not_in'] = array_filter(array_unique(explode(",", $nargs['not_ids'])));
        } else {
            $args['post__not_in'] =  array();
        }
        // compatible for both new and old code
        if (count($args['post__not_in']) === 0 && isset($nargs['user_object']['sent_post_ids'])) {
            $args['post__not_in'] = ($nargs['user_object']['sent_post_ids'] != '') ? array_filter(array_unique(explode(",", $nargs['user_object']['sent_post_ids']))):array();
        }
		
		
		if($checked == 'all'){
          $args['post__not_in'] =  array(); // for most recent posts , no need to check already sent posts
		}
        /**
         * always display posts at backend for user
         */
        if ($subscriber_id == 'skip' or $slider_view) {
            //$args = array('post_type' => 'post', 'post_status' => 'publish');
        }
        
        // common values
		$args['posts_per_page'] = $post_count;
        $args['post_status'] = 'publish';
        
        $args = apply_filters('native_filter_post_selection_param' , $args , $nargs);
		
			
		
        $postobjcs = new WP_Query( $args );
		
		//print '<pre>';
		//echo "Last SQL-Query: {$postobjcs->request}";
		//print_r($args);
		//print_r($postobjcs->posts);
		//exit;
			
		$post_data = $postobjcs->posts;
		$meta_key = "emailalert_send_email_user_" . $subscriber_id;

        if($slider_view){
                $return = $post_data;
        }
        else if (!empty($post_data)) {
				$sent_log_posts = array();
                foreach ($post_data as $key => $postob) {
                    if ($subscriber_id == 'skip' or get_post_meta($postob->ID, $meta_key, true) != "sentnativeemailposttouser"){
                            $return[] = $postob;
                            $sent_log_posts[] = $postob->ID;
                    }
                }

            $native_settings->postidsArray = $sent_log_posts;		
            $notids = isset($nargs['not_ids'])?$nargs['not_ids']:'';
            $postIdsArray = $native_settings->postidsArray;
            apply_filters('nativeemail_add_post_to_sent_post', $postIdsArray , $subscriber_id, $notids);
        }

         $return = apply_filters('native_filter_post_selected_objects' , $return);
        
        return $return;
    }

}

?>