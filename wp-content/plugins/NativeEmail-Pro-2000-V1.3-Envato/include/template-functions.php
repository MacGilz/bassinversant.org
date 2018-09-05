<?php

// all funciton  that will handle email templates


function native_email_filter_content($content) {
    $content = apply_filters('the_content', $content);
    return $content;
}

function email_alert_pro_send_final_email($post = null, $post_objects = null, $registerd_user_id = null) {

    global $native_settings;

    if (empty($post) && empty($post_objects)) {
        do_action('emailalert_no_email_found_to_send');
        return array('status' => 'error', 'message' => 'No posts');
    }

    $selected_template = $native_settings->get('template_selection');

    if (!is_numeric($registerd_user_id) && $registerd_user_id != 'skip') {
        return array('status' => 'error', 'message' => 'invalid user id given' . $registerd_user_id);
    }

    if (empty($post_objects)) {
        return array('status' => 'error', 'message' => 'no posts found in system');
    }

    if ($selected_template == '' or ! is_numeric($selected_template))
        $selected_template = 'default';

	if(isset($_GET['t']) && $_GET['t'])
		$selected_template = $_GET['t'];
		
		
    switch ($selected_template) {
        case 1 :
            $return = email_alert_first_template($post, $post_objects);
            continue;
        case 2 :
            $return = email_alert_second_template($post, $post_objects);
            continue;
        case 3 :
            $return = email_alert_third_template($post, $post_objects);
            continue;
        case 4 :
            $return = email_alert_fourth_template($post, $post_objects);
            continue;
        case 5 :
            $return = email_alert_fifth_template($post, $post_objects);
            continue;
        default:
            $return = email_alert_default_template($post, $post_objects);
    }
    return $return;
}

function email_alert_template_header($post) {

    global $catepro_font_family, $native_settings;
    $font_family = $catepro_font_family;

    $img_dir = emailalert_url . 'assets/images';
    $admin_settings = new emailalertpro_templates;

    $length = (int)$native_settings->get("emailalertpro_template_excerpt_length");
    $length = ( $length >= 0 && is_numeric($length)) ? $length : 500;

    $date = current_time('j F , l ,Y');
    $date = current_time('l, F j, Y');
    $bgcolor = $native_settings->get('emailalertpro_colorpicker_color_change');
    $background_color = $native_settings->get('emailalertpro_colorpicker_background_color');
    $content_bg_color = $native_settings->get('emailalertpro_colorpicker_body_color');
    $phone_number = $native_settings->get('emailalertpro_template_phone_section');

    $email_alert_home_link = ($native_settings->get("email_alert_home_link") == '') ? $native_settings->get('site_url') : $native_settings->get("email_alert_home_link");

    $contact_link = $native_settings->get("email_alert_contact_link");
    $header_title_text = $native_settings->get('emailalertpro_template_header_title');
    $header_section = $native_settings->get("emailalertpro_template_header_section");


    $return = '<style> .mainContent img {max-width:300px;} </style>';
    $return .='	<tr><td height="30"></td></tr>
						<tr bgcolor="#' . $background_color . '">
							<td width="100%" align="center" valign="top" bgcolor="#' . $background_color . '">	
										<!---------   top header   ------------>
											<table border="0" width="600" cellpadding="0" cellspacing="0" align="center" class="container">
                    <tr>
                        <td style="line-height: 10px;background:#' . $bgcolor . '; height: 10px;"></td>
                    </tr>
                    
                    <tr bgcolor="#' . $bgcolor . '"><td height="5"></td></tr>
                    
                    <tr bgcolor="#' . $bgcolor . '">
	                    <td align="center">
	                    	<table border="0" width="560" align="center" cellpadding="0" cellspacing="0" class="container-middle">
	                    		<tr>
	                    			<td>
					                    <table border="0" align="left" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="top-header-left">
					                    	<tr>
					                    		<td align="center">
					                    			<table border="0" cellpadding="0" cellspacing="0" class="date">
					                    				<tr>
								                    		<td>
									                    		<img editable="true" mc:edit="icon1" width="13" height="13" style="display: block;" src="' . $img_dir . '/icon-cal.png" alt="icon 1" />
								                    		</td>
								                    		<td>&nbsp;&nbsp;</td>
								                    		<td mc:edit="date" style="color: #fefefe; font-size: 11px; font-weight: normal;font-family: ' . $font_family . ';">';
    $return.= $date;
    $return.='</td>
								                    	</tr>
				
					                    			</table>
					                    		</td>
					                    	</tr>
					                    </table>
					                    
					                    <table border="0" align="left" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="top-header-right">
					                    	<tr><td width="30" height="20"></td></tr>
					                    </table>
					                    
					                    <table border="0" align="right" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="top-header-right">
					                    	<tr>
					                    		<td align="center">
					                    			<table border="0" cellpadding="0" cellspacing="0" align="center" class="tel">
					                    				<tr>
								                    		<td>
									                    		
								                    		</td>
								                    		<td>&nbsp;&nbsp;</td>
								                    		<td mc:edit="tel" style="color: #fefefe; font-size: 11px; font-weight: normal; font-family: ' . $font_family . ';">';
    $return.= $phone_number;
    $return.='</td>
								                    	</tr>
					                    			</table>
					                    		</td>
					                    	</tr>					                    	
					                    </table>
	                    			</td>
	                    		</tr>
	                    	</table>
	                    </td>
                    </tr>
                    
                    <tr bgcolor="#' . $bgcolor . '"><td height="10"></td></tr>
                    
                </table>
								
                                <!----------    end top header    ------------>


                <!----------   main content----------->
                <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="container" bgcolor="' . $content_bg_color . '">


                        <!--------- Header  ---------->
                        <tr bgcolor="' . $content_bg_color . '"><td height="40"></td></tr>

                        <tr>
                                <td>
                                        <table border="0" width="560" align="center" cellpadding="0" cellspacing="0" class="container-middle">
                                                <tr>
                                                        <td>
                                                                <table border="0" align="left" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="logo">
                                                                        <tr>
                                                                                <td align="center">
                                                                                        <a href="" style="display: block; border-style: none !important; border: 0 !important;">
                                                                                        <img editable="true" mc:edit="logo"  border="0"  src="' . $admin_settings->email_get_header_image() . '" alt="' . get_option('blogname') . '"  style="object-fit:contain;max-width:200px;width:100%;" /></a>
                                                                                </td>
                                                                        </tr>
                                                                </table>		
                                                                <table border="0" align="left" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="nav">
                                                                        <tr>
                                                                                <td height="20" width="20"></td>
                                                                        </tr>
                                                                </table>
                                                                <table border="0" align="right" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="nav">
                                                                        <tr><td height="10"></td></tr>
                                                                        <tr>
                                                                                <td align="center" mc:edit="navigation" style="font-size: 13px; font-family: ' . $font_family . ';">
                                                                                        <multiline>';


    $return.='<a style="text-decoration: none; color: #a4a4a4" href="' . $email_alert_home_link . '">Home</a>
                                                                                                <span style="text" class="navSpac">&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                                                                <a style="text-decoration: none; color: #a4a4a4" href="' . $contact_link . '">Contact</a>
                                                                                        </multiline>
                                                                                </td>
                                                                        </tr>
                                                                </table>
                                                        </td>
                                                </tr>
                                        </table>
                                </td>
                        </tr>

                        <tr bgcolor="' . $content_bg_color . '"><td height="40"></td></tr>
                        <!---------- end header --------->


                        <!--------- main section --------->                	
                        <tr>
                                <td>
                                        <table border="0" width="560" align="center" cellpadding="0" cellspacing="0" class="container-middle">
                                                <tr><td align="center" style="line-height: 6px;">
                                                <img style="display: block;" width="560" height="6" src="' . $img_dir . '/top-rounded-bg.png" alt="" class="top-bottom-bg" /></td></tr>
                                                <tr bgcolor="ffffff"><td height="7"></td></tr>
                                                <tr bgcolor="ffffff"><td height="20"></td></tr>
                                                <tr bgcolor="ffffff">
                                                        <td>
                                                                <table width="528" border="0" align="center" cellpadding="0" cellspacing="0" class="mainContent" style="text-align:center;">
                                                                        <tr>	
                                                                                <td mc:edit="title1" class="main-header" style="color: #484848; font-size: 16px; font-weight: normal; font-family: ' . $font_family . ';">
                                                                                        <multiline>';
    $return.= stripslashes($header_title_text);
    $return.='</multiline>
                                                                                </td>
                                                                        </tr>
                                                                        <tr><td height="20"></td></tr>
                                                                        <tr>
                                                                                <td mc:edit="subtitle1" class="main-subheader" style="color: #a4a4a4; font-size: 12px; font-weight: normal; font-family: ' . $font_family . ';">
                                                                                        <multiline>';
    $return.= stripslashes($header_section);
    $return.= '</multiline>
                                                                                </td>
                                                                        </tr>
                                                                </table>
                                                        </td>
                                                </tr>
                                                <tr bgcolor="ffffff"><td height="25"></td></tr>
                                                <tr>
                                                        <td align="center" style="line-height: 6px;">
                                                        <img style="display: block;" width="560" height="6" src="' . $img_dir . '/bottom-rounded-bg.png" alt="" class="top-bottom-bg" /></td>
                                                </tr>
                                        </table>
                                </td>
                        </tr><!--------- end main section --------->';
    return $return;
}

