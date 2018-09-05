<?php


add_action("nativeemail-change-option", "nativeemail_change_option_default");
add_shortcode('NativeEmailSubscriberPreferences', 'NativeEmailSubscriberPreferences_shortcode');

function change_category_selection_link($userId) {

    global $wpdb, $native_settings;
    $permalink = $native_settings->get('native_change_prefrence_link');

    if ($permalink == "" or $permalink == null or $permalink == false) {
        do_action('nativeemail-change-option');
        $permalink = $native_settings->get('native_change_prefrence_link');
    }

    $newurl = add_query_arg('native_user_id', $userId, $permalink);
    return $newurl;
}

function nativeemail_change_option_default() {

    global $wpdb, $native_settings;
    $table = $wpdb->prefix . "posts";

    $query = "select * from $table where `post_type`='page' and `post_status`='publish' and `post_content` like '%[NativeEmailSubscriberPreferences]%'";

    $postcontent = $wpdb->get_row($query, ARRAY_A);
    $postid = $postcontent['ID'];

    if (count($postcontent) == 0) {
        $args = array(
            'post_title' => 'Subscriber Preferences',
            'post_content' => '[NativeEmailSubscriberPreferences]',
            'post_type' => 'page',
            'post_status' => 'publish'
        );
        $postid = wp_insert_post($args);
        $native_settings->set('native_change_prefrence_link', get_post_permalink($postid));
    }

    if ($native_settings->get('native_change_prefrence_link') == null or $native_settings->get('native_change_prefrence_link') == '') {
        $native_settings->set('native_change_prefrence_link', get_post_permalink($postid));
    }
    return get_post_permalink($postid);
}


function NativeEmailSubscriberPreferences_shortcode($args = null) {
	$term_type = isset($args['category'])?$args['category']:'category';
	$post_type = isset($args['post_type'])?$args['post_type']:'post';
	$cate_list = isset($args['cate_list'])?$args['cate_list']:'';
	$classes = isset($args['class'])?$args['class']:'';
        $admin_settings = new emailalertpro_commonclass();
	
    $native_users = new native_users;
    $subscriber = $native_users->native_email_fetch_user_detail();

    $email = $subscriber['email'];
    $select_list = $subscriber['cat_ids'];
    $term_type = isset($subscriber['category'])?$subscriber['category']:$term_type;
    $post_type = isset($subscriber['post_type'])?$subscriber['post_type']:$post_type;

    $widget = '';

    $widget.='<div class="widget_email_alert_cover">   
                <form class="widget-email-alert-form" name="widget-email-alert-check-with-input" method="post" enctype="multipart/form-data"> 
                              <div id="email_message"></div>
                      <div class="widget_area_email">
                        <div class="native_categorylist_cover">';
    $widget.=  $admin_settings->checkbox_selection_process();
    $widget.= native_get_all_category_list( $term_type, $post_type, $select_list );
    if (is_string($classes)) {
        $classes = str_replace(",", " ", $classes);
    } else {
        $classes = '';
    }//get_bloginfo('siteurl')
    $widget.='             </div>
                               <p class="emailaertpro_error_message" ></p>
                               <input type="hidden" name="website" value="' . site_url() . '" class="website_url"/>
                               <input type="text" name="emailaertpro_mail" placeholder="Enter You email" class="emailaertpro_mail" value="' . $email . '"/>
                               <input type="submit" name="subscribe" value="subscribe" class="btn-primary emailaertpro_mail_submit emailprobutton ' . $classes . '"/>
                              </div> 
                        </form> 
                       </div>';
    return $widget;
}

