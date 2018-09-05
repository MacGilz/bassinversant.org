<?php

/**
 * Plugin Name:  Native Email Pro               
 * Plugin URI:  http://nativeplugins.com
 * Description: Give your site users instant, flexible, personalised email alerts.  Native Email promotes all your content including blog posts, directory listings, eCommerce products or pages.
 * Version:  1.3
 * Author: Michael Donaghy
 * Author URI: 
 */
/*
envato version
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
 *  fixed 06-16-2016
 
ini_set('max_execution_time', 300);
ini_set('memory_limit', '1000M');
*/

//send_email_on_post_creation
define('NATIVEEMAILPLUGIN', 'NATIVEEMAILPLUGIN-1.3');
define('NATIVEEMAIL_PLATFORM', 'envato');
define('NATIVEEMAIL_PLATFORM_ID', 'nativeemail_envato_pro');
/* 	Check if current version of wordpress is higher than 3.3 as cron job is implemented */

if (version_compare($GLOBALS['wp_version'], '3.3', '<') || !function_exists('add_action')) {
    if (!function_exists('add_action')) {
        $exit_msg = __("Use this plugin using add_action rather than calling directly", 'EmailAlertPro');
    } else {
        $exit_msg = sprintf("Wordpress version should be higher than %s for compatibility purpose", '3.3');
    }
    wp_die($exit_msg);
}

/* usally this plugin not compatibale on multisie /Network sites . */
if (!function_exists('is_plugin_active_for_network')) {
    require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
}

/* Deactivate for multisite plugin */
if (is_plugin_active_for_network(plugin_basename(__FILE__))) {
    deactivate_plugins(plugin_basename(__FILE__));
    $exit_msg = __('Native Email Unlimited cannot be activated as a network plugin. Please activate it at on a Single Site', 'EmailAlertPro');
    exit($exit_msg);
}


/* 	add required files	 */
global $emailalertpro, $catepro_font_family, $native_settings;


/* 	define keywords	 */
define('EAPSITEPATH', trailingslashit(dirname(__FILE__)));
define('EAPDIRPATH', trailingslashit(dirname(plugin_basename(__FILE__))));
define('EAPSITEURL', plugin_dir_url(dirname(__FILE__)) . EAPDIRPATH);
define('INCLUDEFILEURL', dirname(__FILE__));
define('emailalert_url', plugin_dir_url(__FILE__));
define('EMAILALERTPRO_LOG_PLUGIN_FILE', __FILE__);

/* 	define global keyword	 */
$emailalertpro['CATEGORYNUMBER'] = 'EmailAlertPro_Category_number';
$emailalertpro['category_number_to_return'] = 5;
$emailalertpro['category_include'] = 'EmailAlertPro_category_include';
$emailalertpro['category_exclude'] = 'EmailAlertPro_category_exclude';
$emailalertpro['show_empty_category_list'] = 'EmailAlertPro_show_empty_category_list';
$emailalertpro['send_email_on_new_post_creation'] = 'EmailAlertPro_send_email_on_new_post_creation';
$emailalertpro['send_most_popular_emails'] = 'EmailAlertPro_send_email_most_popular';
$emailalertpro['setup_sender_email'] = 'EmailAlertPro_sender_email';
$emailalertpro['emailalert_email_frequency'] = 'EmailAlertPro_email_frequency';
$emailalertpro['category_list_not_included'] = 'EmailAlertPro_category_list_not_included';


add_action('admin_enqueue_scripts', 'emailalertpro_load_custom_wp_admin_style');
add_action('wp_footer', 'website_home_url');

/* 	activation hooks and deactivate hooks	 */
register_activation_hook(__FILE__, 'EmailAlertPro_activate');
register_deactivation_hook(__FILE__, 'EmailAlertPro_deactivate');


// When the Plugin installed

/* 	include additional files	 */
require_once(INCLUDEFILEURL . '/include/core/protection-code.php');
require_once(INCLUDEFILEURL . '/include/core/settings.php');
require_once(INCLUDEFILEURL . '/include/core/users.php');

$native_settings = new Native_All_Settings;