function email_alert_template_footer($post) {

    global $catepro_font_family, $native_settings;
    $core = new emailalertpro_core_email;
    $admin_settings = new emailalertpro_templates;

    $font_family = $catepro_font_family;

    $img_dir = emailalert_url . 'assets/images/';


    $bgcolor = $native_settings->get("emailalertpro_colorpicker_color_change");

    $return = '';
    $return .='<!---------- prefooter  --------->
                	
                	<tr><td height="40"></td></tr>
                	<tr>
                		<td align="center" mc:edit="copy1" style="color: #939393; font-size: 11px; font-weight: normal; font-family: ' . $font_family . ';" class="prefooter-header">';
    $return.= $core->emailalert_unsubscription_link();
    $return.='</td>
                	</tr>
                	<tr><td height="30"></td></tr>
                	
                	<tr><td height="30"></td></tr>
					
                </table>
                <!------------ end main Content ----------------->
                
                                
                <!---------- footer  --------->
                <table border="0" width="600" cellpadding="0" cellspacing="0" align="center" class="container">
					<tr bgcolor="' . $bgcolor . '"><td height="14"></td></tr>
                	<tr bgcolor="' . $bgcolor . '">
                		<td mc:edit="copy3" align="center" style="color: #fefefe; font-size: 11px; font-weight: normal; font-family: ' . $font_family . ';">			<multiline>';
    $return.= stripslashes($native_settings->get("emailalertpro_template_footer_section"));
    $return.='</multiline>
                		</td>
                	</tr>
                	<tr bgcolor="' . $bgcolor . '"><td height="14"></td></tr>
                	<tr>
                        <td style="line-height: 10px;"></td>
                    </tr>
                </table>
                <!---------  end footer --------->
            </td>
        </tr>';
    return $return;
}

function email_alert_first_template($post, $post_objects = null) {
    global $catepro_font_family, $native_settings;
    $font_family = $catepro_font_family;
	
    $img_dir = emailalert_url . 'assets/images';
    $admin_settings = new emailalertpro_templates;

    $length = (int)$native_settings->get("emailalertpro_template_excerpt_length");
    $length = ( $length >= 0 && is_numeric($length)) ? $length : 500;

    $readmore = $native_settings->get("emailalertpro_template_readmore");
	
    $background_color = $native_settings->get("emailalertpro_colorpicker_background_color");
	$return = '';
    $return.='<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<!-- Define Charset -->
				<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
				
				<!-- Responsive Meta Tag -->
				<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">

    <title>Native Email Template</title><!-- Responsive Styles and Valid Styles -->

    <style type="text/css">
    	
	    body{
            width: 100%; 
            background-color: #' . $background_color . '; 
            margin:0; 
            padding:0; 
            -webkit-font-smoothing: antialiased;
        }
        p,h1,h2,h3,h4{
	        margin-top:0;
			margin-bottom:0;
			padding-top:0;
			padding-bottom:0;
        }
        html{
            width: 100%; 
        }
        
        table{
            font-size: 14px;
            border: 0;
        }
        
        /* ----------- responsivity ----------- */
        @media only screen and (max-width: 640px){
        
            /*------ top header ------ */
            .header-bg{width: 440px !important; height: 10px !important;}
            .main-header{line-height: 28px !important;}
            .main-subheader{line-height: 28px !important;}
            
            .container{width: 440px !important;}
            .container-middle{width: 420px !important;}
            .mainContent{width: 400px !important;}
            
            .main-image{width: 400px !important; height: auto !important;}
            .banner{width: 400px !important; height: auto !important;}
            /*------ sections ---------*/
            .section-item{width: 400px !important;}
            .section-img{width: 400px !important; height: auto !important;}
            /*------- prefooter ------*/
            .prefooter-header{padding: 0 10px !important; line-height: 24px !important;}
            .prefooter-subheader{padding: 0 10px !important; line-height: 24px !important;}
            /*------- footer ------*/
            .top-bottom-bg{width: 420px !important; height: auto !important;}
            
        }
        
        @media only screen and (max-width: 479px){
        
        	/*------ top header ------ */
            .header-bg{width: 280px !important; height: 10px !important;}
            .top-header-left{width: 260px !important; text-align: center !important;}
            .top-header-right{width: 260px !important;}
            .main-header{line-height: 28px !important; text-align: center !important;}
            .main-subheader{line-height: 28px !important; text-align: center !important;}
            
            /*------- header ----------*/
            .logo{width: 260px !important;}
            .nav{width: 260px !important;}
            
            .container{width: 280px !important;}
            .container-middle{width: 260px !important;}
            .mainContent{width: 240px !important;}
            
            .main-image{width: 240px !important; height: auto !important;}
            .banner{width: 240px !important; height: auto !important;}
            /*------ sections ---------*/
            .section-item{width: 240px !important;}
            .section-img{width: 240px !important; height: auto !important;}
            /*------- prefooter ------*/
            .prefooter-header{padding: 0 10px !important;line-height: 28px !important;}
            .prefooter-subheader{padding: 0 10px !important; line-height: 28px !important;}
            /*------- footer ------*/
            .top-bottom-bg{width: 260px !important; height: auto !important;}
            
	    }
    </style>
    
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
	<table border="0" width="100%" cellpadding="0" cellspacing="0">';

    $return .= email_alert_template_header($post);
    $return .= '<tr><td height="35"></td></tr>
                	
                	<tr><td height="35"></td></tr>
                	</layout>';
    if (!empty($post_objects))
        foreach ($post_objects as $key => $post_object) {
		$thumbnail_url = $admin_settings->emailalert_get_post_thumbnailimage( $post_object->ID );
		
		$content = wp_trim_words($post_object->post_content, $length, '');
		$readmorelink = $admin_settings->displayreadmorelink( $readmore , get_the_permalink($post_object->ID));
        $content = $admin_settings->emailalert_short_content($content, $length, $readmorelink);
        $content = native_email_filter_content($content);

			
            $return.='
			<!--<layout label="new-feature">--->
                	<tr>
                            <td>
                                <table border="0" width="560" align="center" cellpadding="0" cellspacing="0" class="container-middle">
                                    <tr><td align="center" style="line-height: 6px;"><img style="display: block;" width="560" height="6" src="' . $img_dir . '/top-rounded-bg.png" alt="" class="top-bottom-bg" /></td></tr>
                                    <tr bgcolor="ffffff">
                                        <td>
                                            <table width="528" border="0" align="center" cellpadding="0" cellspacing="0" class="mainContent" >
                                                <tr><td height="20"></td></tr>
                                                <tr>
                                                        <td>
                                                            <table border="0" align="left" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="section-item">
                                                                    <tr><td height="6"></td></tr>
                                                                    <tr>
                                                                            <td>
                   <a href="' . get_the_permalink($post_object->ID) . '" style="width: 128px; display: block; border-style: none !important; border: 0 !important;">';
            //if ($thumbnail_url == '')
                $return .= '<img src="' . $thumbnail_url . '" height="128" width="113" class="section-img" alt="nativeemail">';
            	
            $return .= '</a></td>
                                </tr>
                                <tr><td height="10"></td></tr>
                        </table>

                        <table border="0" align="left" width="10" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
                                <tr><td height="30" width="10"></td></tr>
                        </table>

                        <table border="0" width="360" align="right" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="section-item">
                                <tr>
                                        <td mc:edit="title2" style="color: #484848; font-size: 16px; font-weight: normal; font-family: ' . $font_family . ';">
                                                <multiline>';
            $return.= $admin_settings->emailalert_short_title($post_object->post_title);
            $return.='</multiline>
                                    </td>
                            </tr>
                            <tr><td height="15"></td></tr>
                            <tr>
                                    <td mc:edit="subtitle2" style="color: #a4a4a4;  font-size: ' . $native_settings->get("emailalertpro_template_font_size", "12") . 'px; line-height: '.$native_settings->get("emailalertpro_template_text_spacing", "25") . 'px; font-weight: normal; font-family: ' . $font_family . ';">
                                            <multiline>';
            
            $return.= $content;
			$return.='</multiline>
                											</td>
                										</tr>
                										<tr><td height="15"></td></tr>
                										
                									</table>
                								</td>
                							</tr>
                							<tr><td height="20"></td></tr>
                						</table>	
                					</td>
                				</tr>
                				<tr><td align="center" style="line-height: 6px;">
								<img style="display: block;" width="560" height="6" src="' . $img_dir . '/bottom-rounded-bg.png" alt="" class="top-bottom-bg" />
								</td></tr>
                			</table>
                		</td>
                	</tr><!--------- end section 1 --------->
                	<tr><td height="35"></td></tr>
                	<!--</layout>-->';
        }
    $return .= email_alert_template_footer($post);
    $return .= '</table>
	</body>
</html>';
//die($return);
    return $return;
}

