<?php 
use Herbert\Framework\Plugin;
use Herbert\Framework\Traits\PluginAccessorTrait;
class AdminController extends BaseController {
	use PluginAccessorTrait;

    /**
     * @var \Herbert\Framework\Plugin
     */
    protected $plugin;

    /**
     * @param \Herbert\Framework\Plugin $plugin
     */
    public function __construct(Plugin $plugin)
    {
    	$this->plugin = $plugin;
        $this->optionsName = 'login-modal';
        $this->version="1.0.4";
        $this->redirect_url="/wp-admin/";
        $this->log_out_redirect_url="/wp-login.php?loggedout=true";
        $this->register_redirect_url = "/wp-login.php?checkemail=registered";
        $this->template="template1.php";
        $this->regtemplate="regtemplate1.php";
        $this->forgettemplate="forgettemplate1.php";
        $this->image_path=' ';
        $this->rememberText="Remember";
        //$this->image_path=$this->config["url"]["assets"].'images/wordpress-logo.png';
        /*$this->logintext="Login";
        $this->loginbuttontext="Login"; 
        $this->registertext="Want to Register?";
        $this->registerbuttontext="Register";*/


        $this->template1Default = array(
            'template' => 'template1.php',
            'regtemplate'=>'regtemplate1.php',
            'forgettemplate'=>'forgettemplate1.php',
            'logintext'=>'Login',
            'loginbuttontext'=>"LOGIN",
            'registertext'=>"CREATE AN ACCOUNT",
            'registerbuttontext'=>"REGISTER",
            'redirect_url'=>get_site_url().'/wp-admin/',
            'log_out_redirect_url'=>get_site_url()."/wp-login.php?loggedout=true",
            'register_redirect_url'=>get_site_url()."/wp-login.php?checkemail=registered",
            //'backgroundColor'=>$this->backgroundColor,
            //'textColor'=>$this->textColor,
            'headerBackgroundColor'=>"ecf0f1",
            "headerTextColor"=>"34495e",
            "bodyBackgroundColor"=>"ecf0f1",
            "bodyTextColor"=>"6c7a8d",
            "footerBackgroundColor"=>"34495e",
            "footerTextColor"=>"aaaaaa",
            "forgetTextColor"=>"6c7a8d",
            "loginbuttonBackgroundColor"=>"2980b9",
            "loginbuttonTextColor"=>"ffffff",
            "loginbuttonBorderColor"=>"2980b9",
            "registerbuttonBackgroundColor"=>"337ab7",
            "registerbuttonTextColor"=>"ffffff",            
            "registerbuttonBorderColor"=>"2e6da4",
            "forgotPasswordText"=>"Did you forget password?",
            "registerTextColor"=>"eceef1",
            "showImage"=>0,
            "image_path"=>"0",
            "image_path_bg"=>"0",
            "modalBackdropColor"=>"364150",
            "opacity"=>".5",
            "tOpacity"=>"1",
            "modalCorner"=>0,
            "formTransperancy"=>0,
            'regtitle'=>'REGISTER FOR THIS SITE',
            'passwordMsgText'=>'A password will be e-mailed to you.',
            'passwordMsgTextColor'=>"aaaaaa",
            'forgetTitle'=>"Forget Password",
            'forgetMessageEmail'=>'A password will be e-mailed to you.',
            'getPasswordBtnText'=>"Get new password",
            'getPasswordBtnColor'=>"337AB7",
            "getPasswordBtnBorderColor"=>"2e6da4",
            "getPasswordBtnTextColor"=>"ffffff",
            "textBoxBgColor"=>"ffffff",
            "textBoxFontColor"=>"444444",
            "rememberText"=>"Remember",
            );

        $this->template2Default = array(
            'template' => 'template2.php',
            'regtemplate'=>'regtemplate2.php',
            'forgettemplate'=>'forgettemplate2.php',
            "logintext"=>"Sign in",
            'loginbuttontext'=>"Sign in",
            'registertext'=>"Create an account?",
            'registerbuttontext'=>"REGISTER",
            'redirect_url'=>get_site_url().'/wp-admin/',
            'log_out_redirect_url'=>get_site_url()."/wp-login.php?loggedout=true",
            'register_redirect_url'=>get_site_url()."/wp-login.php?checkemail=registered",
            //'backgroundColor'=>$this->backgroundColor,
            //'textColor'=>$this->textColor,
            'headerBackgroundColor'=>"16a085",
            "headerTextColor"=>"ffffff",
            "bodyBackgroundColor"=>"ecf0f1",
            "bodyTextColor"=>"666666",
            "footerBackgroundColor"=>"7f8c8d",
            "footerTextColor"=>"ffffff",
            "forgetTextColor"=>"ffffff",
            "loginbuttonBackgroundColor"=>"16a085",
            "loginbuttonTextColor"=>"ffffff",
            "loginbuttonBorderColor"=>"16a085",
            "registerbuttonBackgroundColor"=>"16a085",
            "registerbuttonTextColor"=>"ffffff",
            "registerbuttonBorderColor"=>"16a085",
            "forgotPasswordText"=>"Forgot password?",
            "registerTextColor"=>"ffffff",
            "showImage"=>0,
            "image_path"=>"0",
            "image_path_bg"=>"0",
            "modalBackdropColor"=>"364150",
            "opacity"=>".5",
            "tOpacity"=>"1",
            "modalCorner"=>0,
            "formTransperancy"=>0,
            'regtitle'=>'Sign up',
            'passwordMsgText'=>'A password will be e-mailed to you.',
            'passwordMsgTextColor'=>"ffffff",
            'forgetTitle'=>"Forget Password",
            'forgetMessageEmail'=>'A password will be e-mailed to you.',
            'getPasswordBtnText'=>"Get new password",
            'getPasswordBtnColor'=>"16a085",
            "getPasswordBtnBorderColor"=>"16a085",
            "getPasswordBtnTextColor"=>"ffffff",
            "textBoxBgColor"=>"FFFFFF",
            "textBoxFontColor"=>"444444",
            "rememberText"=>"Remember",
        );
        
        
        
         $this->template3Default = array(
            'template' => 'template3.php',
            'regtemplate'=>'regtemplate3.php',
            'forgettemplate'=>'forgettemplate3.php',
            "logintext"=>"Sign in",
            'loginbuttontext'=>"Sign in",
            'registertext'=>"Create an account?",
            'registerbuttontext'=>"REGISTER",
            'redirect_url'=>get_site_url().'/wp-admin/',
            'log_out_redirect_url'=>get_site_url()."/wp-login.php?loggedout=true",
            'register_redirect_url'=>get_site_url()."/wp-login.php?checkemail=registered",
            //'backgroundColor'=>$this->backgroundColor,
            //'textColor'=>$this->textColor,
            'headerBackgroundColor'=>"2c3e50",
            "headerTextColor"=>"ffffff",
            "bodyBackgroundColor"=>"eceef1",
            "bodyTextColor"=>"666666",
            "footerBackgroundColor"=>"95a5a6",
            "footerTextColor"=>"ffffff",
            "forgetTextColor"=>"ffffff",
            "loginbuttonBackgroundColor"=>"e74c3c",
            "loginbuttonTextColor"=>"ffffff",
            "loginbuttonBorderColor"=>"e74c3c",
            "registerbuttonBackgroundColor"=>"337ab7",
            "registerbuttonTextColor"=>"ffffff",
            "registerbuttonBorderColor"=>"2e6da4",
            "forgotPasswordText"=>"Forgot password?",
            "registerTextColor"=>"ffffff",
            "showImage"=>0,
            "image_path"=>"0",
            "image_path_bg"=>"0",
            "modalBackdropColor"=>"364150",
            "opacity"=>".5",
            "tOpacity"=>"1",
            "modalCorner"=>0,
            "formTransperancy"=>0,
            'regtitle'=>'Sign up',
            'passwordMsgText'=>'A password will be e-mailed to you.',
            'passwordMsgTextColor'=>"ffffff",
            'forgetTitle'=>"Forget Password",
            'forgetMessageEmail'=>'A password will be e-mailed to you.',
            'getPasswordBtnText'=>"Get new password",
            'getPasswordBtnColor'=>"337ab7",
            "getPasswordBtnBorderColor"=>"2e6da4",
            "getPasswordBtnTextColor"=>"ffffff",
            "textBoxBgColor"=>"FFFFFF",
            "textBoxFontColor"=>"444444",
            "rememberText"=>"Remember",
        );
        
        
        
        
        
         $this->template4Default = array(
            'template' => 'template4.php',
            'regtemplate'=>'regtemplate4.php',
            'forgettemplate'=>'forgettemplate4.php',
            'logintext'=>'Login',
            'loginbuttontext'=>"LOGIN",
            'registertext'=>"Create an account",
            'registerbuttontext'=>"REGISTER",
            'redirect_url'=>get_site_url().'/wp-admin/',
            'log_out_redirect_url'=>get_site_url()."/wp-login.php?loggedout=true",
            'register_redirect_url'=>get_site_url()."/wp-login.php?checkemail=registered",
            //'backgroundColor'=>$this->backgroundColor,
            //'textColor'=>$this->textColor,
            'headerBackgroundColor'=>"eceef1",
            "headerTextColor"=>"d35400",
            "bodyBackgroundColor"=>"ecf0f1",
            "bodyTextColor"=>"555555",
            "footerBackgroundColor"=>"bdc3c7",
            "footerTextColor"=>"666666",
            "forgetTextColor"=>"666666",
            "loginbuttonBackgroundColor"=>"f39c12",
            "loginbuttonTextColor"=>"ffffff",
            "loginbuttonBorderColor"=>"f39c12",
            "registerbuttonBackgroundColor"=>"f39c12",
            "registerbuttonTextColor"=>"ffffff",            
            "registerbuttonBorderColor"=>"f39c12",
            "forgotPasswordText"=>"Did you forget password?",
            "registerTextColor"=>"666666",
            "showImage"=>0,
            "image_path"=>"0",
            "image_path_bg"=>"0",
            "modalBackdropColor"=>"364150",
            "opacity"=>".5",
            "tOpacity"=>"1",
            "modalCorner"=>0,
            "formTransperancy"=>0,
            'regtitle'=>'REGISTER FOR THIS SITE',
            'passwordMsgText'=>'A password will be e-mailed to you.',
            'passwordMsgTextColor'=>"666666",
            'forgetTitle'=>"Forget Password",
            'forgetMessageEmail'=>'A password will be e-mailed to you.',
            'getPasswordBtnText'=>"Get new password",
            'getPasswordBtnColor'=>"f39c12",
            "getPasswordBtnBorderColor"=>"f39c12",
            "getPasswordBtnTextColor"=>"ffffff",
            "textBoxBgColor"=>"FFFFFF",
            "textBoxFontColor"=>"555555",
            "rememberText"=>"Remember",
            );
        
        
    }
    /**
    * Show the profile for the given user.
    */
    public function index()
    {
        
        
        wp_enqueue_script( 'my_custom_script', $this->config["url"]["assets"].'js/bootstrap.min.js' );
        wp_enqueue_style( 'my_custom_style', $this->config["url"]["assets"].'css/bootstrap.login.modal.css' );
        wp_enqueue_style( 'custom-login-modal', $this->config["url"]["assets"].'css/login-modal-custom.css' );
       /* wp_enqueue_style('bootstrap', 'http://netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css');*/
        /*for color*/
        wp_enqueue_script( 'bootstrap-tinycolor', $this->config["url"]["assets"].'js/tinycolor-0.9.15.min.js' );
        wp_enqueue_script( 'pick-a-color', $this->config["url"]["assets"].'js/pick-a-color.js' );
        wp_enqueue_style( 'bootstrap-tinycolor', $this->config["url"]["assets"].'css/pick-a-color-1.2.3.min.css' );
        /* for touch spin */
        wp_enqueue_script( 'touchspin', $this->config["url"]["assets"].'js/jquery.bootstrap-touchspin.min.js' );
        wp_enqueue_style( 'touchspin', $this->config["url"]["assets"].'css/jquery.bootstrap-touchspin.min.css' );
        /* for jgrowl */
        wp_enqueue_script( 'jgrowl', $this->config["url"]["assets"].'js/jquery.jgrowl.min.js' );
        wp_enqueue_style( 'jgrowl', $this->config["url"]["assets"].'css/jquery.jgrowl.min.css' );
        //wp_enqueue_script( 'jgrowl-map', $this->config["url"]["assets"].'js/jquery.jgrowl.map' );
        /*wp_enqueue_script( 'bootstrap-colorpicker-pick', $this->config["url"]["assets"].'js/bootstrap-colorpicker.js' );
        wp_enqueue_style( 'bootstrap-colorpicker', $this->config["url"]["assets"].'css/bootstrap-colorpicker.css' ); 
        /* color ends */
        
        wp_enqueue_script( 'jqueryPopulate', $this->config["url"]["assets"].'js/jquery.populate.js' );
        wp_enqueue_script( 'jquerySwitch', $this->config["url"]["assets"].'js/bootstrap-switch.min.js');
        wp_enqueue_style( 'jquerySwitch', $this->config["url"]["assets"].'css/bootstrap-switch.min.css');

        $cookie = (wp_parse_auth_cookie( '', 'logged_in' ));
        $nonce = wp_create_nonce('login-modal'.$cookie["token"]);

        $options = $this->check_options();

        //echo "<pre>";
        /* initializing the option value*/
        foreach($options as $key=>$option){
            if($key!="version"){
                $this->$key=$option;
            }
        }

        /* selectign template options */
        $templateOptionName = "login-modal-".str_replace(".php", "", $this->template);
        $defaultOptionName = str_replace(".php", "", $this->template)."Default";
        $templateOptions = $this->check_template_options($templateOptionName,$this->$defaultOptionName);

        if(count($templateOptions)==0){
            $templateOptions = $this->{str_replace(".php","",$this->template)."Default"};
        }
        /*foreach($templateOptions as $key=>$option){
            $this->$key=$option;            
        }*/



        /*
        ** Plupload init starts here
        */
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

        //echo getcwd();
        /*echo bloginfo('pingback_url');

        echo "<br>";
        $plugin_dir_path = dirname(__FILE__);
        echo $plugin_dir_path;
        echo "<pre>";
        die();
        print_r($this->config);
        print_r($this->plugin);
        die();*/
        /*global $wp_rewrite;
        print_r($wp_rewrite->rules["^updateOption"]);
        die();*/
        //index.php?route_name=updateOptionArray
 
        $dir = $this->config['path']['base']."plugin/assets/template";
        $templates=array();
        if (is_dir($dir)){
            if ($dh = opendir($dir)){
                while (($file = readdir($dh)) !== false){
                    if(strlen($file)>4){
                        array_push($templates, $file);
                    }
                }
                closedir($dh);
            }
        }


        global $wp_version; //adding for for v.1.0.3
        global $current_user;
        if ( $wp_version >= 4.5 ) {
            wp_get_current_user(); 
        }
        else{
            get_currentuserinfo(); 
        }

       
        
         wp_register_script( 'indexJS', $this->config["url"]["assets"].'js/admin-index.js' );
        $indexdata = array("options"=>$options,
            "version"=>$this->version,
            "template"=>$this->template,
            "regtemplate"=>$this->regtemplate,
            "forgettemplate"=>$this->forgettemplate,
            "image_path"=>$templateOptions["image_path"],
            "image_path_bg"=>$templateOptions["image_path_bg"],
            "redirect_url"=>$this->redirect_url,
            "log_out_redirect_url"=>$this->log_out_redirect_url,
            "register_redirect_url"=>$this->register_redirect_url,
            "path"=>get_site_url(),
            'plupload_init'=>$plupload_init,
            "esc"=>'Add Image',
            "nonce"=>$nonce,
            "asset_path"=>$this->config["url"]["assets"],
            "templates"=>$templates,
            "templateOptions"=>$templateOptions,
            "config"=>$this->config,
            "template1Default"=>$this->template1Default,
            "template2Default"=>$this->template2Default,                                                                             
            "template3Default"=>$this->template3Default,
            "template4Default"=>$this->template4Default,
            "ajaxurl"=>admin_url('admin-ajax.php'),
            "optionsName"=>$this->optionsName,
            "current_user"=>trim($current_user->user_login));

        wp_localize_script( "indexJS", "data", $indexdata );
        wp_enqueue_script("indexJS" );
        

        wp_enqueue_script('plupload-all');     
        wp_register_script('myplupload', $this->config["url"]["assets"].'js/myplupload.js', array('jquery'));
        wp_localize_script("myplupload", "basedata", array('plupload_init'=>$plupload_init));
        wp_enqueue_script('myplupload');     
        wp_register_style('myplupload', $this->config["url"]["assets"].'css/myplupload.css');
        wp_enqueue_style('myplupload');
       
         return $this->view->render('admin/index.html',["options"=>$options,
            "version"=>$this->version,
            "template"=>$this->template,
            "regtemplate"=>$this->regtemplate,
            "forgettemplate"=>$this->forgettemplate,
            "image_path"=>$templateOptions["image_path"],
            "image_path_bg"=>$templateOptions["image_path_bg"],
            "redirect_url"=>$this->redirect_url,
            "log_out_redirect_url"=>$this->log_out_redirect_url,
            "register_redirect_url"=>$this->register_redirect_url,
            "path"=>get_site_url(),
            'plupload_init'=>$plupload_init,
            "esc"=>'Add Image',
            "nonce"=>$nonce,
            "asset_path"=>$this->config["url"]["assets"],
            "templates"=>$templates,
            "templateOptions"=>$templateOptions,
            "config"=>$this->config,
            "template1Default"=>$this->template1Default,
            "template2Default"=>$this->template2Default,                                                                             
            "template3Default"=>$this->template3Default,
            "template4Default"=>$this->template4Default,
            "ajaxurl"=>admin_url('admin-ajax.php'),
            "optionsName"=>$this->optionsName,
            "current_user"=>trim($current_user->user_login),
            ]);


        //add_action('wp_ajax_nopriv_template_value_login_modal','template_value_login_modal');
    }
    /**
	 * @desc Checks to see if the given plugin is active.
	 * @return boolean
	 */
    public function is_plugin_active($plugin) 
    {   
        echo "<pre>";
        print_r($this->check_options());
        return($plugin->general);	
    //return in_array($plugin, (array) get_option('active_plugins', array()));
    }

