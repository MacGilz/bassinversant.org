<?php

class emailalertpro_templates extends emailalertpro_commonclass {

    var $emailalertpro_options = array();
    var $permalink = '';

    function __construct() {
        add_action("email_subscription_templates", array($this, "email_subscription_templates"));
        add_action("send_subscription_email", array($this, "send_subscription_email"));
        add_action("activation_action_link", array($this, 'activation_action_link'));
        add_action("send_unsubscribe_email", array($this, 'send_unsubscribe_email'));
    }

    function email_subscription_templates($meta_key, $template = null) {

        if ($template == null) {
            return get_option($meta_key);
        }
        if (!get_option($meta_key)) {
            add_option($meta_key, $template);
        } else {
            update_option($meta_key, $template);
        }
    }

    function send_subscription_email($emailid = null) {
        global $current_user, $native_settings;
        $emailalertpro_templates = new emailalertpro_templates;
        if (trim($native_settings->get("emailalertpro_get_notification_status")) != 'yes') {
            return false;
        }

        if ($emailid == '') {
            $emailid = $current_user->user_email;
        }
        $mailtext = $native_settings->get("email_confirm_email");//get_option("email_confirm_email");
        $subject = $native_settings->get('emailalertpro_Subject_Link');
		
        $subject = apply_filters('emailalertpro_custom_keywords', $subject);
        $subject = stripslashes(self::custom_keywords($subject));
        $mailtext = apply_filters('emailalertpro_custom_keywords', $mailtext);
        $mailtext = stripslashes(self::custom_keywords($mailtext));
        $mailtext = str_replace("[SUBSCRIBEREMAIL]", $emailid, $mailtext);
        $mailtext = self::activation_action_link($mailtext, 1);
        $mailtext = '<div style="width:60%;">' . $mailtext . '</div>';
        $mailheaders = $this->mailheaders();
        emailalertpro_send_email_to_user($emailid, $subject, $mailtext, $mailheaders, 'no');
    }

    function send_unsubscribe_email() {
        if ($emailid == '') {
            global $current_user;
            $emailid = $current_user->user_email;
        }
        $mailtext = get_option("emailalert_reminder_email_content");

        $subject = get_option('reminder_subject_line');

        $subject = apply_filters('emailalertpro_custom_keywords', $subject);

        $subject = stripslashes($this->custom_keywords($subject));

        $mailtext = apply_filters('emailalertpro_custom_keywords', $mailtext);

        $mailtext = stripslashes($this->custom_keywords($mailtext));

        $mailtext = $this->activation_action_link($mailtext, 1);

        $mailheaders = $this->mailheaders();

        emailalertpro_send_email_to_user($emailid, $subject, $mailtext, $mailheaders);
    }


    /**
     * 
     * @global type $current_user
     * @param type $type
     * @param type $attachments
     * @return string
     */
    function mailheaders($type = 'text', $attachments = array()) {
        global $current_user;
        $char_set = get_option('blog_charset');
        $header['From'] = $current_user->user_email;
        $header['Reply-To'] = $current_user->user_email;
        $header['Return-path'] = "<" . $current_user->user_email . ">";
        $header['Precedence'] = "list\nList-Id: " . html_entity_decode(get_option('blogname')) . "";

        if (empty($attachments) && $type == 'html') {
            // To send HTML mail, the Content-Type header must be set
            $header['Content-Type'] = get_option('html_type') . "; 
					charset=\"" . $char_set . "\"";
        } elseif (empty($attachments) && $type == 'text') {
            $header['Content-Type'] = "text/plain; 
					charset=\"" . $char_set . "\"";
        }


        foreach ($header as $key => $value) {
            $headers[$key] = $key . ": " . $value;
        }
        $headers = implode("\n", $headers);
        $headers .= "\n";
        return $headers;
    }

// end headers()

    /**
     * 
     * @param type $link
     * @return type
     */
    function get_tracking_link($link) {

        if (empty($link)) {
            return;
        }
        if (!empty($this->emailalertpro_options['tracking'])) {
            (strpos($link, '?') > 0) ? $delimiter .= '&' : $delimiter = '?';
            $tracking = $this->emailalertpro_options['tracking'];
            if (strpos($tracking, "{ID}")) {
                $id = url_to_postid($link);
                $tracking = str_replace("{ID}", $id, $tracking);
            }
            if (strpos($tracking, "{TITLE}")) {
                $id = url_to_postid($link);
                $title = urlencode(htmlentities(get_the_title($id), 1));
                $tracking = str_replace("{TITLE}", $title, $tracking);
            }
            return $link . $delimiter . $tracking;
        } else {
            return $link;
        }
    }

// end get_tracking_link()					

    function custom_keywords($string) {
	
        $this->permalink = home_url();
        if ('' == $string) {
            return;
        }
        $string = str_replace("[BLOGNAME]", get_option('blogname'), $string);
        $string = str_replace("[BLOGLINK]", get_option('home'), $string);
        //$string = str_replace("{TITLE}", stripslashes($this->post_title), $string);
        $link = "<a href=\"" . $this->get_tracking_link($this->permalink) . "\">" . $this->get_tracking_link($this->permalink) . "</a>";
        $string = str_replace("{PERMALINK}", $link, $string);
        
		if (strstr($string, "{TINYLINK}")) {
            $tinylink = file_get_contents('http://tinyurl.com/api-create.php?url=' . urlencode($this->get_tracking_link($this->permalink)));
            if ($tinylink !== 'Error' && $tinylink != false) {
                $tlink = "<a href=\"" . $tinylink . "\">" . $tinylink . "</a>";
                $string = str_replace("{TINYLINK}", $tlink, $string);
            } else {
                $string = str_replace("{TINYLINK}", $link, $string);
            }
        }
        //$string = str_replace("{DATE}", $this->post_date, $string);
        //$string = str_replace("{TIME}", $this->post_time, $string);
        //$string = str_replace("{MYNAME}", stripslashes($this->myname), $string);
        //$string = str_replace("{EMAIL}", $this->myemail, $string);
        //$string = str_replace("{AUTHORNAME}", stripslashes($this->authorname), $string);
        //$string = str_replace("{CATS}", $this->post_cat_names, $string);
        //$string = str_replace("{TAGS}", $this->post_tag_names, $string);
        //$string = str_replace("{COUNT}", $this->post_count, $string);
        return apply_filters('emailalertpro_custom_keywords', $string);
    }

    function activation_action_link($body, $id) {
        //extract($body);
        $activation = urlencode('activation');
        $link = apply_filters('emailalertpro_confirm_link', get_option('home')) . "/?emailalert=$activation";
        $link .= "&$activation=1";

        $link .= '&emailid=';
        $link .= $id;
        //$mailheaders = $this->headers();

        $body = str_replace("{LINK}", $link, $body);

        return $body;
        // sort the headers now so we have all substitute information
    }
}
$emailalertpro_templates = new emailalertpro_templates;
?>