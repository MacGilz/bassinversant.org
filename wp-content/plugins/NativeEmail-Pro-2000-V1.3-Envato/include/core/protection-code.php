<?php



//$obj = new nativeemail_protect_code;
//$obj->protection_code_callback();

class nativeemail_protect_code{

    private $url;
	
    private $domainname = 'http://verify.nativeemail.com/wp-admin/admin-ajax.php';
    static  $protectionKey = 'nativeemail_license_key';
    public  $error;
    
	
	
    function __construct() {
        add_action('emailalertpro_add_default', array($this, 'protection_code_activation'));
		add_action('init' , array($this , 'protection_code_callback'));
        $this->url = $this->domainname;
		add_action('admin_footer' , array($this , 'display_activated_message'));
		$this->error = @$_GET['info'];
    }

    function general_settings_key() {
	
        require_once( ABSPATH . '/wp-includes/option.php' );
        //$this->protection_code_callback();
        $post_key = self::$protectionKey;
		
		$status = get_option('nativeemail_license_update_status');
		if($status == 'yes')
			$email_status = 'checked';
		else	
			$email_status = 'not-checked';
		
	?>
        <div class="wrap">
		
        <h2>Native Email Licence Management</h2>
		
		<?php  do_action('ne_protection_form_above');?>	
		
		<?php if(NATIVEEMAIL_PLATFORM == 'envato'):?>
        <div>Please enter the licence key for this product to activate it. You were given a licence key when you purchased this item from Envato Marketplace.</div>
		<?php	if($this->error) echo '<h3 style="">'.$this->error.'</h3>'; ?>
		<?php	//if(@$_GET['status'] == 'failed' && @$_GET['info']) echo '<h3 style="">'.@$_GET['info'].'</h3>'; ?>
		
		<form action="" method="post">
            <table class="form-table">
                <tr>
                    <td style="width:180px;"><label for="nativeemail_license_key">Licence Key</label></td>
                    <td ><input class="regular-text" type="text" id="nativeemail_license_key" name="<?php echo self::$protectionKey; ?>"  value="<?php echo get_option('nativeemail_license_key', ''); ?>" ></td>
                </tr>
				
				<tr>
                    <td><label for="nativeemail_license_key">Email</label></td>
                    <td>
						<input class="regular-text" type="email" id="nativeemail_license_email" name="nativeemail_license_email"  value="<?php echo get_option('nativeemail_license_email', ''); ?>" >
						<input type="hidden" name="nativeemail_license_type" value="evanto">
					</td>
                </tr>
				<tr>
                    <td><label for="nativeemail_license_key">Recieve Email Updates</label></td>
                    <td ><input class="" type="checkbox" id="nativeemail_license_update_status" name="nativeemail_license_update_status"  value="yes" <?php echo $email_status;?> >
					</td>
                </tr>
				
            </table>
            <p class="submit">
                <input type="submit" name="activate_license" value="Activate" class="button-primary" />

            </p>
        </form>
		
	<?php endif;?>	
        
		<?php  do_action('ne_protection_form_below');?>	
		</div>
		
		<?php
    }

    function get_client_ip_env() {
			$ipaddress = '';
			if (getenv('HTTP_CLIENT_IP'))
				$ipaddress = getenv('HTTP_CLIENT_IP');
			else if(getenv('HTTP_X_FORWARDED_FOR'))
				$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
			else if(getenv('HTTP_X_FORWARDED'))
				$ipaddress = getenv('HTTP_X_FORWARDED');
			else if(getenv('HTTP_FORWARDED_FOR'))
				$ipaddress = getenv('HTTP_FORWARDED_FOR');
			else if(getenv('HTTP_FORWARDED'))
				$ipaddress = getenv('HTTP_FORWARDED');
			else if(getenv('REMOTE_ADDR'))
				$ipaddress = getenv('REMOTE_ADDR');
			else
				$ipaddress = 'UNKNOWN';
		 
			return $ipaddress;
		}

