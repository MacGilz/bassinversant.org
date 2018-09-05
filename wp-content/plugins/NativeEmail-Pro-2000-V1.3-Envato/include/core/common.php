<?php

add_action('emailalertpro_send_email_to_admin', 'emailalertpro_send_email_to_admin', 100, 1);
add_action("wp_ajax_get_email_perview", "get_email_perview");

/**
 * common class to define all the common functions
 * all get set functions
 * * */
class emailalertpro_commonclass {
    // Limit Post Title by amount of characters

    /**
     * 
     * @global type $native_settings
     * @param type $title
     * @return type string
     */
    function emailalert_short_title($title) {

        global $native_settings;
        $title = html_entity_decode($title, ENT_QUOTES, "UTF-8");
		$title = apply_filters('the_content', $title);
        $font_header_size = $native_settings->get('emailalertpro_template_hfont_size' , '20');
        $limit = $native_settings->get("emailalertpro_template_text_length" , 50 );
        
        if(!$limit or !is_integer($limit)) $limit = 50;
		
        if (isset($title) && strlen($title) > 0 && $limit < strlen($title)) {
            $title = substr($title, 0, $limit);
        } else {
            $padding = " ";
            $title = str_pad($title, $limit, $padding);
            $title = html_entity_decode($title, ENT_QUOTES, "UTF-8");
            $title = substr($title, 0, $limit);
        }
        return '<div  class="post-title comon-post-tag" style="font-size:'.$font_header_size.'px;">' . $title . '</div>';
    }

    /**
     * @param type $content
     * @param type $limit
     * @param type $readmore
     * @return type string
     */
    function emailalert_short_content($content, $limit, $readmore) {
        // APPLY FILTER CONTENT
		$content = apply_filters('the_content',$content);
		if($content == ''){
			return $content;
		}	
			
        $content = strip_tags($content);
        $content = html_entity_decode($content, ENT_QUOTES, "UTF-8");
				
        $limit = ( $limit > 0 && is_numeric($limit)) ? $limit : 100;
        

		
        if(!$limit or !is_integer($limit)) $limit = 100;
        
        $pad = " ";

        if (strlen($content) >= $limit) {
            $content = mb_substr($content, 0, $limit);
        } else {
            $times = $limit - strlen($content);
            $padding = ' ';
            $content = str_pad($content, $limit, $padding);
        }
        $content .= '<p style="margin:0px;">' . $readmore . '</p>';
        //$content = apply_filter

        return "<div class=''>$content</div>";
    }

    /**
     * @global type $native_settings
     * @param type $ID
     * @return type image url source
     */
    function emailalert_get_post_thumbnailimage($ID) {
        global $native_settings;

        //$thumbnail_url = wp_get_attachment_image_src($ID);
		
		$thumbnail_url = wp_get_attachment_image_src( get_post_thumbnail_id( $ID ) , 'full' );
		
		if(isset($thumbnail_url[0])){
			$thumbnail_url = $thumbnail_url[0];
		}else{
			$thumbnail_url = false;
		}
		
        if ($thumbnail_url == '' or $thumbnail_url == false) {
            $thumbs = get_attached_media('image', $ID);
            foreach ($thumbs as $key => $thumb) {
				$thumbnail_url = wp_get_attachment_url( $key );
			}
//            $newid = $key;
			
        }
		
        if ($thumbnail_url == '' or $thumbnail_url === false) {
            $post_meta_key = $native_settings->get('post_thumbnail_key', 'feature_image');
            $thumbnail_url = get_post_meta($ID, $post_meta_key, true);
        }
        
        if ($thumbnail_url == '' or $thumbnail_url === false) {
                $img_dir  = emailalert_url . 'assets/images';
               $thumbnail_url = $img_dir . '/native-default.jpg';
        }
        $thumbnail_url = apply_filters("ne_thumbnail_filter" ,$thumbnail_url);
        return $thumbnail_url;
    }

