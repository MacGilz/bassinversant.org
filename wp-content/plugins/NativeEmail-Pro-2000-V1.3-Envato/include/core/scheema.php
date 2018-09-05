<?php
        
// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;

add_action('emailalertpro_create_table','emailalertpro_create_table' , 10);	

function emailalertpro_create_table() {
	global $wpdb;
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

	$date = date('Y-m-d');
	$table_name = $wpdb->prefix . "emailalertpro";
	$table_name2 = $wpdb->prefix . "NativeEmail_sentlist";
	$table_name3 = $wpdb->prefix . "nativeemail_sentlist_settings";

	$sql = "CREATE TABLE IF NOT EXISTS $table_name(
		id int(11) NOT NULL auto_increment,
		email varchar(64) NOT NULL default '',
		cat_ids LONGTEXT NULL default '',
		post_type varchar(64) NOT NULL default '',
		category varchar(64) NULL default '',
		active tinyint(1) default 0,
		date DATE default '$date' NOT NULL,
		time TIME DEFAULT '00:00:00' NOT NULL,
		PRIMARY KEY (id) )";
		
    dbDelta($sql);
	
	$wpdb->query("ALTER TABLE `$table_name` CHANGE `cat_ids` `cat_ids` LONGTEXT NULL");


    $sql = "CREATE TABLE IF NOT EXISTS `$table_name2` (
				`id` int(100) NOT NULL AUTO_INCREMENT,
				`native_user_id` int(100) NOT NULL DEFAULT '0',
				`post_ids` LONGTEXT NOT NULL,
				PRIMARY KEY (`id`)
				);";
				
    dbDelta($sql);
    $sql = "CREATE TABLE IF NOT EXISTS `$table_name3` (
						`id` int(10) NOT NULL AUTO_INCREMENT,
						`log_settings_key_range` varchar(255) DEFAULT NULL,
						`log_settings_value` text,
						PRIMARY KEY (`id`)
					)";
    dbDelta($sql);

 
    if (!get_option('native_plugin_settings_key', false)) {
	
        $defaultValues = array(
		'emailalertpro_get_notification_status' => 'yes',
		'emailalertpro_get_sent_log_status' => 'no',
		'nativeemail_per_user_send' => 300,
		'emailalertpro_Subject_Link' => 'Subject text line',
		'email_confirm_email' => "Hello [SUBSCRIBEREMAIL],<br>
You have successfully subscribed to personalised email updates on [BLOGNAME]. <br>
Thank you!<br> 

Best Regards,<br>
Content Director,<br>
[BLOGNAME]<br>
[BLOGLINK]",
			'native_selected_term_type' => 'category',
			'native_selected_post_type' => 'post',
			'native_selected_term_fashion' => 'yes',
			'template_selection' => 3,
			'emailalertpro_template_font_family_name' => 'Arial, Helvetica, sans-serif',
			'emailalertpro_template_font_size' => 15,
			'emailalertpro_template_text_spacing' => 15,
			'emailalertpro_template_hfont_size' => 20,
			'emailalertpro_template_phone_section' => 'Additional Header Text!',
			'emailalertpro_template_email_subject' => 'Subject',
			'emailalertpro_template_header_title' => 'Title',
			'emailalertpro_template_header_section' => 'Heading Text',
			'emailalertpro_colorpicker_color_change' => 'A0CE4E',
			'emailalertpro_colorpicker_background_color' => 'e3e3e3',
			'emailalertpro_colorpicker_body_color' => 'ffffff',
			'emailalertpro_template_text_length' => 100,
			'emailalertpro_template_excerpt_length' => 50,
			'emailalertpro_template_readmore' => 'Read More',
			'emailalertpro_template_portfolio_text_box' => 'Text',
			'emailalertpro_template_portfolio_link_box' => 'View',
			'emailalertpro_template_footer_section' => 'Copyright Native Email 2015',
			'sendername' => get_option( "sendername", get_option('admin_email', 'test@gmail.com')),
			'get_number_post_send' => 4,
			'post_count'=>4,
			'emailalert_email_frequency' => get_option("EmailAlertPro_email_frequency" , "twicedaily"),
			'emailalert_send_most_viewd' => get_option("emailalert_send_most_viewd" , "all"),
        );

        $default_settings = array(
		'emailalertpro_get_notification_status' => get_option("emailalertpro_get_notification_status", $defaultValues['emailalertpro_get_notification_status']),
		'emailalertpro_get_sent_log_status' => get_option("emailalertpro_get_sent_log_status", $defaultValues['emailalertpro_get_sent_log_status']),
		'nativeemail_per_user_send' => 300,
		'emailalertpro_Subject_Link' => get_option('emailalertpro_Subject_Link', $defaultValues['emailalertpro_Subject_Link']),
		'email_confirm_email' => get_option("email_confirm_email", $defaultValues['email_confirm_email']),
		'native_selected_term_type' => get_option("native_selected_term_type", $defaultValues['native_selected_term_type']),
		'native_selected_post_type' => get_option("native_selected_post_type", $defaultValues['native_selected_post_type']),
		'native_selected_term_fashion' => get_option("native_selected_term_fashion", $defaultValues['native_selected_term_fashion']), //dought
		'template_selection' => 3,
		'emailalertpro_template_font_family_name' => $defaultValues['emailalertpro_template_font_family_name'],
		'emailalertpro_template_font_size' => $defaultValues['emailalertpro_template_font_size'],
		'emailalertpro_template_text_spacing' => $defaultValues['emailalertpro_template_text_spacing'],
		'emailalertpro_template_phone_section' => get_option("emailalertpro_template_phone_section", $defaultValues['emailalertpro_template_phone_section']),
		'emailalertpro_template_email_subject' => get_option("emailalertpro_template_email_subject", $defaultValues['emailalertpro_template_email_subject']),
		'emailalertpro_template_header_title' => get_option("emailalertpro_template_header_title", $defaultValues['emailalertpro_template_header_title']),
		'emailalertpro_template_header_section' => get_option("emailalertpro_template_header_section", $defaultValues['emailalertpro_template_header_section']),
		'emailalertpro_colorpicker_color_change' => get_option("emailalertpro_colorpicker_color_change", $defaultValues['emailalertpro_colorpicker_color_change']),
		'emailalertpro_colorpicker_background_color' => get_option("emailalertpro_colorpicker_background_color", $defaultValues['emailalertpro_colorpicker_background_color']),
		'emailalertpro_colorpicker_body_color' => get_option("emailalertpro_colorpicker_body_color", $defaultValues['emailalertpro_colorpicker_body_color']),
		'emailalertpro_template_text_length' => get_option("emailalertpro_template_text_length", $defaultValues['emailalertpro_template_text_length']),
		'emailalertpro_template_excerpt_length' => get_option("emailalertpro_template_excerpt_length", $defaultValues['emailalertpro_template_excerpt_length']),
		'emailalertpro_template_readmore' => get_option("emailalertpro_template_readmore", $defaultValues['emailalertpro_template_readmore']),
		'emailalertpro_template_portfolio_text_box' => get_option("emailalertpro_template_portfolio_text_box", $defaultValues['emailalertpro_template_portfolio_text_box']),
		'emailalertpro_template_portfolio_link_box' => get_option("emailalertpro_template_portfolio_link_box", $defaultValues['emailalertpro_template_portfolio_link_box']),
		'emailalertpro_template_footer_section' => get_option("emailalertpro_template_footer_section", $defaultValues['emailalertpro_template_footer_section']),
		'sendername' => get_option("sendername", $defaultValues['sendername']), //dought
		'get_number_post_send' => get_option("get_number_post_send", $defaultValues['get_number_post_send']), //dought
		'post_count'=> get_option("get_number_post_send", $defaultValues['get_number_post_send']), //dought
		'emailalert_email_frequency' => get_option("EmailAlertPro_email_frequency", $defaultValues['emailalert_email_frequency']),
		'emailalert_send_most_viewd' => get_option("emailalert_send_most_viewd", $defaultValues['emailalert_send_most_viewd']),
		'nativeemail_category_effect' => '16a1e6',
		'nativeemail_category_button_text' => 'ffffff',
		'nativeemail_category_align' => 'center',
		'nativeemail_button_text' => 'Subscribe To This Subject!',
		'nativeemail_popup_title' => 'Your Email',
		'nativeemail_category_text' => 'Enter your email to receive updates for this subject.',
		'emailalertpro_template_hfont_size' => 20,
    );      
        add_option('native_plugin_settings_key', $default_settings);
    }
}
?>