    public function protection_code_callback(){
	
        global $wpdb;
		
		 $post_key = self::$protectionKey;
		 
		 do_action('ne_protection_code_before_authenticate');
		 
        if (isset($_POST[$post_key]) && $_POST['nativeemail_license_type'] == 'evanto') {
				$nativeemail_license_update_status = @$_POST["nativeemail_license_update_status"];
				if($nativeemail_license_update_status != null){
					$notified = 'yes';
				}else{
					$notified = 'no';
				}
				
				
			$email = (isset($_POST["nativeemail_license_email"]))?$_POST["nativeemail_license_email"]:"";
			//$notified = (isset($_POST["notification_status"]))?$_POST["notification_status"]:"no";
			$__license_key = (isset($_POST[$post_key]))?$_POST[$post_key]:"";
			
			 
			$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
			
			$SL_INSTANCE = str_replace($protocol , "", get_bloginfo('wpurl'));
			
			//$key = $_POST[$post_key];
			
			$args = array(
			//	'action' => 'ne_evanto_activate',
				'license_key' => strip_tags($__license_key) , 
				'product_unique_id' => "1234567890",
				'email' => $email , 
				'receive_email'=> $notified ,
				'ipaddress' => $this->get_client_ip_env(),
				'action' => "evanto_activate",
				);
		    
			$request_uri = $this->domainname . '?' . http_build_query($args);
			
			$return["request_uri"] = $request_uri;
			
			if ($this->domainname) {
				$data = wp_remote_get($request_uri);
				$this->error = false;
			}
			
			if (is_wp_error($data) || $data['response']['code'] != 200 || !is_array($data)) {
                $status = "error";
                $code = "400";
                $message = "error establishing connection to extension server"; //there was a problem establishing a connection to the API server
				$url = admin_url("admin.php?page=nativeprotection&info=".$message."&status=failed");
				wp_redirect(admin_url("admin.php?page=nativeprotection&status=failed"));
                exit;
            }
			
			$data_body = json_decode($data['body'] , true);
            $return = $data_body = (isset($data_body[0])) ? $data_body[0] : $data_body;
			
      
			//$this->error = $return['message'];
			
            if ($return['status'] != "success") {
                $this->error = $return['message'];
                //update_option($post_key, '');
				$message = $return['message'];
				$message = urlencode ($message);
				$url = admin_url("admin.php?page=nativeprotection&info=".$message."&status=failed");
				wp_redirect( $url );
                exit();
            }
			else {

                //Save the license key in the options table
				update_option($post_key, @$_POST[$post_key]);
				update_option('nativeemail_license_sold_at', $return['soldat']);
				update_option('nativeemail_license_email', @$_POST['nativeemail_license_email']);
				
			
			
			 $license_data = array();
        $license_data['key'] = $_POST[$post_key];
        $license_data['last_check'] = time();
        $license_data['nativeemail_license_sold_at'] = time();
        $license_data['email'] = $_POST['nativeemail_license_email'];
        $license_data['notified'] = $nativeemail_license_update_status;
        $result  = update_option($post_key."_evanto_protection" , $license_data);
         update_option("nativeemail_license_email_website" , $email);
         update_option("nativeemail_license_email_notified" , $notified);
		 
		
		 update_option('nativeemail_license_update_status', $license_data['notified']);
		 
				$message = $return['message'];
				$message = urlencode ($message);
				$url = admin_url("admin.php?page=nativeprotection&info=".$message."&status=activated");
				wp_redirect($url);
				exit;
			}
		}
		
		do_action('ne_protection_code_after_authenticate');
	}
    
    function protection_code_activation() {
	/*
        global $wpdb;
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        $table_ACTIVATE = $wpdb->prefix . "activekey";
        $sql1 = "CREATE TABLE " . $table_ACTIVATE . " (
                id mediumint(9) NOT NULL AUTO_INCREMENT,
                licence_key TEXT NOT NULL,
                ip VARCHAR(250) NOT NULL,
                host TEXT NOT NULL,
                PRIMARY KEY  (id)
            );";
        dbDelta($sql1);
        
       global $wpdb;
                $table_ACTIVATE = $wpdb->prefix . "activekey";
                $DATA = $_POST[$post_key];
                $ip = $_SERVER['REMOTE_ADDR'];
                $host = $_SERVER['HTTP_HOST'];
                $insert1 = "INSERT INTO $table_ACTIVATE (licence_key,ip,host) VALUES('$DATA','$ip','$host')";
                $wpdb->query($insert1); 
    */
	
	}
	
	function display_activated_message(){
	
		if(isset( $_GET['page'] ) && @$_GET['page'] == 'nativeprotection' && @$_GET['status'] == 'activated'){
        echo "<script type='text/javascript'>
            jQuery(document).ready(function(){
					jQuery('#saved_button').html('Activated');
                    jQuery.support.transition = false;
					jQuery('#myModal').modal('show');
            });
            </script>";
		}	
    }
		
	protected function authenticate_key_with_evanto($license_key = null, $data = null){
			$return = array();
			if(empty($license_key))
				return false;
				
			$data['license_key'] = strip_tags($license_key);
			
			$ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            $ch_data = curl_exec($ch);
            curl_close($ch);
			$return = json_decode($ch_data, true);		
			return $return;
	}
	
	public function get($meta_key = null){
		if($meta_key != null){
			return $this->{$meta_key};
		}else{
			return false;
		}
		
	}
	
}

require_once(__DIR__.'/website-protection.php');

?>