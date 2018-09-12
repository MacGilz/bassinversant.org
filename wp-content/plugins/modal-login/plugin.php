<?php

/**
 * @wordpress-plugin
 * Plugin Name:       Modal Login
 * Plugin URI:        http://plugins.zeasite.com
 * Description:       Modal Login plugin built with Bootstrap 3 with header and backdrop image facilities with opacity changing. Allows you to choose 4 templates with 4 preset color sets. Its also allows you to redirect URL after login, logout and registration. You can customize anything you want to and we've tried our best to make it simple, user friendly and self explanatory for everyone which also includes registration and forgot password form. Google re-captcha is another feature which allows you to restrict unwanted visitors.
 * Version:           1.0.4
 * Author:            Z Plugins
 * Author URI:        http://codecanyon.net/user/zea726
 * License:           GPLv3 or later
 */

require_once __DIR__ . '/vendor/autoload.php';
// Initialise framework
$plugin = new Herbert\Framework\Plugin();

global $base_url;
global $pluginName;
global $Pluginoptions;
$base_url = $plugin->config['url']['base'];

if ($plugin->config['eloquent'])
{
    $plugin->database->eloquent();
}

if (!get_option('permalink_structure'))
{
    //$plugin->message->error($plugin->name . ': Please ensure you have permalinks enabled.');
}

$pieces = explode("/", $plugin->config['url']['base']);
$pluginExistance = "modal-login/plugin.php";
$pluginName = "modal-login";

if($plugin->config)
{    
    $pluginExistance = $pieces[(count($pieces)-2)]."/plugin.php";
    $pluginName = $pieces[(count($pieces)-2)];
    add_action('admin_enqueue_scripts', 'pre_load_scripts');
}

if(in_array($pluginExistance, (array) get_option('active_plugins', array())))
{
//if($current_url!="/my-account/"){}
	$plugin->enqueue->front([
		'as'  => 'styleCSS',
		'src' => '/css/bootstrap.login.modal.css',
		]);
	$plugin->enqueue->front([
		'as'  => 'customModalLogin',
		'src' => '/css/login-modal-custom.css',
		]);
    $plugin->enqueue->front([
        'as'  => 'jgrowlcss',
        'src' => '/css/jquery.jgrowl.min.css',
    ]);
	$plugin->enqueue->front([
		'as'  => 'bootstrapJS',
		'src' => '/js/bootstrap.min.js',
		], 'footer');
	$plugin->enqueue->front([
		'as'  => 'actual',
		'src' => '/js/jquery.actual.min.js',
		], 'footer');
    $plugin->enqueue->front([
        'as'  => 'jGrowl',
        'src' => '/js/jquery.jgrowl.min.js',
    ], 'footer');
	$plugin->enqueue->front([
		'as'  => 'loginJS',
		'src' => '/js/login.js',
		], 'footer');


}
add_action("wp_enqueue_scripts","login_modal_scripts_loader");
add_action('wp_ajax_check_login_modal', 'check_login_modal');
add_action('wp_ajax_nopriv_check_login_modal','check_login_modal');
add_action('wp_ajax_template_value_login_modal', 'template_value_login_modal');


function login_modal_scripts_loader(){
    $plugins_url = plugins_url();
	$options = $Pluginoptions = get_option('login-modal');
	$path = __DIR__ .'/plugin/assets/template/'.$options["template"];
    $path =strstr($path, 'wp-content');
    $asset_path = $plugins_url.str_replace("plugins","",strstr(__DIR__,'plugins'));
    $logTemplate  = $path;
	preg_match_all('!\d+!', $options["template"], $matches);
	$tempNo = $matches[0][0];
	$regTemplate = str_replace("template".$tempNo, "regtemplate".$tempNo, $logTemplate);
	$forgetTemplate = str_replace("template".$tempNo, "forgettemplate".$tempNo, $logTemplate);

    $logOutUrl=wp_logout_url();
    $data = array("template_name"=>$options["template"], "logTemplate"=>$logTemplate, "regTemplate"=>$regTemplate,"forgetTemplate"=>$forgetTemplate,"base"=>get_site_url(),"options"=>$options,"dir"=>__DIR__,"asset_path"=>$asset_path,"default"=>"no");
	wp_localize_script( "loginJS", "blog", $data );
    wp_localize_script( "loginJS", "ajaxurl", admin_url('admin-ajax.php') );
    wp_localize_script( "loginJS", "logOutUrl", $logOutUrl);
    //$googlesitekey=$options['captchasitekey'];
	//wp_localize_script( $handle, $name, $data );
}