    /**
     * 
     */
    function displayreadmorelink( $linktext , $linkurl) {
	
        global $catepro_font_family , $native_settings;
        $font_family = $catepro_font_family;
        $bgcolor = $native_settings->get('emailalertpro_colorpicker_color_change' , "343434");
        $return = '';
        $return.='<a href="' . $linkurl . '" style="'
                . 'text-decoration:none;margin-top:10px;text-align:center;'
                . 'display:block'
                . ';width:120px;'
                . 'color:#fefefe;'
                . 'background:#' . $bgcolor . '; '
                . 'border:1px solid #' . $bgcolor . ';'
                . 'padding:10px;font-family:' . $font_family . '">'.$linktext.'</a>';
        return $return;
    }
    /**
     * 
     * @global type $wpdb
     * @param type $email
     * @param type $catids
     * @return boolean|string
     */
    function email_alert_import_user( $email , $catids = null) {
        if (NativeEmail_check_user_status()) {
            return 'Please upgrade your subscription';
        }
		else {
            global $wpdb;
            $date = date('Y-m-d');
            $table_name = $wpdb->prefix . "emailalertpro";
            $state = 1;
            $query = "SELECT `id` FROM $table_name WHERE `email` LIKE '%$email%' LIMIT 1";
            $rows = $wpdb->query($query);
            if ($rows >= 1) {
			//TODO test, update catids of diffrent types same id
                $query = "UPDATE $table_name SET `cat_ids` = '$catids' WHERE `email` LIKE  '%$email%'";
                $res['rows'] = $wpdb->query($query);
                $res['user_type'] = 'old';
            } else {
				$query = "INSERT INTO `$table_name` (`email`,`cat_ids`,`category`,`post_type` ,`active` ,`date`) values ( '$email' ,'$catids' ,'category', 'post', $state  , '$date')";
                $res['rows'] = $wpdb->query($query);
                $res['user_type'] = 'new';
            }
            do_action("ne_user_imported" , $email , $catids , $res );
            return true;
        }
    }

    //todo test this    

    /**
     * 
     * @global type $native_settings
     * @return type
     */
    function get_number_post_send() {
			global $native_settings;
			$value = $native_settings->get( 'post_count' , 6 );
			return $value;
    }

    /**
     * 
     * @global type $emailalertpro
     * @param type $add_category_number
     */
    function add_category_number($add_category_number) {
        global $emailalertpro;
        if (get_option($emailalertpro['CATEGORYNUMBER']) > 0 || get_option($emailalertpro['CATEGORYNUMBER']) == '') {
            update_option($emailalertpro['CATEGORYNUMBER'], $add_category_number);
        } else {
            add_option($emailalertpro['CATEGORYNUMBER'], $category_number_to_return);
        }
    }

    /**
     * 
     * @global type $native_settings
     * @return type
     */
    function get_display_category_fashion() {
        global $native_settings;
        return $native_settings->get("native_selected_term_fashion", "no");
    }

    /**
     * 
     * @global type $emailalertpro
     * @param type $category_to_include
     */
    function category_to_include($category_to_include) {
        global $emailalertpro;
        $array = $this->get_category_to_include();
        if (!empty($array)) {
            update_option($emailalertpro['category_include'], $category_to_include);
        } else {
            add_option($emailalertpro['category_include'], $category_to_include);
        }
    }

    function get_category_to_include() {
        global $native_settings;
        return $native_settings->get('category_to_include');
    }

    function category_to_exclude($category_to_exclude = '') {
        global $native_settings;
        return $native_settings->set('category_to_exclude', $category_to_exclude);
    }

    function get_category_to_exclude() {
        global $native_settings;
        return $native_settings->get('category_to_exclude');
    }

    /**
     * 
     * @global type $emailalertpro
     * @global type $native_settings
     * @param type $category_list_not_included
     */
    function category_list_not_included($category_list_not_included) {
        global $emailalertpro, $native_settings;
        $exclude = $native_settings->get('category_list_not_included');
        //get_option($emailalertpro['category_list_not_included']);
        if (($exclude) || $exclude == '') {
            $native_settings->get('category_list_not_included');
            update_option($emailalertpro['category_list_not_included'], $category_list_not_included);
        } else {
            add_option($emailalertpro['category_list_not_included'], $category_list_not_included);
        }
    }

    function get_category_list_not_included() {
        global $native_settings;
        $array = $native_settings->get('category_list_not_included');
        return $array;
    }

    /**
     * 
     * @param type $email_frequency
     */
    function emailalert_email_frequency($email_frequency) {
        $args['freq'] = $email_frequency;
        do_action('set_email_frequency_cron', $args);
    }