require_once(INCLUDEFILEURL . '/include/admin/default-option.php');
require_once(INCLUDEFILEURL . '/include/core/common.php');
require_once(INCLUDEFILEURL . '/include/core/nativeemail_core_sendemal.php');
require_once(INCLUDEFILEURL . '/include/core/nativeemail_core_functions.php');
require_once(INCLUDEFILEURL . '/include/core/nativeemail_core_posts.php');

require_once(INCLUDEFILEURL . '/include/core/common-function.php');

require_once(INCLUDEFILEURL . '/include/core/nativeemail_core_posts.php');
require_once(INCLUDEFILEURL . '/include/core/scheema.php');
require_once(INCLUDEFILEURL . '/include/cronfile.php');
require_once(INCLUDEFILEURL . '/include/category-manage.php');
require_once(INCLUDEFILEURL . '/include/widget.php');
require_once(INCLUDEFILEURL . '/include/newpostcreate.php');
require_once(INCLUDEFILEURL . '/include/admin/admin-genral-option-settings.php');
require_once(INCLUDEFILEURL . '/include/template-functions.php');

require_once(INCLUDEFILEURL . '/include/core/change-category.php');
require_once INCLUDEFILEURL . '/include/admin/templates/File_CSV_DataSource/DataSource.php';


$admin_settings = new emailalertpro_templates;
$catepro_font_family = $native_settings->get('emailalertpro_template_font_family_name', 'Helvetica, Arial, sans-serif');


/* 	otherwise buffer error on inner file	 */
if (isset($_POST['export_into_csv']) && !empty($_POST['export_into_csv'])) {
    global $wpdb;
    $table_name = $wpdb->prefix . "emailalertpro";
    CSV_GENERATE($table_name);
}

function EmailAlertPro_activate() {
    do_action('emailalertpro_add_default');
    do_action('nativeeamil_add_versioncontrol');
}

function EmailAlertPro_deactivate() {

    wp_clear_scheduled_hook(
            'EmailAlertProCron', array(
        'freq' => 'daily',
        'freq' => 'twicedaily',
        'freq' => 'hourly',
        'freq' => 'never'
            )
    );
	
    do_action('native_cancel_setup_crons');
    do_action('nativeeamil_remove_versioncontrol');
}
add_action("activated_plugin", "ne_this_plugin_first");

function ne_this_plugin_first() {
	// ensure path to this file is via main wp plugin path
	$wp_path_to_this_file = preg_replace('/(.*)plugins\/(.*)$/', WP_PLUGIN_DIR."/$2", __FILE__);
	$this_plugin = plugin_basename(trim($wp_path_to_this_file));
	$active_plugins = get_option('active_plugins');
	$this_plugin_key = array_search($this_plugin, $active_plugins);
		if ($this_plugin_key) { // if it's 0 it's the first plugin already, no need to continue
			array_splice($active_plugins, $this_plugin_key, 1);
			array_unshift($active_plugins, $this_plugin);
			update_option('active_plugins', $active_plugins);
		}
	}

/* * *
 * * MAIN PLUGIN FILE CLASS
 * ** */

class EmailAlertPro {
	public $status = '';
    public function __construct() {
        add_action('admin_menu', array($this, 'addmenus'));
        add_action('wp_enqueue_scripts', array($this, 'load_scripts'));
		
		$wp = new Websie_Protection;
		$pluginStatus = $wp->extension_status();
		$this->status = $pluginStatus;
		
    }

    public function addmenus() {

        $pcode = new nativeemail_protect_code;
		
        $pkey = 'nativeemail_license_key';
        $websiteStatus = $this->status;
        $evantoStatus = get_option("nativeemail_license_key" , "");
        
        if ( $evantoStatus == '') {
            $targetCode = array($pcode, 'general_settings_key');
            add_menu_page(__('Native Email'), __('Native Email'), 'manage_options', __('nativeemailpro'), $targetCode, EAPSITEURL . 'assets/images/EAPIcon.png');
            add_submenu_page('nativeemailpro', 'Licence Key', 'Licence Key', 'publish_posts', 'nativeprotection', array($pcode, 'general_settings_key'));
        } else {
            $targetCode = array($this, 'emailalertprosettings');
            add_menu_page(__('Native Email'), __('Native Email'), 'manage_options', __('nativeemailpro'), $targetCode, EAPSITEURL . 'assets/images/EAPIcon.png');
            
			add_submenu_page('nativeemailpro', __('Licence Key'), __('Licence Key'), 'publish_posts', 'nativeprotection', array($pcode, 'general_settings_key'));
        }
    }