function check_login_modal(){
    
    //die("dddd");
    // Nonce is checked, get the POST data and sign user on
    $info = array();
    $info['user_login'] = $_POST['username'];
    $info['user_password'] = $_POST['password'];
    $info['remember'] = $_POST['remember'];

    $user = wp_signon( $info, false );

    if(isset($user->errors['incorrect_password'])){
        echo json_encode(array('loggedin'=>false, 'message'=>__('Le mot de passe entré pour <strong>'.$_POST["username"].'</strong> vn\'est pas correct')));
        wp_die();
    }
    if(isset($user->errors['invalid_username'])){
        echo json_encode(array('loggedin'=>false, 'message'=>__('Identifiant non reconnu.')));
        wp_die();
    }
    if($_POST['username']==""){
        echo json_encode(array('loggedin'=>false, 'message'=>__('Entrez votre identifiant.')));
        wp_die();
    }
    if($_POST['password']==""){
        echo json_encode(array('loggedin'=>false, 'message'=>__('Renseignez le mot de passe')));
        wp_die();
    }

    if ( is_wp_error($user) ){
        echo json_encode(array('loggedin'=>false, 'message'=>__('Identifiant ou mot de passe erroné.')));
        wp_die();
    }

    // check capcha
    if(isset($_POST['g-recaptcha-response'])){
        if($_POST['g-recaptcha-response']==""){
            echo json_encode(array('loggedin'=>false, 'message'=>__('Empty captcha, try again')));
            wp_die(); 
        }
        else{
            $options = get_option('login-modal');
            $response=json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$options['captchasecretkey']."&response=".$_POST['g-recaptcha-response']."&remoteip=".$_SERVER['REMOTE_ADDR']), true);            
            if($response['success']!=1){
                if(isset($response['error-codes'])){
                    echo json_encode(array('loggedin'=>false, 'message'=>__($response['error-codes'][0].' for your captcha. Contact admin.'))); 
                    wp_die();    
                }
                else{
                    echo json_encode(array('loggedin'=>false, 'message'=>__('Wrong Captcha , Check internet and try again.')));
                    wp_die();  
                }
                //echo json_encode(array('loggedin'=>false, 'message'=>__('Wrong Captcha Provided, try again')));                
                
            }   
        }
    }

    //setting the user variables so the globals have content without an actual page load
    wp_set_current_user( $user->ID, $user->user_login );
    if($_POST['remember']==true){
        wp_set_auth_cookie( $user->ID, true, false );
    }
    wp_set_auth_cookie($user->ID);
    do_action( 'wp_login', $user->user_login, $user );
    ob_start();
    //gzp_logged_in_menu();
    $menu_content = ob_get_contents();
    ob_end_clean();

    echo json_encode(array('loggedin'=>true, 'message'=>__('Login successful, redirecting...'), 'menu_content'=>$menu_content,'user_signon'=>$user));

    wp_die();
}

function template_value_login_modal(){
    $templateOptionName = "login-modal-".str_replace(".php", "", $_POST["template"]);
    //echo  $templateOptionName;
    $options = null;
    if (!$options = get_option($templateOptionName)) {
        $options = null;
    }
    echo json_encode($options);
    wp_die();
}


function plupload_admin_head() {
// place js config array for plupload
	$plupload_init = array(
	    'runtimes' => 'html5,silverlight,flash,html4',
	    'browse_button' => 'plupload-browse-button', // will be adjusted per uploader
	    'container' => 'plupload-upload-ui', // will be adjusted per uploader
	    'drop_element' => 'drag-drop-area', // will be adjusted per uploader
	    'file_data_name' => 'async-upload', // will be adjusted per uploader
	    'multiple_queues' => true,
	    'max_file_size' => wp_max_upload_size() . 'b',
	    'url' => admin_url('admin-ajax.php'),
	    //'url' => get_site_url().'/ajaxCall',
	    'flash_swf_url' => includes_url('js/plupload/plupload.flash.swf'),
	    'silverlight_xap_url' => includes_url('js/plupload/plupload.silverlight.xap'),
	    'filters' => array(array('title' => __('Allowed Files'), 'extensions' => '*')),
	    'multipart' => true,
	    'urlstream_upload' => true,
	    'multi_selection' => false, // will be added per uploader
	    // additional post data to send to our ajax hook
	    'multipart_params' => array(
	        '_ajax_nonce' => "", // will be added per uploader
	        'action' => 'plupload_action', // the ajax action name
	        'imgid' => 0 // will be added per uploader
	    )
	);
}
add_action("admin_head", "plupload_admin_head");