function email_alert_second_template($post, $post_objects = null) {

    global $catepro_font_family, $native_settings;

    $font_family = $catepro_font_family;
    $img_dir = emailalert_url . 'assets/images';
    $admin_settings = new emailalertpro_templates;

    $background_color = $native_settings->get("emailalertpro_colorpicker_background_color");
    $readmore = $native_settings->get("emailalertpro_template_readmore");
	
    $length = (int)$native_settings->get("emailalertpro_template_excerpt_length");
    $length = ( $length >= 0 && is_numeric($length)) ? $length : 500;

    $output = '';

    $return = '';

    $return = '<!DOCTYPE HTML>
			<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<!-- Define Charset -->
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<!-- Responsive Meta Tag -->
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">

    <title>Native Email Template</title><!-- Responsive Styles and Valid Styles -->

    <style type="text/css">
    	
	    body{
            width: 100%; 
            background-color: #' . $background_color . '; 
            margin:0; 
            padding:0; 
            -webkit-font-smoothing: antialiased;
        }
        p,h1,h2,h3,h4{
	        margin-top:0;
			margin-bottom:0;
			padding-top:0;
			padding-bottom:0;
        }
        html{
            width: 100%; 
        }
        
        table{
            font-size: 14px;
            border: 0;
        }
        
        
        @media only screen and (max-width: 640px){
        
            
            .header-bg{width: 440px !important; height: 10px !important;}
            .main-header{line-height: 28px !important;}
            .main-subheader{line-height: 28px !important;}
            
            
            .feature{width: 420px !important;}
            .feature-middle{width: 400px !important; text-align: center !important;}
            .feature-img{width: 400px !important; height: auto !important;}
            
            .container{width: 440px !important;}
            .container-middle{width: 420px !important;}
            .mainContent{width: 400px !important;}
            
            .main-image{width: 400px !important; height: auto !important;}
            .banner{width: 400px !important; height: auto !important;}
            
            .section-item{width: 400px !important;}
            .section-img{width: 400px !important; height: auto !important;}
            
            .prefooter-header{padding: 0 10px !important; line-height: 24px !important;}
            .prefooter-subheader{padding: 0 10px !important; line-height: 24px !important;}
            
            .top-bottom-bg{width: 420px !important; height: auto !important;}
            
        }
        
        @media only screen and (max-width: 479px){
        
        	
            .header-bg{width: 280px !important; height: 10px !important;}
            .top-header-left{width: 260px !important; text-align: center !important;}
            .top-header-right{width: 260px !important;}
            .main-header{line-height: 28px !important; text-align: center !important;}
            .main-subheader{line-height: 28px !important; text-align: center !important;}
            
            
            .logo{width: 260px !important;}
            .nav{width: 260px !important;}
            
            
            .feature{width: 260px !important;}
            .feature-middle{width: 240px !important; text-align: center !important;}
            .feature-img{width: 240px !important; height: auto !important;}

            
            .container{width: 280px !important;}
            .container-middle{width: 260px !important;}
            .mainContent{width: 240px !important;}
            
            .main-image{width: 240px !important; height: auto !important;}
            .banner{width: 240px !important; height: auto !important;}
            
            .section-item{width: 240px !important;}
            .section-img{width: 240px !important; height: auto !important;}
            
            .prefooter-header{padding: 0 10px !important;line-height: 28px !important;}
            .prefooter-subheader{padding: 0 10px !important; line-height: 28px !important;}
            
            .top-bottom-bg{width: 260px !important; height: auto !important;}
            
	    }
	    
	    
    </style>
    
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
	<table border="0" width="100%" cellpadding="0" cellspacing="0">';
    $return .= email_alert_template_header($post);

    $return .= '<tr><td height="35"></td></tr>
                	<!--------- Features Section start --------->
					<tr>
                		<td>
                			<table border="0" width="560" align="center" cellpadding="0" cellspacing="0" class="container-middle 1">';
    $return .= '<tr>
											<td>';

    if (!empty($post_objects))
        foreach ($post_objects as $key => $post_object) {
		        
				$content = wp_trim_words($post_object->post_content, $length, '');
				$readmorelink = $admin_settings->displayreadmorelink( $readmore , get_the_permalink($post_object->ID));
                $content = $admin_settings->emailalert_short_content($content, $length, $readmorelink);
                $content = native_email_filter_content($content);
				
				$thumbnail_url = $admin_settings->emailalert_get_post_thumbnailimage( $post_object->ID );
				
            if ($key < 3) {
                $return.='<!-- feature 1 -->
                						<table width="170" bgcolor="ffffff" align="left" cellspacing="0" cellpadding="0" border="0" class="feature" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
                							<tbody><tr>
											<td align="center" style="line-height: 6px;">
												<img width="170" height="6" class="top-bottom-bg" alt="" src="' . $img_dir . '/top-rounded-bg.png" style="display: block;"></td></tr>
                							<tr><td height="25"></td></tr>
                							<tr>
                								<td align="center">
                									<table width="150" align="center" cellspacing="0" cellpadding="0" border="0" class="feature-middle">
                										
			                							<tbody><tr>
			                								<td align="center">
															<a href="' . get_the_permalink($post_object->ID) . '">';
		if ($thumbnail_url) {
					$thumbnail = '<img editable="true" mc:edit="feature-img1" style="display: block;" width="100" height="104" src="' . $thumbnail_url . '" alt="feature image1" class="feature-img" />';
				}
                
                $return.= $thumbnail;
                $return.='</a></td>
				</tr>
				<tr><td height="25"></td></tr>
				<tr>
				<td align="center" style="color: #484848; font-size: 16px; font-weight: normal;font-family: ' . $font_family . ';" mc:edit="title2">
				
				<multiline>';
                $return.= $admin_settings->emailalert_short_title($post_object->post_title);
                $return.='</multiline>
				                							</td>
			                							</tr>
			                							<tr><td height="15"></td></tr>
			                							<tr>
				                							<td style="color: #a4a4a4; font-size: ' . $native_settings->get("emailalertpro_template_font_size", "12") . 'px; line-height: ' . $native_settings->get("emailalertpro_template_text_spacing", "25") . 'px; font-weight: normal; font-family: ' . $font_family . ';" mc:edit="subtitle2">
					                							<multiline>';
                if ($readmore == '') {
                    $readmorelink = '<a style="display: block; width: 80px; border-style: none !important; border: 0 !important;" href="' . get_the_permalink($post_object->ID) . '">
										<img width="80" height="26" border="0" alt="read more" src="' . $img_dir . '/readmore-btn.png" style="display: block;" mc:edit="readMoreBtn" editable="true">
									</a>';
                } else {
                    //$readmorelink = '<a href="' . get_the_permalink($post_object->ID) . '">' . $readmore . '</a>';
					$readmorelink = $admin_settings->displayreadmorelink( $readmore , get_the_permalink($post_object->ID));
                }
				

                $return.= $content;

                $return.='</multiline>
				                							</td>
			                							</tr>
			                							<tr><td height="10"></td></tr>
														<tr><td height="10"></td></tr>
			                							<tr><td height="10"></td></tr>
			                							<tr><td height="20"></td></tr>
                									</tbody></table>
                								</td>
                							</tr>
                							<tr><td align="center" style="line-height: 6px;"><img width="170" height="6" class="top-bottom-bg" alt="" src="' . $img_dir . '/bottom-rounded-bg.png" style="display: block;"></td></tr>
                						</tbody></table><!-- end feature 1 -->
                						<table align="left" cellspacing="0" cellpadding="0" border="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
                							<tbody><tr>
                								<td width="20" height="30"></td>
                							</tr>
                						</tbody></table>';
            } else {

                $output .= '<tr>
                		<td>
                			<table border="0" width="560" align="center" cellpadding="0" cellspacing="0" class="container-middle">
                				<tr><td align="center" style="line-height: 6px;"><img style="display: block;" width="560" height="6" src="' . $img_dir . '/top-rounded-bg.png" alt="" class="top-bottom-bg" /></td></tr>
                				<tr bgcolor="ffffff">
                					<td>
                						<table width="528" border="0" align="center" cellpadding="0" cellspacing="0" class="mainContent">
                							<tr><td height="20"></td></tr>
                							<tr>
                								<td>';
                //$thumbnail_url = wp_get_attachment_url(get_post_thumbnail_id($post_object->ID));
				

                if ($thumbnail_url != '') {
                    $output .='<table border="0" align="left" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="section-item">
                										<tr><td height="6"></td></tr>
                										<tr>
                											<td>
																	<a href="' . get_the_permalink($post_object->ID) . '" style="width: 128px; display: block; border-style: none !important; border: 0 !important;">';
                    $output .= '<img editable="true" mc:edit="image1" style="display: block;" width="128" height="113" src="' . $thumbnail_url . '" alt="image1" class="section-img"   />';
                    $output.= '</a>
													</td>
                										</tr>
                										<tr><td height="10"></td></tr>
                									</table>
                									
                									<table border="0" align="left" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
                										<tr><td height="30" width="10"></td></tr>
                									</table>';
                }

                $output.='<table border="0" width="360" align="left" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="section-item">
                										<tr>
                											<td mc:edit="title5" style="color: #484848; font-size: 16px; font-weight: normal; font-family: ' . $font_family . ';">
	                											<multiline>';
                $output.= $admin_settings->emailalert_short_title($post_object->post_title);
                $output.= '</multiline>
                											</td>
                										</tr>
                										<!---<tr><td height="15"></td></tr>---->
                										<tr>
                											<td mc:edit="subtitle5" style="color: #a4a4a4; font-size: ' . $native_settings->get("emailalertpro_template_font_size", "12") . 'px; line-height: ' . $native_settings->get("emailalertpro_template_text_spacing", "25") . 'px; font-weight: normal; font-family: ' . $font_family . ';">
                												<multiline>';
				$output.= $content;

                $output.= '</multiline>
                											</td>
                										</tr>
                										<tr><td height="15"></td></tr>
                									</table>
                								</td>
                							</tr>
                							
                							<tr><td height="20"></td></tr>
                							
                						</table>
                					</td>
                				</tr>
                				
                				<tr><td align="center" style="line-height: 6px;"><img style="display: block;" width="560" height="6" src="' . $img_dir . '/bottom-rounded-bg.png" alt="" class="top-bottom-bg" /></td></tr>
                				
                			</table>
                		</td>
                	</tr><!--------- end section 1 --------->
					<tr><td height="20"></td></tr>';
            }
        }

    $return.='</tr>
                					</td>
								<tr><td height="35"></td></tr>';
    $return .= $output;
    $return .= '<!--------- section 1 --------->';
    $return .='<!--------- end section 1 second template--------->                	
                	<tr><td height="35"></td></tr>';
    $return .= email_alert_template_footer($post);
    $return .= '</table>
					</td>
					</tr>
				</table>	
			</body>
		</html>';
//die($return);
    return $return;
}