    /**
     * 
     * @global type $native_settings
     * @return type email
     */
    function get_setup_sender_email() {
        global $native_settings;
		return $native_settings->get('sendername', 'nativetesting@gmail.com');
    }

    /**
     * displaying at backend
     * @global type $native_settings
     * @param type $catid
     * @param type $type
     * @param type $selectelist
     */
    function hierarchical_backend_category_tree($catid, $type, $selectelist = array()) {
		global $native_settings;
        $style = '';
        $class = "class='native_categorylist'";
        if ($catid > 0) {
            $style = "margin-left:10px;";
            $class = 'class="children"';
        }

        //$next = get_categories($args);
        $selected_category = $native_settings->get('native_selected_term_type', 'category');
        $taxonomies = array($selected_category);

        $args = array(
            'orderby' => 'name',
            'order' => 'ASC',
            'hide_empty' => false,
            'fields' => 'all',
            'hierarchical' => true,
            'child_of' => 0,
            'parent' => $catid,
            'pad_counts' => false,
            'cache_domain' => 'core'
        );

        $next = get_terms($taxonomies, $args);
		
        if ($next  && !is_wp_error( $next )) {
            foreach ($next as $cat) :
                if (isset($selectelist) && $selectelist != '' && is_array($selectelist)) {
                    $selected = '';
                    if (in_array($cat->term_id, $selectelist)) {
                        $selected = 'checked';
                    }
                }
                echo '<ul  style="' . $style . '" class="native_categorylist common">
			<li style=" margin-bottom: 0px;" ' . $class . ' dyna>
                            <input type="checkbox" ' . $selected . ' name="category_to_' . $type . '[]" value="' . $cat->term_id . '"><span>' . $cat->name . '</span>';
                $this->hierarchical_backend_category_tree($cat->term_id, $type, $selectelist);
                echo '</li></ul>';
            endforeach;
        }else if(is_wp_error( $next )){
					$return .= '<li>';
                    $return .= $taxonomies.' ';
                    $return .= $next->get_error_message();
                    $return .= '</li>';
				echo $return;	
		}
    }