function g_plupload_action() {

    // check ajax noonce
    $imgid = $_POST["imgid"];
    //check_ajax_referer($imgid . 'pluploadan');
    include_once ABSPATH . 'wp-admin/includes/media.php';
    include_once ABSPATH . 'wp-admin/includes/file.php';
    include_once ABSPATH . 'wp-admin/includes/image.php';
    // handle file upload
    $status = wp_handle_upload($_FILES[$imgid . 'async-upload'], array('test_form' => true, 'action' => 'plupload_action'));

    // send the uploaded file url in response
    echo $status['url'];
    exit;
}
add_action('wp_ajax_plupload_action', "g_plupload_action");

function update_template_option(){
    $cookie = (wp_parse_auth_cookie( '', 'logged_in' ));
    $token = "login-modal".$cookie["token"];
    $_REQUEST["_ajax_nonce"] = $_POST["security"];
    check_ajax_referer($token);
    parse_str($_POST['data'], $formdata);
    //print_r($_POST);
    $options = get_option($_POST["optionsName"]);

    foreach ($formdata as $key=>$value) {
        if($key=="log" || $key=="pwd" || $key=="img1"){
            unset($formdata[$key]);
        }
        if($key=="image_path" || $key=="image_path_bg" || $key=="img110" || $key=="redirect_url" || $key=="log_out_redirect_url"){
            $options[$key]=trim($value);
        }
        else{
            $options[$key]=$value;
        }
    }
    if(!isset($formdata['makeItRound'])){
        $formdata['makeItRound']=0;
        $options['makeItRound']=0;
    }
    if(!isset($formdata['modalCorner'])){
        $formdata['modalCorner']=0;
        $options['modalCorner']=0;
    }
    if(!isset($formdata['captcha'])){
        $formdata['captcha']=0;
        $options['captcha']=0;
    }
    if(!isset($formdata['logincaptcha'])){
        $formdata['logincaptcha']=0;
        $options['logincaptcha']=0;
    }
    if(!isset($formdata['registercaptcha'])){
        $formdata['registercaptcha']=0;
        $options['registercaptcha']=0;
    }
    if(!isset($formdata['forgotcaptcha'])){
        $formdata['forgotcaptcha']=0;
        $options['forgotcaptcha']=0;
    }
    $templatOptionName ="login-modal-". str_replace(".php","",$formdata['template']);
    update_option($_POST["optionsName"], $options);
    if(update_option($templatOptionName, $formdata)){
        echo $formdata['template'];
    }
    else {
        echo "";
    }

    /**/
    /*$file = __DIR__ ."/plugin/assets/js/login-modal-pre.js";
    $content = file($file); //Read the file into an array. Line number => line content
    foreach($content as $lineNumber => &$lineContent) { //Loop through the array (the "lines")

        if($lineNumber == 2) { //Remember we start at line 0.
            $lineContent = "var redirect_url='".$options['log_out_redirect_url']."';" . PHP_EOL; //Modify the line. (We're adding another line by using PHP_EOL)
        }
    }

    $allContent = implode("", $content); //Put the array back into one string
    try {
        file_put_contents($file, $allContent);
    } catch (ErrorException $e) {
        
    }*/
    

    /**/
    exit(0);

    //$nonce = wp_create_nonce('img1pluploadan');
}
add_action('wp_ajax_update_template_option', 'update_template_option');