function email_alert_third_template($post, $post_objects = null) {

    global $catepro_font_family, $native_settings;
    $font_family = $catepro_font_family;

    $img_dir = emailalert_url . 'assets/images';
    $admin_settings = new emailalertpro_templates;

    $background_color = $native_settings->get("emailalertpro_colorpicker_background_color");
    $readmore = $native_settings->get("emailalertpro_template_readmore");
	
    $length = (int)$native_settings->get("emailalertpro_template_excerpt_length");
    $length = ( $length >= 0 && is_numeric($length)) ? $length : 500; 

    $return = '';
    $return = '<!DOCTYPE HTML>
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	
	<!-- Define Charset -->
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	
	<!-- Responsive Meta Tag -->
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
		<title>Native Email Template</title><!-- Responsive Styles and Valid Styles -->
		<style type="text/css">
	    body{
            width: 100%; 
            background-color:#'.$background_color.'; 
            margin:0; 
            padding:0; 
            -webkit-font-smoothing: antialiased;
        }
        
        html{
            width: 100%; 
        }
        
        table{
            font-size: 14px;
            border: 0;
        }
        
        /* ----------- responsivity ----------- */
        @media only screen and (max-width: 640px){
        
            /*------ top header ------ */
            .header-bg{width: 440px !important; height: 10px !important;}
            .main-header{line-height: 28px !important;}
            .main-subheader{line-height: 28px !important;}
            
            /*----- --features ---------*/
            .feature{width: 420px !important;}
            .feature-middle{width: 400px !important; text-align: center !important;}
            .feature-img{width: 400px !important; height: auto !important;}
            
            .container{width: 440px !important;}
            .container-middle{width: 420px !important;}
            .mainContent{width: 400px !important;}
            
            .main-image{width: 400px !important; height: auto !important;}
            .banner{width: 400px !important; height: auto !important;}
            /*------ sections ---------*/
            .section-item{width: 400px !important;}
            .section-img{width: 400px !important; height: auto !important;}
            /*------- prefooter ------*/
            .prefooter-header{padding: 0 10px !important; line-height: 24px !important;}
            .prefooter-subheader{padding: 0 10px !important; line-height: 24px !important;}
            /*------- footer ------*/
            .top-bottom-bg{width: 420px !important; height: auto !important;}
            
        }
        
        @media only screen and (max-width: 479px){
        
        	/*------ top header ------ */
            .header-bg{width: 280px !important; height: 10px !important;}
            .top-header-left{width: 260px !important; text-align: center !important;}
            .top-header-right{width: 260px !important;}
            .main-header{line-height: 28px !important; text-align: center !important;}
            .main-subheader{line-height: 28px !important; text-align: center !important;}
            
            /*------- header ----------*/
            .logo{width: 260px !important;}
            .nav{width: 260px !important;}
            
            /*----- --features ---------*/
            .feature{width: 260px !important;}
            .feature-middle{width: 240px !important; text-align: center !important;}
            .feature-img{width: 240px !important; height: auto !important;}

            
            .container{width: 280px !important;}
            .container-middle{width: 260px !important;}
            .mainContent{width: 240px !important;}
            
            .main-image{width: 240px !important; height: auto !important;}
            .banner{width: 240px !important; height: auto !important;}
            /*------ sections ---------*/
            .section-item{width: 240px !important;}
            .section-img{width: 240px !important; height: auto !important;}
            /*------- prefooter ------*/
            .prefooter-header{padding: 0 10px !important;line-height: 28px !important;}
            .prefooter-subheader{padding: 0 10px !important; line-height: 28px !important;}
            /*------- footer ------*/
            .top-bottom-bg{width: 260px !important; height: auto !important;}
            
	    }
		</style>
		
	</head>
	
	<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
		<table border="0" width="100%" cellpadding="0" cellspacing="0">';
    $return .= email_alert_template_header($post);
    $return .= '<tr mc:repeatable><td height="35"></td></tr>';
    $i = 1;
    foreach ( $post_objects as $key => $post_object) {
			$content = wp_trim_words($post_object->post_content, $length, '');
            $readmorelink = $admin_settings->displayreadmorelink( $readmore , get_the_permalink($post_object->ID));
			$content = $admin_settings->emailalert_short_content($content, $length, $readmorelink);
			
			$content = native_email_filter_content($content);
			
			$thumbnail_url = $admin_settings->emailalert_get_post_thumbnailimage($post_object->ID);

        $return.='<!-- feature 1 -->';

        if ($i == 1) {

            $i++;
            $return .= '
	  <!--------- Features --------->
					<tr mc:repeatable>
                		<td>
                			<table border="0" width="560" align="center" cellpadding="0" cellspacing="0" class="container-middle">
                				<tr>
                					<td>';
            $return.='<table border="0" width="270" align="left" cellpadding="0" cellspacing="0" bgcolor="ffffff" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="feature">
                							<tr><td align="center" style="line-height: 6px;"><img style="display: block; " width="270" height="6" src="' . $img_dir . '//top-rounded-bg.png" alt="" class="top-bottom-bg" /></td></tr>
                							<tr><td height="25"></td></tr>
                							<tr>
                								<td align="center">
                									<table border="0" width="250" align="center" cellpadding="0" cellspacing="0" class="feature-middle">
			                							<tr>
			                								<td align="center">';
            
			
				$return.= '<a href="' . get_the_permalink($post_object->ID) . '">';
            if (!empty($thumbnail_url)) {
                $return.= '<img editable="true" mc:edit="image1" style="display: block;" width="128" height="128" src="' . $thumbnail_url . '" alt="image1" class="feature-img" />';
                //$return .= $thumbnail;
            } else {
                $return .='<img editable="true" mc:edit="image1" style="display: block;" width="128" height="128" src="' . $img_dir . '/image1.png" alt="image1" class="feature-img" />';
            }
			$return.= '</a>';
            $return.='</td>
			                							</tr>
			                							<tr><td height="25"></td></tr>
			                							<tr>
				                							<td align="center" mc:edit="title2" style="color: #484848; font-size: 16px; font-weight: normal; font-family: ' . $font_family . ';">';
            $return.= $admin_settings->emailalert_short_title($post_object->post_title);

            $return.= '</td>
			                							</tr>
			                							<tr><td height="15"></td></tr>
			                							<tr>
				                							<td align="center" mc:edit="subtitle2" style="color: #484848;   font-size: ' . $native_settings->get("emailalertpro_template_font_size", "12") . 'px; line-height: ' . $native_settings->get("emailalertpro_template_text_spacing", "25") . 'px; font-weight: normal; font-family: ' . $font_family . ';">';
            if (trim($readmore) == '') {
                $readmorelink = '<a style="display: block; width: 80px; border-style: none !important; border: 0 !important;" href="' . get_the_permalink($post_object->ID) . '">
																				<img width="80" height="26" border="0" alt="read more" src="' . $img_dir . '/readmore-btn.png" style="display: block;" mc:edit="readMoreBtn" editable="true">
																			</a>';
            } else {
			$readmorelink = $admin_settings->displayreadmorelink( $readmore , get_the_permalink($post_object->ID));

                //$readmorelink = '<a href="' . get_the_permalink($post_object->ID) . '">' . $readmore . '</a>';
            }
            
            $return .= $content;
			$return.='</td>
			                							</tr>
			                							<tr><td height="10"></td></tr>			                						
			                							<tr><td height="20"></td></tr>
                									</table>
                								</td>
                							</tr>
                							<tr><td align="center" style="line-height: 6px;">
												<img src="' . $img_dir . '/bottom-rounded-bg.png" alt="" class="top-bottom-bg" style="display: block;" width="270px" height="6px" /></td></tr>
                						</table><!-- end feature 1 -->
                						
                						<table border="0" align="left" width="5" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
                							<tr>
                								<td height="30" width="5"></td>
                							</tr>
                						</table>';
        } else {
            $i = 1;

            $return.='<!-- feature 2 -->
										<table border="0" width="270" align="right" cellpadding="0" cellspacing="0" bgcolor="ffffff" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="feature">
                							<tr><td align="center" style="line-height: 6px;"><img style="display: block;" width="270" height="6" src="' . $img_dir . '/top-rounded-bg.png" alt="" class="top-bottom-bg" /></td></tr>
                							<tr><td height="25"></td></tr>
                							<tr>
                								<td align="center">
                									<table border="0" width="250" align="center" cellpadding="0" cellspacing="0" class="feature-middle">
                										
			                							<tr>
			                								<td align="center">
															<a href="' . get_the_permalink($post_object->ID) . '">';

            

            if (!empty($thumbnail_url)) {
                $return.= '<img editable="true" mc:edit="image1" style="display: block;" width="128" height="128" src="' . $thumbnail_url . '" alt="image1" class="feature-img" />';
                //$return .= $thumbnail;
            } else {
                $return .='<img editable="true" mc:edit="image1" style="display: block;" width="128" height="128" src="' . $img_dir . '/image1.png" alt="image1" class="feature-img" />';
            }
            $return.='
															</a>
															</td>
			                							</tr>
			                							<tr><td height="25"></td></tr>
			                							<tr>
				                							<td align="center" mc:edit="title3" style="color: #484848; font-size: 16px; font-weight: normal; font-family: ' . $font_family . ';">';
            $return.= $title = $admin_settings->emailalert_short_title($post_object->post_title);
            $return.= '</td>
			                							</tr>
			                							<tr><td height="15"></td></tr>
			                							<tr>
				                							<td align="center" mc:edit="subtitle3" style="color: #484848;  font-size: ' . $native_settings->get("emailalertpro_template_font_size", "12") . 'px; line-height: ' . $native_settings->get("emailalertpro_template_text_spacing", "25") . 'px; font-weight: normal; font-family: ' . $font_family . ';">';
            $return.= $content;

            $return.='</td>
			                							</tr>
			                							<tr><td height="10"></td></tr>	
			                							<tr><td height="20"></td></tr>
                									</table>
                								</td>
                							</tr>
                							<tr><td align="center" style="line-height: 6px;"><img style="display: block;" width="270" height="6" src="' . $img_dir . '/bottom-rounded-bg.png" alt="" class="top-bottom-bg" /></td></tr>
                						</table><!-- end feature 2 -->';


            $return.= '</td></tr></table></td></tr>
					<tr mc:repeatable=""><td height="35"></td></tr>
					';
        }
    }
    $return.='';
    $return .= email_alert_template_footer($post);
    $return .= '</table>
			</body>
		</html>';
    //die($return);
    return $return;
}