    /**
     * 
     * @global type $native_settings
     * @param type $type
     */
    function get_all_category_list($type = null) {
	
        global $native_settings;
        //admin section function
        $inserted = $categories = array();
		$return = '';
		

        if ($type == 'include') {
            $inserted = explode(",", $native_settings->get('category_to_include'));
        }

        if ($type == 'exclude') {
            $inserted = explode(",", $native_settings->get('category_to_exclude'));
        }

        if ($type == 'alllist') {
            $inserted = explode(",", $native_settings->get('category_list_not_included'));
        }

        $count = 1;
        $return .= '<div class="category ' . $type . '">';

        $selected_category = $native_settings->get('native_selected_term_type', 'category');
        $post_type = $native_settings->get('native_selected_post_type', 'post');
        $taxonomies = array($selected_category);

        $state = $this->get_display_category_fashion();

        if ($state == 'yes') {
			$return .= $this->hierarchical_backend_category_tree(0, $type, $inserted);
        }
		else {
            $args = array('orderby' => 'id', 'order' => 'ASC', 'hide_empty' => false, 'fields' => 'all', 'hierarchical' => true, 'child_of' => 0, 'pad_counts' => false, 'cache_domain' => 'core');
            $categories = get_terms($taxonomies, $args);

            $return .= '<ul class="native_categorylist common">';
            if (!empty($categories) && !is_wp_error( $categories ) ){

                foreach ($categories as $category){
                    $return .= '<li>';
                    //echo $count.')';
                    if (!empty($inserted))
                        if (in_array($category->term_id, $inserted)) {
                            $selected = 'checked="checked"';
                        } else {
                            $selected = '';
                        }
                    $return .= '<input type="checkbox" ' . $selected . ' name="category_to_' . $type . '[]" value="' . $category->term_id . '">';
                    $return .= '&nbsp;<span>' . $category->name . '</span>';
                    $return .= '</li>';
                    $count++;
                }
			}	
            else if(is_wp_error( $categories )){
					$return .= '<li>';
                    $return .= $selected_category.' ';
                    $return .= $categories->get_error_message();
                    $return .= '</li>';
				}
			else{
						$return .= '<li>';
						$return .= __('empty category list');
						$return .= '</li>';
				}
            $return .= '</ul>';
		}
		$return.= '<input type="hidden" class="selected_category_for_db" value="' . $selected_category . '" name="selected_category_for_db" /><input type="hidden" class="selected_post_for_db" value="' . $post_type . '" name="selected_post_type_for_db" />';
		$return.= '</div>';
		$return = apply_filters("ne_all_cat_list_filter",$return ,$categories );
		echo $return;
    }

	
	function checkbox_selection_process(){
		return	'<div class="native-select-all select-all">Select all</div>';
	}
    /**
     * 
     * @global type $wpdb
     * @param type $email
     * @param type $catids
     * @param type $taxonomy
     * @param type $post_type
     */
    function email_alert_subscribe_user( $email, $catids = null, $taxonomy = 'category', $post_type = 'post') {
        global $wpdb;
        $date = date('Y-m-d');
        $table_name = $wpdb->prefix . "emailalertpro";
        $state = 1;
        $status = 1;

        // has this user already subscribed?
        $query = "SELECT * FROM `$table_name` WHERE `email` = '$email' AND `category` = '$taxonomy' and `post_type` = '$post_type' ";
        $row = $wpdb->get_row($query);

        // was a record found?
        if (!empty($row)) {
            // get the categories that have been subscribed to
            // and convert them to an array
            $old_subscribed_categories = explode(',', $row->cat_ids);

            // convert the new categories to an array
            // merge the 2 arrays
            // remove duplicates
            // and convert back to a CSV string

            if (isset($_POST['subscribe_form']) && $_POST['subscribe_form'] == 'update_list') {
                $cat_subscription_string = $catids;
            } else {
                $additional_categories = explode(',', $catids);
                $new_subscribed_categories = array_merge($old_subscribed_categories, $additional_categories);
                $new_subscribed_categories = array_unique($new_subscribed_categories);
                $cat_subscription_string = implode(',', $new_subscribed_categories);
            }


            // update the database
            $res['rows'] = $wpdb->update(
                    $table_name, array('cat_ids' => $cat_subscription_string, 'post_type' => $post_type, 'active' => $status, 'date' => $date), array('email' => $email, 'category' => $taxonomy), array('%s', '%s', '%s', '%s', '%s'), array('%s', '%s')
            );
            $res['user_type'] = 'old';
        }
        // otherwise ...
        else {
				$query = "INSERT INTO `$table_name` (`email`,`cat_ids`,`category`,`post_type` ,`active` ,`date`) values ( '$email' ,'$catids' ,'$taxonomy', '$post_type', '$status'  , '$date' )";

            $res['rows'] = $wpdb->query($query);
            $res['user_type'] = 'new';
        }

        $var = new emailalertpro_templates;
        $var->send_subscription_email($email);
        echo json_encode($res);
        exit;
    }

    /**
     * 
     * @global type $wpdb
     * @param type $email
     * @param type $state
     * @param type $comma_separated_category_id
     * @param type $taxonomy
     * @param type $post_type
     * @return boolean|string
     */
    function add_subscriber($email, $state = 'active', $comma_separated_category_id = null, $taxonomy = 'category', $post_type = 'post') {

        //display widget exit is used
        global $wpdb;
        $date = date('Y-m-d');
        $table_name = $wpdb->prefix . "emailalertpro";

        $catids = $comma_separated_category_id;

        if ($catids == null) { $catids = ''; }
		//if($taxonomy == '' or $taxonomy == null){$taxonomy = 'category'}
		
        if ($state == 'unactive') {
            $status = 0;
        } else {
            $status = 1;
        }
        // validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $return = "error";
            return $return;
        }
        if (!is_email($email)) {
            return false;
        }
        $query = "SELECT count(*) FROM $table_name WHERE `email` LIKE '%$email%' and `category` = '$taxonomy'";
        $rows_id = $wpdb->get_var($query);
        if ($rows_id >= 1) { // record found in database
            $wpdb->update(
                    $table_name, array('cat_ids' => $catids, 'post_type' => $post_type, 'active' => $status, 'date' => $date), array('email' => $email), array('%s', '%s', '%s', '%s', '%s', '%s'), array('%s')
            );
            $res['entry_type'] = 'old';
        } else {//insert enteries otherwise
            $wpdb->insert(
                    $table_name, array('email' => $email, 'cat_ids' => $catids, 'category' => $taxonomy , 'post_type' => $post_type, 'active' => $status, 'date' => $date), array('%s', '%s', '%s', '%s', '%s', '%s')
            );
			
            $res['entry_type'] = 'new';
        }
		