function login_modal_register_user(){
    $user_login = $_POST['user_login'];
    $user_email = $_POST['user_email'];

    if($user_login =="" || $user_email==""){
        echo json_encode(array('registered'=>false, 'message'=>__('Empty fields, please fill')));
        wp_die();
    }
    $email = $user_email;
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(array('registered'=>false, 'message'=>__('Invalid email address')));
        wp_die();
    }

    // check capcha
    if(isset($_POST['g-recaptcha-response'])){
        if($_POST['g-recaptcha-response']==""){
            echo json_encode(array('registered'=>false, 'message'=>__('Empty captcha, try again')));
            wp_die();
        }
        else{
            $options = get_option('login-modal');
            $response=json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$options['captchasecretkey']."&response=".$_POST['g-recaptcha-response']."&remoteip=".$_SERVER['REMOTE_ADDR']), true);            
            if($response['success']!=1){
                echo json_encode(array('loggedin'=>false, 'message'=>__('Wrong Captcha Provided, try again')));
                wp_die();
            }   
        }
    }

    $errors = register_new_user($user_login, $user_email);
    if ( is_wp_error($errors) ){
        //print_r($errors);
        $msg="";
        if(isset($errors->errors['empty_username'])){
            $msg = 'Entrez votre identifiant.';
        }
        if(isset($errors->errors['empty_email'])){
            if($msg!=""){
                $msg.=" L'Email doit être renseigné.";
            }
            else{
                $msg = 'This email is empty.';
            }
        }
        if(isset($errors->errors['invalid_username'])){
            if($msg!=""){
                $msg.=" Identifiant non reconnu.";
            }
            else{
                $msg = 'Identifiant non reconnu';
            }
        }
        if(isset($errors->errors['invalid_email'])){
            if($msg!=""){
                $msg.=" And email is invalid too.";
            }
            else{
                $msg = 'This email is invalid.';
            }
        }
        if(isset($errors->errors['username_exists'])){
            if($msg!=""){
                $msg.=' And username ('.$user_login.') is already registered. Please choose another one.';
            }
            else{
                $msg = 'This username ('.$user_login.') is already registered. Please choose another one.';
            }
        }
        if(isset($errors->errors['email_exists'])){
            if($msg!=""){
                $msg.=" And this email (".$user_email.") is already registered, please choose another one.  ";
            }
            else{
                $msg="This email (".$user_email.") is already registered, please choose another one.";
            }
        }

        echo json_encode(array('registered'=>false, 'message'=>__($msg)));
        wp_die();
    }
   else {
        //$redirect_to = !empty( $_POST['redirect_to'] ) ? $_POST['redirect_to'] : 'wp-login.php?checkemail=registered';
        //wp_safe_redirect( $redirect_to );
        echo json_encode(array('registered'=>true, 'message'=>__('Registration Successfull.'), 'user_signon'=>$user_login));
        wp_die();
    }
}
add_action('wp_ajax_login_modal_register_user', 'login_modal_register_user');
add_action('wp_ajax_nopriv_login_modal_register_user','login_modal_register_user');