function email_alert_fourth_template($post, $post_objects = null) {
    global $catepro_font_family, $native_settings;
    $font_family = $catepro_font_family;

    $img_dir = emailalert_url . 'assets/images';
    $admin_settings = new emailalertpro_templates;

    $background_color = $native_settings->get("emailalertpro_colorpicker_background_color");
    $readmore = $native_settings->get("emailalertpro_template_readmore");
	
    $length = (int)$native_settings->get("emailalertpro_template_excerpt_length");
    $length = ( $length >= 0 && is_numeric($length)) ? $length : 500;



    $return = '';
    $return = '<!DOCTYPE HTML>
				<html xmlns="http://www.w3.org/1999/xhtml">
				<head>
				<!-- Define Charset -->
				<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
				
				<!-- Responsive Meta Tag -->
				<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
				
					<title>Campaigner - Responsive Email Template</title><!-- Responsive Styles and Valid Styles -->
				
					<style type="text/css">
					  body{
				width: 100%; 
				background-color: #' . $background_color . '; 
				margin:0; 
				padding:0; 
				-webkit-font-smoothing: antialiased;
        }
        
        html{
            width: 100%; 
        }
        
        table{
            font-size: 14px;
            border: 0;
        }
        
        /* ----------- responsivity ----------- */
        @media only screen and (max-width: 640px){
        
            /*------ top header ------ */
            .header-bg{width: 440px !important; height: 10px !important;}
            .main-header{line-height: 28px !important;}
            .main-subheader{line-height: 28px !important;}
            
            /*----- --features ---------*/
            .feature-img{width: 440px !important;}
            .feature-text{width: 440px !important;}
            .feature-middle{width: 420px !important;}
            .feature-img{width: 440px !important; height: auto !important;}
            
            .container{width: 440px !important;}
            .container-middle{width: 420px !important;}
            .mainContent{width: 400px !important;}
            
            .main-image{width: 400px !important; height: auto !important;}
            .banner{width: 400px !important; height: auto !important;}
            /*------ sections ---------*/
            .section-item{width: 400px !important;}
            .section-img{width: 400px !important; height: auto !important;}
            /*------- prefooter ------*/
            .prefooter-header{padding: 0 10px !important; line-height: 24px !important;}
            .prefooter-subheader{padding: 0 10px !important; line-height: 24px !important;}
            /*------- footer ------*/
            .top-bottom-bg{width: 420px !important; height: auto !important;}
            
        }
        
        @media only screen and (max-width: 479px){
        
        	/*------ top header ------ */
            .header-bg{width: 280px !important; height: 10px !important;}
            .top-header-left{width: 260px !important; text-align: center !important;}
            .top-header-right{width: 260px !important;}
            .main-header{line-height: 28px !important; text-align: center !important;}
            .main-subheader{line-height: 28px !important; text-align: center !important;}
            
            /*------- header ----------*/
            .logo{width: 260px !important;}
            .nav{width: 260px !important;}
            
            /*----- --features ---------*/
            .feature-img{width: 280px !important;}
            .feature-text{width: 280px !important;}
            .feature-middle{width: 260px !important;}
            .feature-img{width: 280px !important; height: auto !important;}

            
            .container{width: 280px !important;}
            .container-middle{width: 260px !important;}
            .mainContent{width: 240px !important;}
            
            .main-image{width: 240px !important; height: auto !important;}
            .banner{width: 240px !important; height: auto !important;}
            /*------ sections ---------*/
            .section-item{width: 240px !important;}
            .section-img{width: 240px !important; height: auto !important;}
            /*------- prefooter ------*/
            .prefooter-header{padding: 0 10px !important;line-height: 28px !important;}
            .prefooter-subheader{padding: 0 10px !important; line-height: 28px !important;}
            /*------- footer ------*/
            .top-bottom-bg{width: 260px !important; height: auto !important;}
            
	    }
						
						
					</style>
				</head>
	<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
	<table border="0" width="100%" cellpadding="0" cellspacing="0">';
    $return .= email_alert_template_header($post);
    $return .= '<tr><td height="35"></td></tr>';
    foreach ($post_objects as $key => $post_object) {
			$post_title = $admin_settings->emailalert_short_title($post_object->post_title);
			$content = wp_trim_words($post_object->post_content, $length, '');
            $readmorelink = $admin_settings->displayreadmorelink( $readmore , get_the_permalink($post_object->ID));
			$content = $admin_settings->emailalert_short_content($content, $length, $readmorelink);
            $content = native_email_filter_content($content);
			
        if ($key % 2 == 0):
            $return.='<tr mc:repeatable>
                		<td>
                			<table border="0" style="border:5px solid #808080;" width="560" align="center" cellpadding="0" cellspacing="0" class="container-middle" bgcolor="ffffff">
                				<tr>
                					<td>
                						<table border="0" width="270" align="left" cellpadding="0" cellspacing="0" bgcolor="ffffff" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="feature-text">
                							<tr>
                								<td align="center">
                									<table border="0" width="250" align="center" cellpadding="0" cellspacing="0" bgcolor="ffffff" class="feature-middle">
                										<tr><td height="18" style="font-size: 18px; line-height: 18px;">&nbsp;</td></tr>
			                							<tr>
			                								<td mc:edit="title3" style="color: #484848; font-size: 16px; font-weight: normal; font-family: ' . $font_family . ';">';
            $return.= $post_title;
            $return.= '</td>
			                							</tr>
			                							<tr><td height="15" style="font-size: 15px;">&nbsp;</td></tr>
			                							<tr>
				                							<td mc:edit="subtitle3" style="color: #a4a4a4; font-size: ' . $native_settings->get("emailalertpro_template_font_size", "12") . 'px; line-height: ' . $native_settings->get("emailalertpro_template_text_spacing", "25") . 'px; font-weight: normal; font-family: ' . $font_family . ';">';
/*           
		   if ($readmore == '') {
                $readmorelink = '<a style="display: block; width: 80px; border-style: none !important; border: 0 !important;" href="' . get_the_permalink($post_object->ID) . '">
														<img width="80" height="26" border="0" alt="read more" src="' . $img_dir . '/readmore-btn.png" style="display: block;" mc:edit="readMoreBtn" editable="true">
													</a>';
            } else {

                //$readmorelink = '<a href="' . get_the_permalink($post_object->ID) . '">' . $readmore . '</a>';
				$readmorelink = $admin_settings->displayreadmorelink( $readmore , get_the_permalink($post_object->ID));
            }
			*/
            $return.= $content;
            $return.='</td>
			                							</tr>
			                							<tr><td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td></tr>
			                							<tr><td height="18" style="font-size: 18px; line-height: 18px;">&nbsp;</td></tr>
                									</table>
                								</td>
                							</tr>
                							
                						</table>
                						
                						<table border="0" align="left" width="5" cellpadding="0" cellspacing="0" bgcolor="ffffff" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
                							<tr>
                								<td height="30" width="5"></td>
                							</tr>
                						</table>
                						
                						<table border="0" width="270" align="right" cellpadding="0" cellspacing="0" bgcolor="ffffff" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="feature-img">
                							
                							<tr>
                								<td align="center">
												<a href="' . get_the_permalink($post_object->ID) . '">
												';
            $thumbnail_url = $admin_settings->emailalert_get_post_thumbnailimage($post_object->ID);

            if ($thumbnail_url) {
                $return.='<img editable="true" mc:edit="image2" style="display: block;" width="270" height="200" src="' . $thumbnail_url . '" alt="image2" class="feature-img" />';
            } else {
                $return.='<img editable="true" mc:edit="image2" style="display: block;" width="270" height="200" src="' . $img_dir . '/image2.png" alt="image2" class="feature-img" />';
            }
            $return.= '</a></td>
                							</tr>
										</table>
                						<!-- end feature 2 -->	                						
                					</td>
                				</tr>
                			</table>
                		</td>
					</tr><tr><td height="35"></td></tr>';
        else:
            $return.='<tr><!-- feature 1 -->
                		<td>
                			<table width="560" bgcolor="ffffff" style="border:5px solid #808080;" align="center" cellspacing="0" cellpadding="0" border="0" class="container-middle">
                				<tbody><tr>
                					<td>';

            $thumbnail_url = $admin_settings->emailalert_get_post_thumbnailimage($post_object->ID);

			
			
            if (!empty($thumbnail_url)) {
                $return.='<table width="270" bgcolor="ffffff" align="left" cellspacing="0" cellpadding="0" border="0" class="feature-img" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">		
                							<tbody><tr>
                								<td align="center">';
                $return.= '<a href="' . get_the_permalink($post_object->ID) . '"><img editable="true" mc:edit="image1" style="display: block;" width="270" height="200" src="' . $thumbnail_url . '" alt="image1" class="section-img" /></a>';
                $return.='				</td>
                							</tr>
                						</tbody></table>';
            }
			
            $return.= '<table width="5" bgcolor="ffffff" align="left" cellspacing="0" cellpadding="0" border="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
                							<tbody><tr>
                								<td width="5" height="30"></td>
                							</tr>
                						</tbody></table>
                						
                						<table width="270" bgcolor="ffffff" align="left" cellspacing="0" cellpadding="0" border="0" class="feature-text" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
                							<tbody><tr>
                								<td align="center">
                									<table width="250" bgcolor="ffffff" align="center" cellspacing="0" cellpadding="0" border="0" class="feature-middle">
                										<tbody><tr><td height="18" style="font-size: 18px; line-height: 18px;">&nbsp;</td></tr>
			                							<tr>
			                								<td style="color: #484848; font-size: 16px; font-weight: normal; font-family:' . $font_family . ';" mc:edit="title2">
					                							<multiline>';
            $return.= $post_title;
            $return.='</multiline>
				                							</td>
			                							</tr>
			                							<tr><td height="15" style="font-size: 15px; line-height: 15px;">&nbsp;</td></tr>
			                							<tr>
				                							<td style="color: #a4a4a4; font-size: ' . $native_settings->get("emailalertpro_template_font_size", "12") . 'px; line-height: ' . $native_settings->get("emailalertpro_template_text_spacing", "25") . 'px;  font-weight: normal; font-family:' . $font_family . ';" mc:edit="subtitle2">
					                							<multiline>';

            $return.= $content;

            $return.='</multiline>
				                							</td>
			                							</tr>
			                							<tr><td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td></tr>
			                							
			                							<tr><td height="18" style="font-size: 18px; line-height: 18px;">&nbsp;</td></tr>
                									</tbody></table>
                								</td>
                							</tr>
                						</tbody></table>               						
                					</td>
                				</tr>	
                				
                			</tbody></table>
                			
                		</td>
					</tr><tr><td height="35"></td></tr>';
        endif;
    }
    $return.='
                	<!--</layout>--->                			
                	
                	<!--------- end features --------->
                	
                	<tr><td height="35"></td></tr>';
    $return .= email_alert_template_footer($post);
    $return .= '</table>
			</body>
		</html>';
//die($return);
    return $return;
}