    public function check_options() 
    {

        $options = null;
        if (!$options = get_option($this->optionsName)) {

                // default options for a clean install
            $options = array(
                'shortcut' => true,
                'template' => 'template1.php',
                'redirect_url'=>get_site_url()."/wp-admin/",
                'log_out_redirect_url'=>get_site_url()."/wp-login.php?action=logout",
                'register_redirect_url'=>get_site_url()."/wp-login.php?checkemail=registered",
                'version' =>"1.0.3",
                'reset' => true,
                /*
                'image_path'=>$this->image_path,
                'logintext'=>'Login',
                'loginbuttontext'=>'Login',
                'registertext'=>'Want to Register?',
                'registerbuttontext'=>'Register',*/
                //'backgroundColor'=>$this->backgroundColor,
                //'textColor'=>$this->textColor,
                /*'headerBackgroundColor'=>$this->headerBackgroundColor,
                "headerTextColor"=>$this->headerTextColor,
                "bodyBackgroundColor"=>$this->bodyBackgroundColor,
                "bodyTextColor"=>$this->bodyTextColor,
                "footerBackgroundColor"=>$this->footerBackgroundColor,
                "bodyTextColor"=>$this->footerTextColor,
                "loginbuttonBackgroundColor"=>$this->loginbuttonBackgroundColor,
                "loginbuttonTextColor"=>$this->loginbuttonTextColor,
                "registerbuttonBackgroundColor"=>$this->registerbuttonBackgroundColor,
                "registerbuttonTextColor"=>$this->registerbuttonTextColor, 
                "loginbuttonBorderColor"=>$this->loginbuttonBorderColor,
                "registerbuttonBorderColor"=>$this->registerbuttonBorderColor, */
                );
            foreach($this->template1Default as $key=>$value){
                $options[$key] = $value;
            }
            update_option($this->optionsName, $options);
            update_option("login-modal-template1", $this->template1Default);
            update_option("login-modal-template2", $this->template2Default);
            update_option("login-modal-template3", $this->template3Default);
            update_option("login-modal-template4", $this->template4Default);
        }
        else {

                        // check for upgrades
            if (isset($options['version'])) {

                if ($options['version'] < $this->version) {
                            // post v1.0 upgrade logic goes here
                    /*$temp5 = get_option("login-modal-template5");

                    if(!isset($this->template5Default) && count($temp5)<2){ // always getting the count/sizeof 1
                        update_option("login-modal-template5", $this->template5Default);
                    }*/
                }
                else{
                    
                    $temp4 = get_option("login-modal-template4");

                    if(!isset($this->template4Default) && count($temp4)<2){ // always getting the count/sizeof 1

                        update_option("login-modal-template4", $this->template4Default);
                    }
                    //folllowing example is for if we update the version in just previous if statement
                    $options["regtemplate"]="reg".$options['template'];
                    $options["forgettemplate"]="forget".$options['template'];
                    //$options['log_out_redirect_url'] = $this->log_out_redirect_url;
                    if(!isset($options['rememberText'])){
                        $options['rememberText'] = $this->rememberText;
                    }
                }
            }
            else {     
                               // pre v1.0 updates



                if (isset($options['admin'])) {
                    unset($options['admin']);                    
                    $options['shortcut'] = true;
                    $options['version'] = $this->version;
                    $options['template'] = $this->template;
                    $options['reset'] = true;
                    $options['redirect_url'] = $this->redirect_url;
                    $options['log_out_redirect_url'] = $this->log_out_redirect_url;
                    $options['register_redirect_url']= $this->register_redirect_url;
                    $options['rememberText'] = $this->rememberText;
                    update_option($this->optionsName, $options);
                }
            }
        }

        return $options;
    }

