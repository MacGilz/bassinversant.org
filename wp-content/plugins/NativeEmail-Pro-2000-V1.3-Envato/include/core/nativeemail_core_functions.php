<?php

class emailalertpro_core_email extends emailalertpro_commonclass {

    public function emailalert_get_post_objects_for_user($user_id, $extra = null, $user_obj = null) {
        global $wpdb;
        $postsobj = new emailalert_posts;
        if ($user_id <= 0) {
            die("somethings gone wrong !");
            //error in userid , it is less than 0, to remove this goto include/core/native_core_functions.php on line 11
        }

        if ($user_obj == null) {
            $table = $wpdb->prefix . "emailalertpro";
            $user_obj = $wpdb->get_row("SELECT * FROM $table WHERE `id` = $user_id AND `active` != 0 ", ARRAY_A);
        }

        $cats = $user_obj['cat_ids'];
        $nargs['category_include'] = $this->refine_category_with_admin_allowed_list($cats);
        $nargs['user_id'] = $user_obj['id'];
        $nargs['user_object'] = $user_obj;
        $nargs['not_ids'] = $extra['not_ids'];
        $posts = $postsobj->emailalert_get_default_email_posts($nargs);
        return $posts;
    }

    public function unsubscription_link_for_user($reciever) {
        $link = '';
        $link = get_option('siteurl');
        $id = $reciever['id'];
        $encode_id = base64_encode($id);
        $salt = 'emailalert_unsubscription';
        $token = md5($salt . $id);
        $link = $link . '?emailalert_auth=a' . $token . '&emailalert_user=' . $encode_id;
        return $link;
    }

    public function changeprefrence_link($reciever) {
        $id = $reciever['id'];
        return change_category_selection_link($id);
    }

    public function emailalert_unsubscription_link() {
        global $native_settings;
        $bgcolor = $native_settings->get('emailalertpro_colorpicker_color_change');
        $content = '';

        $content.='<multiline>
                        You are currently signed up as: 
                        <span style="color: ' . $bgcolor . '">{EMAIL_ALERT_CURRENT_USER_EMAIL}</span> 
                        To unsubscribe  <a href="{unsubscribe_link}">click here</a>.
                        To change your preferences <a href="{changeprefrence_link}">click here</a>.
                </multiline>';

        return $content;
    }


    public function refine_category_with_admin_allowed_list($cat_ids) {

        global $native_settings;

        $output = array();

        $admin_allowd_list = $native_settings->get('category_list_not_included');

        if (count($admin_allowd_list) <= 0 or !is_array($admin_allowd_list))
            return $cat_ids;

        if (!is_array($cat_ids)) {
            $cat_ids_array = explode(',', $cat_ids);
        } else {
            $cat_ids_array = $cat_ids;
        }

        if (!empty($cat_ids_array)):

            foreach ($cat_ids_array as $key => $cat_id):

                if (!in_array($cat_id, $admin_allowd_list) && $cat_id != ''):

                    $output[] = $cat_id;

                endif;

            endforeach;

        endif;
        $output = implode(',', $output);
        return $output;
    }

    public function get_most_popular_email_from_selected_cats($valid_list) {
		global $emailalertpro;
		$emailalert_posts = new emailalert_posts;
        $admin_allowd_list = $native_settings->get('category_list_not_included');
        //get_option($emailalertpro['category_list_not_included']);	

        if (strlen($valid_list) >= 0) {
            $cat_ids = $valid_list;
        } else {
            if (is_array($admin_allowd_list))
                $cat_ids = explode(",", $admin_allowd_list);
        }
        $args = array('category__in' => $cat_ids);
        $post_obj = null;
        $post_contents = $emailalert_posts->get_email_posts($args);
        return $post_contents;
    }

}

add_filter('nativeemail_add_post_to_sent_post', 'nativeemail_add_post_to_sent_post', 15, 3);
add_action('nativeemail_add_post_to_sent_post', 'nativeemail_add_post_to_sent_post', 20, 3);
/* * *
 * @ $send_posts 
 *    posts that are already sent to user
 * @ $postObjs
 *    posts that are being sent to user   
 */

function nativeemail_add_post_to_sent_post($postTobeSend, $subscriber_id, $sent_posts) {
    global $native_settings;
    $sentList = array();
    if (!empty($postTobeSend) && $subscriber_id > 0) {
        $native_settings->sql_query[$subscriber_id]['user_id'] = $subscriber_id;
        $native_settings->sql_query[$subscriber_id]['sent_post'] = (is_array($postTobeSend)) ? implode(",", $postTobeSend) : '';
    }
}

?>