function retrieve_my_password() {
    global $wpdb, $wp_hasher;

    $errors = new WP_Error();

    if ( empty( $_POST['user_login'] ) ) {
        $errors->add('empty_username', __('<strong>ERROR</strong>: Enter a username or e-mail address.'));
        echo json_encode(array('retrive'=>false, 'message'=>__('Enter a username or e-mail address.')));
        wp_die();
    } elseif ( strpos( $_POST['user_login'], '@' ) ) {
        $user_data = get_user_by( 'email', trim( $_POST['user_login'] ) );
        if ( empty( $user_data ) ) {
            $errors->add('retrive', __('<strong>ERROR</strong>: There is no user registered with that email address.'));
            echo json_encode(array('retrive'=>false, 'message'=>__('There is no user registered with that email address.')));
            wp_die();
        }
    } else {
        $login = trim($_POST['user_login']);
        $user_data = get_user_by('login', $login);
        if( $user_data==""){
            echo json_encode(array('retrive'=>false, 'message'=>__('There is no user registered with that username.')));
            wp_die();
        }
    }

    // check capcha
    if(isset($_POST['g-recaptcha-response'])){
        if($_POST['g-recaptcha-response']==""){
            echo json_encode(array('retrive'=>false, 'message'=>__('Empty captcha, try again')));
            wp_die();
        }
        else{
            $options = get_option('login-modal');
            $response=json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$options['captchasecretkey']."&response=".$_POST['g-recaptcha-response']."&remoteip=".$_SERVER['REMOTE_ADDR']), true);            
            if($response['success']!=1){
                //echo json_encode(array('retrive'=>false, 'message'=>__('Wrong Captcha Provided, try again')));
                die();
            }   
        }
    }

    /**
     * Fires before errors are returned from a password reset request.
     *
     * @since 2.1.0
     */
    do_action( 'lostpassword_post' );

    /*if ( $errors->get_error_code() )
        return $errors;*/

    if ( !$user_data ) {
        echo json_encode(array('retrive'=>false, 'message'=>__('Invalid username or email')));
        wp_die();
    }

    // Redefining user_login ensures we return the right case in the email.
    $user_login = $user_data->user_login;
    $user_email = $user_data->user_email;

    /**
     * Fires before a new password is retrieved.
     *
     * @since 1.5.0
     * @deprecated 1.5.1 Misspelled. Use 'retrieve_password' hook instead.
     *
     * @param string $user_login The user login name.
     */
    do_action( 'retreive_password', $user_login );

    /**
     * Fires before a new password is retrieved.
     *
     * @since 1.5.1
     *
     * @param string $user_login The user login name.
     */
    do_action( 'retrieve_password', $user_login );

    /**
     * Filter whether to allow a password to be reset.
     *
     * @since 2.7.0
     *
     * @param bool true           Whether to allow the password to be reset. Default true.
     * @param int  $user_data->ID The ID of the user attempting to reset a password.
     */
    $allow = apply_filters( 'allow_password_reset', true, $user_data->ID );

    if ( ! $allow ) {
        echo json_encode(array('retrive'=>false, 'message'=>__('Password reset is not allowed for this user')));
        wp_die();
        //return new WP_Error( 'no_password_reset', __('Password reset is not allowed for this user') );
    } elseif ( is_wp_error( $allow ) ) {
        echo json_encode(array('retrive'=>false, 'message'=>__('Password reset is not allowed for this user')));
        wp_die();
        return $allow;
    }

    // Generate something random for a password reset key.
    $key = wp_generate_password( 20, false );
    /*$key = $wpdb->get_var($wpdb->prepare("SELECT user_activation_key FROM $wpdb->users WHERE user_login = %s", $user_login));
    if ( empty($key) ) {
        // Generate something random for a key...
        $key = wp_generate_password(20, false);
        do_action('retrieve_password_key', $user_login, $key);
        // Now insert the new md5 key into the db
        $wpdb->update($wpdb->users, array('user_activation_key' => $key), array('user_login' => $user_login));
    }*/

    /**
     * Fires when a password reset key is generated.
     *
     * @since 2.5.0
     *
     * @param string $user_login The username for the user.
     * @param string $key        The generated password reset key.
     */
    do_action( 'retrieve_password_key', $user_login, $key );

    // Now insert the key, hashed, into the DB.
    if ( empty( $wp_hasher ) ) {
        require_once ABSPATH . WPINC . '/class-phpass.php';
        $wp_hasher = new PasswordHash( 8, true );
    }
    $hashed = time() . ':' .$wp_hasher->HashPassword( $key );
    $wpdb->update( $wpdb->users, array( 'user_activation_key' => $hashed ), array( 'user_login' => $user_login ) );

    $message = __('Someone requested that the password be reset for the following account:') . "\r\n\r\n";
    $message .= network_home_url( '/' ) . "\r\n\r\n";
    $message .= sprintf(__('Username: %s'), $user_login) . "\r\n\r\n";
    $message .= __('If this was a mistake, just ignore this email and nothing will happen.') . "\r\n\r\n";
    $message .= __('To reset your password, visit the following address:') . "\r\n\r\n";
    $message .= '<' . network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login') . ">\r\n";

    if ( is_multisite() )
        $blogname = $GLOBALS['current_site']->site_name;
    else
        /*
         * The blogname option is escaped with esc_html on the way into the database
         * in sanitize_option we want to reverse this for the plain text arena of emails.
         */
        $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

    $title = sprintf( __('[%s] Password Reset'), $blogname );

    /**
     * Filter the subject of the password reset email.
     *
     * @since 2.8.0
     *
     * @param string $title Default email title.
     */
    $title = apply_filters( 'retrieve_password_title', $title );

    /**
     * Filter the message body of the password reset mail.
     *
     * @since 2.8.0
     * @since 4.1.0 Added `$user_login` and `$user_data` parameters.
     *
     * @param string  $message    Default mail message.
     * @param string  $key        The activation key.
     * @param string  $user_login The username for the user.
     * @param WP_User $user_data  WP_User object.
     */

    $message = apply_filters( 'retrieve_password_message', $message, $key, $user_login, $user_data );
    $admin_email = (get_option('admin_email'));
    $headers[] = 'From: Admin <'.$admin_email.'>';
    if ( $message && !wp_mail( $user_email, wp_specialchars_decode( $title ), $message,$headers ) ) {
        echo json_encode(array('retrive'=>false, 'message'=>__('The e-mail could not be sent.<br>Possible reason: your host may have disabled the mail() function.')));
        wp_die();
        //wp_die(__('The e-mail could not be sent.') . "<br />\n" . __('Possible reason: your host may have disabled the mail() function.'));
    }

    echo json_encode(array('retrive'=>true, 'message'=>__('Password reset successful')));
    wp_die();
}
add_action('wp_ajax_retrieve_my_password', 'retrieve_my_password');
add_action('wp_ajax_nopriv_retrieve_my_password','retrieve_my_password');