function email_alert_fifth_template($post, $post_objects = null) {
    global $catepro_font_family, $native_settings;
    $font_family = $catepro_font_family;
    $img_dir = emailalert_url . 'assets/images';
    $return = '';
    $admin_settings = new emailalertpro_templates;


    $bgcolor = $native_settings->get('emailalertpro_colorpicker_color_change');
    $readmore = $native_settings->get("emailalertpro_template_readmore");
    $bgcolor = $native_settings->get("emailalertpro_colorpicker_color_change");
    $background_color = $native_settings->get("emailalertpro_colorpicker_background_color");





    $return = '<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- Define Charset -->
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<!-- Responsive Meta Tag -->
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
    <title>Native Email Template</title><!-- Responsive Styles and Valid Styles -->
    <style type="text/css"> 	
	    body{
            width: 100%; 
            background-color: #' . $background_color . '; 
            margin:0; 
            padding:0; 
            -webkit-font-smoothing: antialiased;
        }
        p,h1,h2,h3,h4{
	        margin-top:0;
			margin-bottom:0;
			padding-top:0;
			padding-bottom:0;
        }
        html{
            width: 100%; 
        }
        
        table{
            font-size: 14px;
            border: 0;
        }
        
        /* ----------- responsivity ----------- */
        @media only screen and (max-width: 640px){
        
            /*------ top header ------ */
            .header-bg{width: 440px !important; height: 10px !important;}
            .main-header{line-height: 28px !important;}
            .main-subheader{line-height: 28px !important;}
            
            .main-image{width: 400px !important; height: auto !important;}
            /*----- --portfolio ---------*/
            .portfolio-item{width: 440px !important;}
            .portfolio-middle{width: 440px !important; text-align: center !important;}
            .portfolio-img{width: 420px !important; height: auto !important;}
            
            .container{width: 440px !important;}
            .container-middle{width: 420px !important;}
            .mainContent{width: 400px !important;}
            /*------ sections ---------*/
            .section-item{width: 400px !important;}
            .section-img{width: 400px !important; height: auto !important;}
            
            /*------- cta ----------*/
            .cta-subheader{padding: 0 10px !important; line-height: 26px;}
            
            /*------- prefooter ------*/
            .prefooter-header{padding: 0 10px !important; line-height: 24px !important;}
            .prefooter-subheader{padding: 0 10px !important; line-height: 24px !important;}
            /*------- footer ------*/
            .top-bottom-bg{width: 420px !important; height: auto !important;}
            
        }
        
        @media only screen and (max-width: 479px){
        
        	/*------ top header ------ */
            .header-bg{width: 280px !important; height: 10px !important;}
            .top-header-left{width: 260px !important; text-align: center !important;}
            .top-header-right{width: 260px !important;}
            .main-header{line-height: 28px !important; text-align: center !important;}
            .main-subheader{line-height: 28px !important; text-align: center !important;}
            
            /*------- header ----------*/
            .logo{width: 260px !important;}
            .nav{width: 260px !important;}
            
            .main-image{width: 240px !important; height: auto !important;}
            /*----- --features ---------*/
            .portfolio-item{width: 260px !important;}
            .portfolio-middle{width: 260px !important; text-align: center !important;}
            .portfolio-img{width: 260px !important; height: auto !important;}

            
            .container{width: 280px !important;}
            .container-middle{width: 260px !important;}
            .mainContent{width: 240px !important;}
            
            /*------ sections ---------*/
            .section-item{width: 240px !important;}
            .section-img{width: 240px !important; height: auto !important;}
            
            /*------- cta ----------*/
            .cta-subheader{padding: 0 10px !important; line-height: 26px;}
            
            /*------- prefooter ------*/
            .prefooter-header{padding: 0 10px !important;line-height: 28px !important;}
            .prefooter-subheader{padding: 0 10px !important; line-height: 28px !important;}
            /*------- footer ------*/
            .top-bottom-bg{width: 260px !important; height: auto !important;}
            
	    }
	</style>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" bgcolor="' . $bgcolor . '">
	<table border="0" width="100%" cellpadding="0" cellspacing="0">';
    $return .= email_alert_template_header($post);

    $return .='
                	
                	
                	<tr><td height="35"></td></tr>
                	

                	<!--------- portfolio --------->
                	
					<tr>
                		<td>
                			<table border="0" width="560" align="center" cellpadding="0" cellspacing="0" class="container-middle">
                				<tr>
                					<td>';
    $id = 0;
    foreach ($post_objects as $key => $post_object) {
        $thumbnail_url = '';
        $thumbnail_url = $admin_settings->emailalert_get_post_thumbnailimage($post_object->ID);

        if ($id % 4 === 0) {
            $return.='</td><tr height="20px"></tr><tr><td>';
            $ind = 0;
            $id++;
        }

        $return.='<table border="0" width="180" align="left" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="portfolio-item">
			    										
			                							<tr>
			                								<td align="center">';
        
		$return.= '<a href="' . get_the_permalink($post_object->ID) . '">';
		
        if ($thumbnail_url) {
            $return.= '<img editable="true" mc:edit="image1" style="display: block;" width="180" height="140" src="' . $thumbnail_url . '" alt="portfolio_image1" class="portfolio-img" />';
        } else {
            $return.= '<img width="180" height="140" class="portfolio-img" alt="portfolio image4" src="' . $img_dir . '/portfolio-img2.png" style="display: block;" mc:edit="image4" editable="true">';
        }
        $return.= '</a>';
		
        $return.='</td>
			                							</tr>
			                							
			    									</table><!-- end image 1 -->
													
                						<table border="0" align="left" width="2" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
			                							<tr>
			                								<td height="20" width="2"></td>
			                							</tr>
			                			</table>';
    }

    $return.='</td>
                				</tr>
                				<tr><td height="10"></td></tr>
                			</table>
                			
                		</td>
					</tr>
					            
					<tr><td height="35"></td></tr> 
					                	
                	<tr>
                		<td align="center">';

    $portfolio_link = $native_settings->get("emailalertpro_template_portfolio_link_box");
    if ($portfolio_link == '') {
        $portfolio_link = $native_settings->get('email_alert_home_link');
    }
    $return.='<a href="' . $portfolio_link . '" style="text-decoration:none;display:block;width:120px;color:#fefefe;background:#' . $bgcolor . '; border:1px solid #' . $bgcolor . ';padding:10px;font-family:' . $font_family . '">';
    $return.= $native_settings->get('emailalertpro_template_portfolio_text_box');
    $return.='
							</a>
                		</td>	
                	</tr>
                	
                	<!--------- end portfolio --------->
                	
                	<tr><td height="35"></td></tr>
                <!--------- section 1 ---------><!---------- cta  --------->';

    $return.='<tr><td height="30"></td></tr>';
    $return .= email_alert_template_footer($post);
    $return.='</table>
	
	
</body>
</html>
';
    //die($return);
    return $return;
}