    public function load_scripts() {
        $deps = array();
        $media = 'all';
        $ver = '';
        wp_enqueue_script('emailalertpto-java', EAPSITEURL . 'include/js/nativeemail.js', $deps, $ver, true);
        wp_enqueue_style('emailalertpto-style', EAPSITEURL . 'include/css/nativeemail.css', $deps, $ver, $media);
    }

    public function emailalertprosettings() {
        $menuclass = new emailalertpro_admin;
        return $menuclass->emailalertpro_general_settings();
    }

    public function emailalertpro_general_settings() {
        $menuclass = new emailalertpro_admin;
        return $menuclass->general_settings();
    }

    public function emailalertpro_template_settings() {
        require_once('include/admin/template-settings.php');
    }

}

function emailalertpro_load_custom_wp_admin_style() {

    wp_enqueue_script('color_picker_script', EAPSITEURL . 'include/js/colorpicker.js', true);
    wp_enqueue_style('color_picker_style', EAPSITEURL . 'include/css/colorpicker.css', true, '1.0.0');

    wp_enqueue_style('category_email_style', EAPSITEURL . 'include/css/category_email_style.css', true, '1.0.0');

    wp_enqueue_script('email_alert_script', EAPSITEURL . 'include/js/email_alert_script.js', array('color_picker_script'), true);
    wp_enqueue_script('nativeemail', EAPSITEURL . 'include/js/nativeemail.js', array('jquery'), null, true);

    wp_enqueue_script('selectivity-full', EAPSITEURL . 'assets/selectivity/selectivity-full.js');

    @$_GET['tab'] = isset($_GET['tab']) ? $_GET['tab'] : false;

    if (isset($_GET['page']) && ($_GET['page'] == 'nativeemailpro' or ($_GET['page'] == 'nativeprotection' && @$_GET['status'] == 'activated'))) {
        wp_enqueue_script('lessjs', EAPSITEURL . 'include/admin/js/less.min.js');
        wp_enqueue_script('excanvas', EAPSITEURL . 'include/admin/js/excanvas.js');
        wp_enqueue_script('bootstrap_min', EAPSITEURL . 'include/admin/js/bootstrap.min.js');
		wp_enqueue_style('bootstrap', EAPSITEURL . 'include/admin/css/bootstrap.min.css');
        wp_enqueue_script('jquery-widget', EAPSITEURL . 'include/admin/js/jquery.ui.widget.js');
        wp_enqueue_script('file-upload', EAPSITEURL . 'include/admin/js/jquery.fileupload.js');
        wp_enqueue_style('tooltp', EAPSITEURL . 'include/admin/js/tooltipsy.js');
        wp_enqueue_style('fileupload', EAPSITEURL . 'include/admin/css/fileupload.css');
        wp_enqueue_style('glyphicons_regular', EAPSITEURL . 'include/admin/css/glyphicons_regular.css');
        wp_enqueue_style('module', EAPSITEURL . 'include/admin/css/module.admin.stylesheet-complete.sidebar_type.collapse.min.css');
        wp_enqueue_style('selectivity', EAPSITEURL . 'assets/selectivity/selectivity-full.css');
        wp_enqueue_style('bootstrap_select_style', EAPSITEURL . 'include/admin/css/bootstrap-select.css');
        wp_enqueue_style('serverstyle', EAPSITEURL . 'include/admin/css/serverstyle.css');
    }
    wp_enqueue_style('nativeemailstyle', EAPSITEURL . 'include/admin/css/nativeemailstyle.css', true, '1.0.0');
	
	
}

$var = new EmailAlertPro;
?>