$severUri = $_SERVER["REQUEST_URI"];
//echo $severUri;
/*if($severUri=="/wp-login.php?loggedout=true" || $severUri="/wp-login.php?action=lostpassword" || $severUri="/wp-login.php?action=register" || $severUri="wp-login.php") {*/
if($severUri=="/wp-login.php?action=rp"){
}

else if($severUri=="/wp-login.php?loggedout=true" || $severUri="/wp-login.php?action=lostpassword" || $severUri="/wp-login.php?action=register" || $severUri="wp-login.php"  ) {
    add_action('login_enqueue_scripts', 'enqueue_modal_login_custom_script');

}
global $assetDir;
$assetDir= $plugin->config["url"]["assets"];
function enqueue_modal_login_custom_script() {
    global $assetDir;    
    wp_enqueue_script( 'jquery1',$assetDir.'js/jquery.min.js' );

    wp_enqueue_script( 'my_custom_script',$assetDir.'js/bootstrap.min.js' );
    wp_enqueue_style( 'my_custom_style',$assetDir.'css/bootstrap.login.modal.css' );
    wp_enqueue_style( 'custom-login-modal',$assetDir.'css/login-modal-custom.css' );
    /* wp_enqueue_style('bootstrap', 'http://netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css');*/

    /* for jgrowl */
    wp_enqueue_script( 'jgrowl',$assetDir.'js/jquery.jgrowl.min.js' );
    wp_enqueue_style( 'jgrowl',$assetDir.'css/jquery.jgrowl.min.css' );
    //wp_enqueue_script( 'extraLogout', $assetDir.'js/kick.js');
    wp_enqueue_script( 'actual', $assetDir.'js/jquery.actual.min.js' );
    wp_enqueue_script( 'loginJS', $assetDir.'js/login.js' );
    

    /*$plugins_url = plugins_url();
    $options = get_option('login-modal');
    $path = __DIR__ .'/plugin/assets/template/'.$options["template"];
    $path =strstr($path, 'wp-content');
    $asset_path = $plugins_url.str_replace("plugins","",strstr(__DIR__,'plugins'));
    $logTemplate  = $path;
    preg_match_all('!\d+!', $options["template"], $matches);
    $tempNo = $matches[0][0];
    $regTemplate = str_replace("template".$tempNo, "regtemplate".$tempNo, $logTemplate);
    $forgetTemplate = str_replace("template".$tempNo, "forgettemplate".$tempNo, $logTemplate);

    $data = array("template_name"=>$options["template"], "logTemplate"=>$logTemplate, "regTemplate"=>$regTemplate,"forgetTemplate"=>$forgetTemplate,"base"=>get_site_url(),"options"=>$options,"dir"=>__DIR__,"asset_path"=>$asset_path,"default"=>"yes");
    wp_localize_script( "loginJS", "blog", $data );
    wp_localize_script( "loginJS", "ajaxurl", admin_url('admin-ajax.php'));*/
    $plugins_url = plugins_url();
    $options = get_option('login-modal');
    $path = __DIR__ .'/plugin/assets/template/'.$options["template"];
    $path =strstr($path, 'wp-content');
    $asset_path = $plugins_url.str_replace("plugins","",strstr(__DIR__,'plugins'));
    $logTemplate  = $path;
    preg_match_all('!\d+!', $options["template"], $matches);
    $tempNo = $matches[0][0];
    $regTemplate = str_replace("template".$tempNo, "regtemplate".$tempNo, $logTemplate);
    $forgetTemplate = str_replace("template".$tempNo, "forgettemplate".$tempNo, $logTemplate);

    $logOutUrl=wp_logout_url();
    $data = array("template_name"=>$options["template"], "logTemplate"=>$logTemplate, "regTemplate"=>$regTemplate,"forgetTemplate"=>$forgetTemplate,"base"=>get_site_url(),"options"=>$options,"dir"=>__DIR__,"asset_path"=>$asset_path,"default"=>"yes");
    wp_localize_script( "loginJS", "blog", $data );
    wp_localize_script( "loginJS", "ajaxurl", admin_url('admin-ajax.php') );
    wp_localize_script( "loginJS", "logOutUrl", $logOutUrl);
    wp_localize_script( 'loginJS', 'ajax_nonce', wp_create_nonce('modal_login_custom'));
    
    
    $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $check_register = explode('=', $actual_link);
    if($check_register[(count($check_register))-1] == "registered"){
        wp_enqueue_script( 'loginJSGrowl', $assetDir.'js/regGrowl.js' );
    }
}