    /*public function get_options() {
        $options = $this->check_options();
        $this->options = $options;
    }

    /*public function g_plupload_action() {
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
    }*/

    /*public function update_option(){
        $cookie = (wp_parse_auth_cookie( '', 'logged_in' ));
        $token = "login-modal".$cookie["token"];
        $_REQUEST["_ajax_nonce"] = $_POST["security"];
        check_ajax_referer($token);
        parse_str($_POST['data'], $formdata);
        $options = get_option($this->optionsName);
        foreach ($formdata as $key=>$value) {
            if($key=="log" || $key=="pwd" || $key=="img1"){
                unset($formdata[$key]);
            }
            //if($key=="template" || $key=="redirect_url"){
                $options[$key]=$value;
            //}
        }
        if(!isset($formdata['makeItRound'])){
            $formdata['makeItRound']=0;
        }
        $templatOptionName ="login-modal-". str_replace(".php","",$formdata['template']);
        update_option($this->optionsName, $options);
        if(update_option($templatOptionName, $formdata)){
             return $formdata['template'];
        }
        else {
            return false;
        }
       //$nonce = wp_create_nonce('img1pluploadan');
    }*/

    public function check_template_options($option_name,$defaultOption){/*
        $options = get_option($option_name);
        if (null == $options) {*/
        $options = null;
        if (!$options = get_option($option_name)) {
            $options = $defaultOption;
            update_option($option_name, $options);
        }
        else{
            $dif = array_diff_key($defaultOption,$options);
            if(count($dif)>0){
                foreach($dif as $key=>$value){
                    $options[$key]=$value;
                }
                update_option($option_name, $options);
            }
        } 

          
        return array_map('trim',$options);
    }

    public function ajaxTemplateOptions(){
        $templateOptionName = "login-modal-".str_replace(".php", "", $_GET["template"]);
        $defaultOptionName = str_replace(".php", "", $_GET["template"])."Default";
        $templateOptions = $this->check_template_options($templateOptionName,$this->$defaultOptionName);
        echo json_encode($templateOptions);
    }
   function template_value_login_modal(){
        $templateOptionName = "login-modal-".str_replace(".php", "", $_POST["template"]);
        $defaultOptionName = str_replace(".php", "", $_POST["template"])."Default";
        $templateOptions = $this->check_template_options($templateOptionName,$this->$defaultOptionName);
        echo json_encode($templateOptions);
    }
}
?>