function email_alert_default_template($post, $post_objects) {
    global $catepro_font_family, $native_settings;
    $font_family = $catepro_font_family;

    $phone_number = $native_settings->get('emailalertpro_template_phone_section');
    //get_option("emailalertpro_template_phone_section");
    $img_dir = emailalert_url . 'assets/images';
    $return = '';
    $admin_settings = new emailalertpro_templates;
	
    $length = (int)$native_settings->get("emailalertpro_template_excerpt_length");
    $length = ( $length >= 0 && is_numeric($length)) ? $length : 500;

    $readmore = $native_settings->get("emailalertpro_template_readmore");
    $bgcolor = $native_settings->get("emailalertpro_colorpicker_color_change");

    $img_dir = emailalert_url . 'assets/images/';

    $return .= '<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- Define Charset -->
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<!-- Responsive Meta Tag -->
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
    <title>Native Email Template</title><!-- Responsive Styles and Valid Styles -->
    <style type="text/css"> 	
				/*
				.singledash {
							border-top: 1px dashed #000;
							 height: 4px;
						}
									
				.doubledash {
					border-bottom: 1px dashed #000;
					border-top: 1px dashed #000;
					height: 4px;
				}
				*/
				.title{
					margin-top:8px;
					margin-bottom:8px;
					}
				.content{
					 margin: 10px 0 12px;
					}	
				</style>'
    ;
    $return .= '</head>';
    $return .= '<body>';

    $return.= '<div style="font-family:' . $font_family . '; padding:0px;width:70%;text-align: left;font-size:13px;">';
    $return .= '<div class="title" style="mergin-top:4px;margin-bottom:4px;">';
    $return.= stripslashes($native_settings->get("emailalertpro_template_header_title"));
    $return .= '</div>';


    $return .= '<div class="content">';
    $return.= stripslashes($native_settings->get("emailalertpro_template_header_section"));
    $return .= '</div>';


    $return .= '<br/>';
    foreach ($post_objects as $key => $post_object) {
        $return .= '<div class="singledash" style="height: 4px;">&nbsp;</div>';

        $return .= '<div class="title" style="mergin-top:4px;margin-bottom:4px;">';
        $return .= strip_tags($post_object->post_title);
        $return .= '</div>';

        $return .= '<div class="singledash" style="height: 4px;">&nbsp;</div>';


        $readmorelink = '';
        if ($readmore == '') {
            $readmorelink = get_the_permalink($post_object->ID);
        } else {
            $readmorelink = get_the_permalink($post_object->ID);
        }
        $content = wp_trim_words($post_object->post_content, $length, '');
        $content = $admin_settings->emailalert_short_content($content, $length, '');
        $content = native_email_filter_content($content);
        $return .= '<div class="content">';
        $return.= strip_tags($content);
        //$return.= '<br/>';
        $return .= '[...]';
        $return.= '<br/>';
        $return.= get_the_permalink($post_object->ID);
        //$return .= '<br/>';
        $return .= '</div>';
    }
    $return .= '<br/>';

    $return .= '<br/>';
    $return.= 'Visit this link to unsubscribe {unsubscribe_link}';
    $return .= '<br/>';
    $return.= strip_tags(stripslashes($native_settings->get("emailalertpro_template_footer_section")));
    $return .= '</div>';
    //	die($return);			
    return $return;
}

?>