// shortcode
add_shortcode('loging_modal_login_shortcode', 'login_modal_login_shortcode_function');

function login_modal_login_shortcode_function($args=""){
    ob_start();
    $argument = $args;
    if ( is_user_logged_in() ) {
        if(isset($args["logout_text"])){
            $argument = $args["logout_text"];
        }
        else{
            $argument="Log Out";
        }
        echo '<a href="javascript:;" class="modal-login-logOutClass">'.$argument.'</a>';
    }
    else{
        if(isset($args["login_text"])){
            $argument = $args["login_text"];
        }
        else{
            $argument="Log In";
        }
        echo '<a href="javascript:;" class="modal-login-loginClass">'.$argument.'</a>';
    }
    return ob_get_clean();
}

add_shortcode('loging_modal_register_shortcode', 'login_modal_register_shortcode_function');

function login_modal_register_shortcode_function($args=""){
    ob_start();
    if (!is_user_logged_in() ) {
        if(isset($args["register_text"])){
            echo '<a href="javascript:;" class="modal-login-regClass">'.$args["register_text"].'</a>';
        }
        else{
            echo '<a href="javascript:;" class="modal-login-regClass">Register</a>';
        }
    }
    return ob_get_clean();
}

add_shortcode('loging_modal_forget_shortcode', 'login_modal_forget_shortcode_function');

function login_modal_forget_shortcode_function($args=""){
    ob_start();
    if (!is_user_logged_in() ) {
        if(isset($args["forget_text"])){
            echo '<a href="javascript:;" class="modal-login-forgetClass">'.$args["forget_text"].'</a>';
        }
        else{
            echo '<a href="javascript:;" class="modal-login-forgetClass">Forget Password</a>';
        }
    }
    return ob_get_clean();
}

function pre_load_scripts() {

    $plugins_url = plugins_url( 'login-modal-pre.js', __FILE__ );
    $pieces = explode("/", $plugins_url);
    $pluginName = $pieces[(count($pieces)-2)];
    wp_enqueue_script('pre-js', '/wp-content/plugins/'.$pluginName.'/plugin/assets/js/login-modal-pre.js');
}

// logout function

add_action('wp_ajax_check_logout_modal', 'check_logout_modal');
add_action('wp_ajax_nopriv_check_logout_modal','check_logout_modal');

function check_logout_modal(){
    
    //$user = wp_logout();
    wp_destroy_current_session();
    wp_clear_auth_cookie();
    do_action( 'wp_logout' );
    echo json_encode(array('loggedout'=>true));
    ob_start();
    
    ob_get_clean();
    wp_die();
    
    /*if(isset($user->errors)){
        echo json_encode(array('loggedout'=>false, 'message'=>__('Something went wrong.')));       
    }
    else{
        echo json_encode(array('loggedout'=>true));
    }
    return ob_get_clean();
    die();*/
}

add_action('wp_ajax_check_other', 'check_other');
add_action('wp_ajax_nopriv_check_other','check_other');

function check_other(){
    $options = get_option("login-modal");
    
    wp_destroy_current_session();
    wp_clear_auth_cookie();
    do_action( 'wp_logout' );
    echo json_encode(array('log_out_redirect_url'=>$options['log_out_redirect_url']));
    ob_start();
    
    ob_get_clean();
    wp_die();
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}


//echo $_SERVER["REQUEST_URI"]
/*
function wp_logout() {
619         wp_destroy_current_session();
620         wp_clear_auth_cookie();
621 
622         /**
623          * Fires after a user is logged-out.
624          *
625          * @since 1.5.0
626          */
/*627         do_action( 'wp_logout' );
628 }
*/
?>