        return $res;
    }

    /**
     * 
     * @global type $wpdb
     * @param type $id
     * @return type
     */
    function remove_subscriber($id) {
        global $wpdb;
        $table_name = $wpdb->prefix . "emailalertpro";
        $query = "DELETE FROM $table_name WHERE `id`='$id'";
        $res = $wpdb->query($query);
        return $res;
    }

    /**
     * 
     * @global type $wpdb
     * @param type $args
     * @return type
     */
    function get_subscribers_list($args = null) {

        global $wpdb;

        if (!isset($args['limit']) or $args['limit'] == '' or ! is_numeric($args['limit']))
            $limit = 20;
        else
            $limit = $args['limit'];


        if ((isset($args['page']) && $args['page'] == '') or ! is_numeric($args['page']))
            $start = 0;
        else
            $start = $args['page'];


        if ($start < 0)
            $start = 0;



        if (!isset($args['order']) || $args['order'] == '')
            $order = 'id';
        else
            $order = $args['order'];

        $email = '';



        if ($args['s'] != '' or $args['filter'] != '') {
            $query = 'WHERE   ';
            if (isset($args['s']) && $args['s'] != '') {
                $email = $args['s'];
                $query.= "`email`  LIKE '%$email%'	";
            }
            if ($args['s'] != '' and $args['filter'] != '') {
                $query.= "AND";
            }
            if (isset($args['filter']) && $args['filter'] != '') {
                $filter = $args['filter'];
                $query.= "`active`  = '$filter'	";
            }
        } else {
            $query = 'WHERE   ';
            $query.= "`active`  = '1'	";
        }

        $table_name = $wpdb->prefix . "emailalertpro";

        if (isset($args['filter']) && $args['filter'] != '')
            $filter = "AND  ";
        if (isset($_GET['sort']) && $_GET['sort'] == 'ASC') {
            $sort = 'ASC';
        } else {
            $sort = 'DESC';
        }


        $query_req = "SELECT * FROM  $table_name  $query ORDER BY `$order` $sort LIMIT $start , $limit";

        //print $query_req ;

        $query_count = "SELECT * FROM  $table_name  $query ORDER BY `$order` $sort";

        $result_count = $wpdb->query($query_count);

        $result = $wpdb->get_results($query_req);
        $result['total_count'] = $result_count;
        return $result;
    }

    /**
     * 
     * @global type $wpdb
     * @return type
     */
    function get_active_subscribers_list() {
        global $wpdb;
        $table_name = $wpdb->prefix . "emailalertpro";
        $query = "SELECT `email` FROM  $table_name  WHERE `active` = 1 ORDER BY `id` DESC";
        $results = $wpdb->get_results($query);
        foreach ($results as $result):
            $email[] = $result->email;
        endforeach;
        $result = implode(',', $email);
        return $result;
    }

    /**
     * 
     * @param type $comma_separated_ids
     * @param type $taxonomy
     * @return type
     */
    function get_subscribed_category_name($comma_separated_ids, $taxonomy) {
        $array_ids = explode(',', $comma_separated_ids);
		if(is_array($array_ids)){ 
			$array_ids = array_filter($array_ids);
		}
		$name = array();
        if (!empty($array_ids)):
            foreach ($array_ids as $array_id):
                $termObj = get_term_by('id', $array_id, $taxonomy); //get_cat_name($array_id);
			if($termObj){	
                if ( is_wp_error($termObj) or $termObj->name == null){
                    $name[] = '[xxx]';
                } else {
                    $catename = $termObj->name;
                    $name[] = $catename;
                }
			}	
            endforeach;
        endif;
		$result = implode(', ', $name);
        return $result;
    }

    /**
     * 
     * @global type $native_settings
     * @param type $image_array
     * @return string
     */
    function email_add_header_image($image_array) {
        global $native_settings;
        $name = $image_array['name'];
        $type = $image_array['type'];
        $tmp_name = $image_array['tmp_name'];
        $error = $image_array['error'];
        $size = $image_array['size'];
		
        if ($error == 0) {
            $upload = wp_upload_dir();
            $path = $upload['basedir'];
            $baseurl = $upload['baseurl'];
            $rand = rand();
            $new_name = $rand . $name;

            $new_name = preg_replace('#[^a-z.0-9]#i', '', $new_name);
            $kaboom = explode(".", $new_name);
            $fileExt = end($kaboom);
            $new_name = 'Nativelogo_' . time() . rand() . "." . $fileExt;


            wp_mkdir_p($path . '/emailalertpro/');

            if (file_exists($path . '/emailalertpro/' . $new_name)) {
                $response = 'file already exists';
				$status = false;
            } else {
                if (move_uploaded_file($tmp_name, $path . '/emailalertpro/' . $new_name)) {
                    $native_settings->set('EMAILALERT_header_image', $baseurl . '/emailalertpro/' . $new_name);
					$response = $baseurl . '/emailalertpro/' . $new_name;
					$status = true;
                } else {
                    $response = 'error occured while uploading file';
					$status = false;
                }
            }
			
        } else {
			$status = false;
            $response = 'error occured to upload file';
        }
		
        return array( 'status' =>$status , 'response' => $response );
    }

    /**
     * 
     * @global type $native_settings
     * @return type
     */
    function email_get_header_image() {
        global $native_settings;
        $return = $native_settings->get('EMAILALERT_header_image');
        return $return;
    }

    /**
     * 
     * @param type $value
     * @return type
     */
    function set_emailalert_send_most_comment_view($value) {

        $meta_key = 'emailalert_send_most_comment_view';
        $old_val = get_option($meta_key);

        if (!$old_val or $old_val == '') {
            $res = update_option($meta_key, $value);
        } elseif ($old_val) {
            $res = update_option($meta_key, $value);
        } else {
            $res = add_option($meta_key, $value);
        }

        return $res;
        //else
    }

    /**
     * 
     * @global type $native_settings
     * @return type
     */
    function get_emailalert_send_most_comment_view() {
        global $native_settings;
        return $native_settings->get('emailalert_send_most_viewd');
    }

}


