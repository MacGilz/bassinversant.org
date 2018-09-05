<?php
/* * *
 *
 * handle all the settings , defined in admin panel
 * */

class Native_All_Settings {

    STATIC $setting_key = 'native_plugin_settings_key';
    public $meta_key;
    public $key = null;
    public $debug = false;
    public $settings = array();
    public $sql_query = array();    //track sent post query
    public $log_query = array();    //track sent post query
    public $postids = '';
    public $postidsArray = array();
    public $native_user_id = '';
    public $overwrite = false;

    function __construct() {
       
        //add_action();
    }

    function set($key, $value, $secure = false) {
        if ($key == '' or $key == null)
            return false;

        if (is_array($value))
            $value = implode(",", $value);

        $AllValues = $this->getAllSettings();

        if ($value == null)
            $value = false;

        $AllValues[$key] = $value;

        if ($this->debug) {
            //print '<pre>';
            //print_r($AllValues);
            //print '</pre>';
        }

        return update_option(self::$setting_key, $AllValues);
    }

    function get($meta_key, $default = '') {
        if ($meta_key == null)
            return false;

        $all_settings = get_option(self::$setting_key);
        if ($this->overwrite) {
            $all_settings = apply_filters('update_settings_data', $all_settings);
        }

        $this->settings = $all_settings;
        $all_settings = $this->addManuals();
        $meta_value = ( isset($all_settings[$meta_key]) ? $all_settings[$meta_key] : $default);
        return $meta_value;
    }

    function getAllSettings() {
        $this->meta_key = self::$setting_key;
        $all_settings = get_option($this->meta_key, array());
        return $all_settings;
    }

    function addManuals($settings = array()) {
        $settings = $this->settings;
        $settings['siteurl'] = get_option('siteurl');
        return $settings;
    }
    
    function check_table_status($table_name = '') {
        global $wpdb;
        $schema_name = $wpdb->dbname;
        if ($table_name == '')
            return false;

        $query = "SELECT * FROM information_schema.tables WHERE `table_schema` = '$schema_name' AND `table_name`='$table_name'";
        $wpdb->get_results($query);
        return $wpdb->num_rows;
    }
	function check_log_table_limit($table_name = '') {
        global $wpdb;
        $schema_name = $wpdb->dbname;
        if ($table_name == '')
            return false;

        $query = "SELECT * FROM information_schema.tables WHERE `table_schema` = '$schema_name' AND `table_name`='$table_name'";
        $wpdb->get_results($query);
        return $wpdb->num_rows;
    }

}

/* * *
 * 
 */
$var = new Native_admin_notice;

class Native_admin_notice {
	public	$tb_not_message = ' is not present is database ';
		
    public function __construct() {
        add_action('save_post', array($this, 'save_post'), 120, 2);
        add_action('add_meta_boxes', array($this, 'nativeemail_add_meta_box'));

        add_action('wp_ajax_native-post-notice', array($this, 'native_post_notice_callback'));

        $notice = get_option('native-post-notice-dismissed', '');


        if (empty($notice)) {
            add_action('admin_notices', array($this, 'admin_notices'));
        }
        add_action('admin_notices', array($this, 'admin_general_notice'));
        add_action( 'wp_ajax_nativeemail_alert_create_tables', array( $this ,  'nativeemail_alert_create_tables_callback') );
    }

    public function save_post($post_id, $post) {
        // Do you stuff here
        // Add your query var if the coordinates are not retreive correctly.
        //add_filter('redirect_post_location', array($this, 'add_notice_query_var'), 99);
    }

    public function add_notice_query_var($location) {
       // remove_filter('redirect_post_location', array($this, 'add_notice_query_var'), 99);
       // $native_post_edit = isset($_REQUEST['native_post_edit']) ? $_REQUEST['native_post_edit'] + 1 : 0;
       // return add_query_arg(array('native_post_edit' => $native_post_edit), $location);
    }

