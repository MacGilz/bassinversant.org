<?php

// change wordpress default name and taghline
add_filter('wp_mail_from', 'nativeemai_fromemail' , 1000);
add_filter('wp_mail_from_name', 'nativeemail_fromname' , 1000);


//To keep the count accurate, lets get rid of prefetching
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
add_action('wp_head', 'emailalert_wpb_track_post_views');

add_action('emailalertpro_send_email_alert', 'emailalertpro_call_to_send_email');

function nativeemai_fromemail($email) {
	global $native_settings;
    $wpfrom = $native_settings->get('sendername' , get_option('admin_email')); 
	return $wpfrom;
}

function nativeemail_fromname($email) {
		global $native_settings;
    //$wpfrom = get_option('blogname');
    $wpfrom = $native_settings->get('blogname');
    return $wpfrom;
}

/*
 * 	get most viewd posts
 */

function wpb_set_post_views($postID) {
    $count_key = 'emailalertpro_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if ($count == '') {
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    } else {
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}

//wpb_set_post_views(get_the_ID());

function emailalert_wpb_track_post_views($post_id) {
    if (!is_single())
        return;
    if (empty($post_id)) {
        global $post;
        $post_id = $post->ID;
    }
    wpb_set_post_views($post_id);
}

function emailalert_wpb_get_post_views($postID) {
    $count_key = 'emailalertpro_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if ($count == '') {
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return '0';
    }
    return $count;
}

/* * ***
 *
 * still pending
 *
 * **** */
global $wpdb;
$table_name = $wpdb->prefix . "emailalertpro";

if (isset($_GET['emailalert_auth']) && $_GET['emailalert_auth'] != '' && $_GET['emailalert_user'] != '') {
    $rows = 'no row';
    $encode_id = $_GET['emailalert_user'];
    $id = base64_decode($encode_id);
    $data = array('active' => '0');
    $where = array('id' => $id);
    if (is_numeric($id)) {
        $rows = $wpdb->update($table_name, $data, $where, $format = null, $where_format = null);
    }
    if ($rows >= 1) {
        print 'Unsubscription successfull.....';
        exit;
    }
}

?>