function unsubscription_link($userid) {
    $link = '';
    $home_url = get_option('site_url');

    $token = md5(uniqid(mt_rand(), true));

    $link = $home_url . '?token=' . $token . '&emailalert_user_id' . $userid;

    return $link;
}

/* * ******* */

/**
 * 
 * @param type $extra
 */
function get_email_perview($extra) {

	$return = emailalertro_emaillive_view($extra);
	if(is_string($return)){
		print $return;
	}
	else if(is_array($return) && isset($return['messsage'])){
		print $return['messsage'];
	}else{
		print 'system is unable to perview this item , user doesn\'t exist anymore';
	}
	exit;
}

/**
 * 
 * @global type $native_settings
 * @param type $useremail
 * @return boolean
 */
function emailalertpro_send_email_to_admin($useremail = null) {
    global $native_settings;
    $emailalert_posts = new emailalert_posts;
    $current_user = wp_get_current_user();
    $default = $current_user->user_email;

    if ($useremail == null)
        $admin_email = $default; //get_option('admin_email', $default);
    else
        $admin_email = $useremail;

    if (!$admin_email)
        return false;

    $sender_email = $emailalert_posts->get_setup_sender_email();
    $headers[] = "From: " . $sender_email . "\r\n";
    $subject = $native_settings->get("emailalertpro_template_email_subject");

    $nargs['not_ids'] = ''; //	$extra['not_ids'];		//uncomment to remove the first object //empty this
    $nargs["user_id"] = 'skip';
    $post_objects = $emailalert_posts->emailalert_get_default_email_posts($nargs);

    $email_content = email_alert_pro_send_final_email(NULL, $post_objects, $nargs["user_id"]);  // email content using templates


    $unsubscription_link = '';
    $changeprefrence_link = $native_settings->get('native_change_prefrence_link');

    $order = array(
        '{EMAIL_ALERT_CURRENT_USER_EMAIL}',
        '{EMAIL_ALERT_UNSUBSCRIPTION_LINK}',
        '{unsubscribe_link}',
        '{changeprefrence_link}'
    );

    $replace = array(
        $recipient,
        $unsubscription_link,
        $unsubscription_link,
        $changeprefrence_link
    );

		$email_content = str_replace($order, $replace, $email_content);
		
        if (!is_array($email_content) && $email_content != '') {
			emailalertpro_send_email_to_user($admin_email, $subject, $email_content, $headers);
		}	
}