    public function admin_notices() {
	
        global $native_settings;
		global $post;
		
		$selected_post = $native_settings->get("native_selected_post_type" , "post");
		
		if(isset($post->post_type) && $post->post_type == $selected_post){
        ?>
        <script type="text/javascript">
            jQuery(document).on('click', '.native-post-notice .notice-dismiss', function () {
                jQuery.ajax({
                    url: "<?php echo admin_url('admin-ajax.php'); ?>",
                    type: "post",
                    data: {action: 'native-post-notice'}
                })
            });
        </script>
        <div class="updated notice native-post-notice is-dismissible">
            <?php
				$native_post_size = $native_settings->get('nativeemail_per_user_send', 100);
            ?>
            <p style="color: green;">
                <?php esc_html_e('To optimise performance and speed, Native Email limits the number of email sends to ' . $native_post_size . ' a time.', 'emailalertpro'); ?>
            </p>
        </div>
        <?php
		
		}
    }

    
    /**
     * admin post notification dismiss
     */
    function native_post_notice_callback() {
        update_option('native-post-notice-dismissed', 'yes');
	 }

    function nativeemail_add_meta_box() {
		global $native_settings;
        $args = array('public' => true, '_builtin' => false);
        $output = 'names';
        $operator = 'or';

        $screens = get_post_types($args, $output, $operator);
		
		$post_type = $native_settings->get("native_selected_post_type" , "post");
		
        foreach ($screens as $screen) {
			if($screen == $post_type){
				add_meta_box( 'myplugin_sectionid', __('Native Email', 'myplugin_textdomain'), array($this,'nativeemail_meta_box_callback'), $screen);
			}
        }
    }

    function nativeemail_meta_box_callback($post) {
	
        global $native_settings;
        // Add a nonce field so we can check for it later.
		
		
			wp_nonce_field('nativeemail_save_meta_box_data', 'nativeemail_meta_box_nonce');
			do_action("nativeemal_wp_progress_bar");
		
    }

    /*     * *
     * * security / maintaince functions
     * * */

     function admin_general_notice() {
        global $native_settings, $wpdb;
        $table_name = $wpdb->prefix . "emailalertpro";
        $table_name2 = $wpdb->prefix . "NativeEmail_sentlist";
        $table_name3 = $wpdb->prefix . "nativeemail_sentlist_settings";

        if (!$native_settings->check_table_status($table_name)) {
            
            ?>
            <div class="notice notice-error  is-dismissible">
                <p style="color: red;">
                    <?php esc_html_e($table_name . $this->tb_not_message, 'emailalertpro'); ?>
                    <a href="<?php echo admin_url( 'admin-ajax.php?action=nativeemail_alert_create_tables&table='.$table_name );?>" target="_blank">Click here to create</a>
                </p>
            </div>
            <?php
        }
        if (!$native_settings->check_table_status($table_name2)) {
            ?>
            <div class="notice notice-error  is-dismissible">
                <p style="color: red;">
                    <?php esc_html_e($table_name2 . $this->tb_not_message, 'emailalertpro'); ?>
                    <a href="<?php echo admin_url( 'admin-ajax.php?action=nativeemail_alert_create_tables&table='.$table_name2 );?>" target="_blank">Click here to create</a>
                </p>
            </div>
            <?php
        }
		
        if (!$native_settings->check_table_status($table_name3)) {
            ?>
            <div class="notice notice-error  is-dismissible">
                <p style="color: red;">
                    <?php esc_html_e($table_name3 . $this->tb_not_message, 'emailalertpro'); ?>
                    <a href="<?php echo admin_url( 'admin-ajax.php?action=nativeemail_alert_create_tables&table='.$table_name3 );?>" target="_blank">Click here to create</a>
                </p>
            </div>
            <?php
        }
		
		$sent_log_status = "true";
		
		if ( $sent_log_status && get_option("native_sent_log_info" , "no") != "yes"){
            ?>
            <div class="notice notice-warning  is-dismissible nativeemail-admin-notice" attr="native_sent_log_info">
				<p>
					Looking for <b>Native Email Sent Log</b>?  Native Email extensions must now be installed separately.  Get them
					<a href="http://nativeemail.com/shop/"	 target="_blank">here</a>.
				</p>
            </div>
            <?php
        }
		
    }

     function nativeemail_alert_create_tables_callback(){
        do_action('emailalertpro_create_table');
        print 'tables created....<br/>';
        print '<a href="javascript:history.go(-1)">Go back....</a>';
        exit;
    }
}

/**
 * WEBSITE HOME URL
 * */
function website_home_url() {
    print '<input type="hidden" name="website" value="' . get_bloginfo('url') . '" class="footer website_url"/>';
}
?>