function native_hierarchical_category_tree($cat, $post_type = 'post', $taxonomies = 'category', $select_list = null) {
    // Change category list
    global $native_settings;
    $hide_empty = EmailAlertPro_category_manage::show_empty_category_list();
    $category_to_exclude = EmailAlertPro_category_manage::category_to_exclude();
    $category_to_include = EmailAlertPro_category_manage::category_to_include();
    $category_number = EmailAlertPro_category_manage::category_number();

    $args = array(
        'orderby' => 'name',
        'parent' => $cat,
        'order' => 'ASC',
        'number' => $category_number,
        'exclude' => $category_to_exclude,
        'include' => $category_to_include,
        'hide_empty' => false,
        'fields' => 'all',
        'hierarchical' => true
    );

    $class = '';
if($taxonomies == null or $taxonomies == '')
        $taxonomies = $native_settings->get('native_selected_term_type', 'category');

    $next = get_terms($taxonomies, $args);



    if ($cat > 0) {
        $class = "class='children'";
    }
    $return = '';
    if ($next  && !is_wp_error( $next )) {
        $return .= '<ul class="native_categorylist catman">';
        foreach ($next as $cat) :
            if ($select_list != null) {
                $select_list_array = explode(",", $select_list);

                $checked = '';
                if (in_array($cat->term_id, $select_list_array)) {
                    $checked = "checked";
                }
            }
            $return .= '<li ' . $class . '><input type="checkbox" ' . $checked . ' name="category[]" value="' . $cat->term_id . '"><label 	class="widget-email-alert-label">' . $cat->name . '</label>';
            $return .= native_hierarchical_category_tree($cat->term_id, $post_type, $taxonomies, $select_list);
            $return .= '</li>';
        endforeach;
        $return .= '</ul>';
    }else if(is_wp_error( $next )){
                $return .= '<li>';
                $return .= $taxonomies.' ';
                $return .= $next->get_error_message();
                $return .= '</li>';
	}
    return $return;
}

function native_get_all_category_list( $taxonomies = 'category', $selected_post_type = 'post', $select_list = null) {
    global $native_settings;
    $emailcommon = new emailalertpro_commonclass;
    $state = $emailcommon->get_display_category_fashion();
    $selected_taxonomy_for_user = $taxonomies;

    if ($state == 'yes') {
        $return.= native_hierarchical_category_tree(0, $selected_post_type, $taxonomies, $select_list);
    } else {
        //display at frontend widget
        $hide_empty = EmailAlertPro_category_manage::show_empty_category_list();
        $category_to_exclude = EmailAlertPro_category_manage::category_to_exclude();
        $include_category = EmailAlertPro_category_manage::category_to_include();

        if (isset($taxonomies) && $taxonomies != '') {
            $selected_category = $taxonomies;
        } else {
            $selected_category = $native_settings->get('native_selected_term_type', 'category');
        }

        $taxonomies = array($selected_category);

        $args = array(
            'orderby' => 'id',
            'order' => 'ASC',
            'exclude' => $category_to_exclude,
            'include' => $include_category,
            'hide_empty' => false,
            'fields' => 'all',
            'hierarchical' => true,
        );

        $categories = get_terms($taxonomies, $args);
        
		$return = '';
        $return = '<ul class="native_categorylist catman2">';
        if (!empty($categories) && !is_wp_error( $categories )){
            foreach ($categories as $category){
                $return .= '<li>';
                if ($select_list != null) {
                    $select_list_array = explode(",", $select_list);
                    $checked = '';
                    if (in_array($category->term_id, $select_list_array)) {
                        $checked = "checked";
                    }
                }
                $return .= '<input type="checkbox"  ' . $checked . '  name="category[]" value="' . $category->term_id . '">';

                $return .= '<label class="widget-email-alert-label">' . $category->name . '</label>';
                $return .= '</li>';
            }
        }
		else if(is_wp_error( $categories )){
					$return .= '<li>';
                    $return .= $selected_category.' ';
                    $return .= $categories->get_error_message();
                    $return .= '</li>';
		}else{
				$return .= '<li>';
				$return .= __('empty category list');
				$return .= '</li>';
		}
        $return .= '</ul>';
		
		 $return = apply_filters( "ne_change_category_filter" , $return , $categories ); 
    }
    $return .= '<input type="hidden" name="selected_category_for_db" value="' . $selected_taxonomy_for_user . '" class="selected_category_for_db">';
    $return .= '<input type="hidden" name="subscribe_form" value="update_list" class="subscribe_form">';
    $return .= '<input type="hidden" name="selected_post_type_for_db" value="' . $selected_post_type . '" class="selected_post_for_db">';

    return $return;
}

/*********category selection change code***************** */
function nativeemail_add_query_vars_filter($vars) {
    $vars[] = "native_id";
    $vars[] = "native_user_id";
    return $vars;
}
add_filter('query_vars', 'nativeemail_add_query_vars_filter');
?>