/**
 * 
 * @global type $native_settings
 * @param type $extra
 * @return string
 */
function emailalertro_emaillive_view($extra) {
    global $native_settings;

    $native_user = new native_users;
    $emailalert_posts = new emailalert_posts;
    $userobj = $nargs = array();
    $nargs['user_id'] = 'skip';
	
    if (isset($_REQUEST['native_user_id']) && $_REQUEST['native_user_id'] > 0) {
		$nargs['user_id'] = $_REQUEST['native_user_id'];
        $user_id = $_REQUEST['native_user_id'];
        $userobj = $native_user->get_active_subscriber($user_id);
        $cat_ids = $userobj['cat_ids'];
        $nargs['category_include'] = $cat_ids;
        $nargs['user_object'] = $userobj;
        $admin_email = $userobj['email'];
    } else {
        $admin_email = get_option('admin_email', 'info@nativeplugins.com');
    }
	
    if (!$admin_email)
        return array('status' => 'error', 'message' => 'invalid email');

    $post_objects = $emailalert_posts->emailalert_get_default_email_posts($nargs);

    $email_content = email_alert_pro_send_final_email(NULL, $post_objects, '0');

    $unsubscription_link = '';

    $changeprefrence_link = $native_settings->get('native_change_prefrence_link');

    $order = array(
        '{EMAIL_ALERT_CURRENT_USER_EMAIL}',
        '{EMAIL_ALERT_UNSUBSCRIPTION_LINK}',
        '{unsubscribe_link}',
        '{changeprefrence_link}'
    );

    $replace = array(
        $admin_email,
        $unsubscription_link,
        $unsubscription_link,
        $changeprefrence_link
    );
	
    $email_content = str_replace($order, $replace, $email_content);
	if(isset($email_content['status']) && $email_content['status'] == 'error')
			return $email_content['message'];
		
    if ($email_content == '')
        return 'no post data to display for this user';
    else
        return $email_content;
}

/**
 * 
 * @param type $content_type
 * @return string
 */
function emailalert_change_content_type($content_type) {
    return 'text/html';
}

/**
 * 
 * @global type $native_settings
 * @param type $recipient
 * @param type $subject
 * @param type $email_content
 * @param type $headers
 * @param type $log
 */
function emailalertpro_send_email_to_user($recipient, $subject, $email_content, $headers, $log = 'yes') {
    global $native_settings;
    add_filter('wp_mail_content_type', 'emailalert_change_content_type');
	
	$postidsCommaSeparated = (is_array($native_settings->postidsArray) && count($native_settings->postidsArray) > 0)?implode(",",$native_settings->postidsArray):'';
	
	$subject = apply_filters('nativeemail_postitleassubject', $subject , $postidsCommaSeparated);
	
    wp_mail($recipient, $subject, $email_content, $headers);
	
    $mail_array = array(
        'to' => $recipient,
        'subject' => $subject,
        //'message' => $email_content ,
        'headers' => $headers,
        'attachments' => array(),
        'postids' => $postidsCommaSeparated,
        'native_user_id' => $native_settings->native_user_id
    );

    apply_filters('nativeemail_store_sent_log', $mail_array);
    remove_filter('wp_mail_content_type', 'set_default_content_type');
}


//NativeEmail_check_user_status();
function NativeEmail_check_user_status(){

		global $wpdb;
        $table_name = $wpdb->prefix . "emailalertpro";
		$rows = $wpdb->get_results("select `id` from $table_name");
		$users = count($rows);
		
		if(  2000 <= $users)
			return true;

		// unlimited users
		return false;
	}

function link_to_demo_site() {
    //	return '<p><a href="http://NativeEmail.com" target="_blank"><img src="'.emailalert_url.'/assets/images/Free-Widget-Logo.png" alt="Nativeemail"/></a></p>';
}

?>