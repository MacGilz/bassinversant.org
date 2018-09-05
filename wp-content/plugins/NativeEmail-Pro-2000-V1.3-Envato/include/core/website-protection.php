<?php
/* * **
 * ** inherit main protection code
 * ** apply website protection code
 * ** */

//	

class Websie_Protection extends nativeemail_protect_code {
    /** 
	** website api variables
	**/

    public $SL_APP_API_URL = 'http://nativeemail.com/index.php';
    public $SL_PRODUCT_ID = "";
    public $main_product_id = NATIVEEMAIL_PLATFORM_ID;
    public $protocol = 'http://';
    public $SL_INSTANCE = '';
    public $license_key;
    /*     * ***return parameters*** */
    protected $code = true;
    protected $status = "";
    protected $message = "";

    function __construct( $contruct = true) {
		if($contruct){
			add_action('ne_protection_form_below', array($this, 'ne_protection_website_protection_form'));
			add_action('wp_ajax_ne_activate_licese', self::authenticate_key_with_website());
			add_action('init', array($this , "deactivation_check_for_mainplugin"));
			add_action("admin_footer"  , array($this , "notice_dismiss_script"));
			add_action("wp_ajax_native_dismiss_acf_notice"  , array($this , "native_dismiss_acf_notice"));
			
			$this->protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
			$this->SL_INSTANCE = str_replace($this->protocol, "", get_bloginfo('wpurl'));
			parent::__construct();
		}	
    }

    function ne_protection_website_protection_form(){
	
        $status = get_option('nativeemail_license_update_status');
		
        if ($status == 'yes')
            $email_status = 'checked';
        else
            $email_status = '';
			
        ?>
	<?php //if(NATIVEEMAIL_PLATFORM == 'website'):?>	
        <div class="wrap website_protection_form" style="display:none;">
            <div>
				Please enter the licence key for this product to activate it. You were given a software licence key when you purchased this item.
			</div>
			
            <form action="" method="post">
			
                <table class="form-table">
        <?php 
				do_action('ne_evanto_form_above'); 
				$label = "Licence Key for Native Email";
				
				//$this->childClassFormEntries($label , $this->main_product_id); 
				
				do_action('ne_evanto_form_below'); 
		?>
                    <tr>
                        <td>
                            <label for="nativeemail_license_email_website">Email</label>
                        </td>
                        <td>
                            <input class="regular-text" type="email" id="nativeemail_license_email_website" name="nativeemail_license_email_website"  
							value="<?php echo get_option('nativeemail_license_email_website', ''); ?>" >
							<input type="hidden" name="nativeemail_license_type" value="website">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="nativeemail_license_update_status_website">Recieve Email Updates</label>
                        </td>
                        <td>
                            <input class="" type="checkbox" id="nativeemail_license_update_status_website" name="nativeemail_license_update_status_website"  value="yes" <?php echo $email_status; ?> />
                        </td>
                    </tr>
                </table>
            </form>
        </div>
		<?php //endif; ?>
        <script type="text/javascript">
		
            jQuery(".activate-extension").on("click", function () {
			
				var dhis = jQuery(this);
                var target_source_id = jQuery(this).attr("target");
                var license_key = jQuery("#" + target_source_id).val();
                var product_id = jQuery("#" + target_source_id).attr("product_id");
                var email = jQuery("#nativeemail_license_email_website").val();
				
                var notification = jQuery("#nativeemail_license_update_status_website").val();
				
				if(jQuery("#nativeemail_license_update_status_website"). prop("checked") == true){
					notification = "yes";
				}
				else if(jQuery("#nativeemail_license_update_status_website"). prop("checked") == false){
					notification = "no";
				}
               
			    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
				
				//console.log(emailReg.test( email ));
	
				if( email  == '') {
						alert("Empty email address field");
						return false;
				}
				
				if( !emailReg.test( email ) ) {
					alert("invalid email address");
						return false;
				}
	
                if (!license_key) {
                    alert("invalid license key");
                    return false;
                }

				
				
                jQuery.ajax({
                    type: "post",
                    url: "<?php echo admin_url('admin-ajax.php'); ?>",
                    data: {
                        "action": "ne_activate_licese",
                        "license_key": license_key,
                        "product_id": product_id,
                        "email": email,
                        "notification_status": notification,
                        "ajax": "yes",
                    },
                    beforeSend: function () {
							dhis.next(".processing").show();
                    },
                    success: function (response) {
						result = jQuery.parseJSON(response);
						dhis.next(".processing").html(result.message);
                        console.log(response);
                        //alert();
                    },
                    error: function (data) {

                    }
                });

                //alert(jQuery(this).html());
                return false;
				
            });
        </script>
        <?php
    }

    
    public function childClassFormEntries( $label_text = null , $product_id ){
	
        $license_data = get_option( $product_id , "");
        $key = isset($license_data["key"])?$license_data["key"]:'';
		?>
			<tr>
				<td style="width:380px;">
						<label for="<?php echo $product_id; ?>">
							<?php echo $label_text;?>
						</label>
				</td>                
				<td>
					<input class="regular-text" type="text" id="<?php echo $product_id; ?>" name="<?php echo $product_id; ?>"  value="<?php echo $key ?>"  product_id="<?php echo $product_id; ?>"/>
					<button target="<?php echo $product_id; ?>" class="activate-extension button-primary">Activate</button>
					<span class="processing" style="display:block"><?php echo @$license_data['message']; ?></span>
				</td>
			</tr>
		<?php
    }
	
    protected function authenticate_key_with_website( $license_key = null ) {
	
			$return = array();
			$status = "success";
			$code = 0;
			$message = '';
			
			$email = (isset($_POST["email"]))?$_POST["email"]:"";
			$notified = (isset($_POST["notification_status"]))?$_POST["notification_status"]:"no";
			$__license_key = (isset($_POST["license_key"]))?$_POST["license_key"]:"";
			
			
        if ($license_key == null) {
				$license_key = $this->license_key;
        }
		
		if ($license_key == null) {
				$license_key = $__license_key;
        }
		
		
		
		if ($license_key == null) {
			return false;
		}
		
        if ($this->SL_INSTANCE == null) {
            $this->protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            $this->SL_INSTANCE = str_replace($this->protocol, "", get_bloginfo('wpurl'));
        }

        if (isset($_POST["ajax"])) {
            $license_key = trim($_POST["license_key"]);
            $this->SL_PRODUCT_ID = trim($_POST["product_id"]);
        }
		
        $args = array(
            'woo_sl_action' => 'activate',
            'licence_key' => $license_key,
            'product_unique_id' => $this->SL_PRODUCT_ID,
            'domain' => $this->SL_INSTANCE,
			"email" => $email,
			"notified" => $notified
        );

        $request_uri = $this->SL_APP_API_URL . '?' . http_build_query($args);
		$return["request_uri"] = $request_uri;
		
        if ($license_key && $this->SL_PRODUCT_ID && $this->SL_INSTANCE) {

            $data = wp_remote_get($request_uri);

            if (is_wp_error($data) || $data['response']['code'] != 200 || !is_array($data)) {
                $status = "error";
                $code = "400";
                $message = "error establishing connection to extension server"; //there was a problem establishing a connection to the API server
				
            }

            $data_body = json_decode($data['body']);

            $data_body = (isset($data_body[0])) ? $data_body[0] : $data_body;

            if (isset($data_body->status) && $status == "success") {
                
						if($data_body->status == 'success' && $data_body->status_code == 's100') {
							
							$data = $this->activate_extension( $this->SL_PRODUCT_ID, $license_key , $email ,  $notified);
							
							if ($data) {
								$code = 0;
								$status = $data;
								$message = "Extension is activated";
							}
							else {
								$code = 0;
								$status = "success";
								$message = "Error While activation on $this->SL_INSTANCE , activated from server side";
							}
						} 
					else {
								//there was a problem activating the license
								$code = $data_body->status_code;
								$status = $data_body->status;
								$message = $data_body->message;
					}
            }
        }
		
		$return["status"] = $status;
		$return["code"] = $code;
		$return["message"] = $message;
			
        if (isset($_POST["ajax"])) {
            echo json_encode($return);
            exit;
        } else {
            return $return;
        }
    }

    
    public function activate_extension( $product_id = null , $license_key , $email = ""  , $notified = "no") {
	
        if ($product_id == null) {
            return false;
        }
		
        //save the license
        $license_data = array();
        $license_data['key'] = $license_key;
        $license_data['last_check'] = time();
        $license_data['email'] = $email;
        $license_data['notified'] = $notified;
        $result  = update_option($product_id , $license_data);
         update_option("nativeemail_license_email_website" , $email);
         update_option("nativeemail_license_email_notified" , $notified);
        return $result;
    }
    
    
	public function licence_deactivation_check( $product_id = null ) {

			if ($this->SL_INSTANCE == null) {
				$this->protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
				$this->SL_INSTANCE = str_replace($this->protocol, "", get_bloginfo('wpurl'));
			}
		
        if (!$this->licence_key_verify($product_id))
            return;

		 
		
        $license_data = get_site_option($product_id);

        if (isset($license_data['last_check'])) {

            if (time() < ($license_data['last_check'] + 86400)) {
                return;
            }
        }

        $_license_key = $license_data['key'];


        $args = array(
            'woo_sl_action' => 'status-check',
            'licence_key' => $_license_key,
            'product_unique_id' => $product_id,
            'domain' => $this->SL_INSTANCE,
        );

        $request_uri = $this->SL_APP_API_URL . '?' . http_build_query($args, '', '&');
		
        $data = wp_remote_get($request_uri);



        if (is_wp_error($data) || $data['response']['code'] != 200)
            return;

        $response_block = json_decode($data['body']);
		
		
        //retrieve the last message within the $response_block

        $response_block = $response_block[count($response_block) - 1];
        $response = $response_block->message;
		
        if (isset($response_block->status)) {
		
            if ($response_block->status == 'success') {
                if ($response_block->status_code == 's203' || $response_block->status_code == 's204') {
                    $license_data['key'] = '';
                }
            }
            if ($response_block->status == 'error') {
                $license_data['key'] = '';
            }
        }
		
        $license_data['last_check'] = time();
        $license_data['message'] = $response;		
        update_site_option( $product_id , $license_data);
    }

    
	public function licence_key_verify($product_id) {

        $license_data = get_site_option($product_id);

        if (!isset($license_data['key']) || $license_data['key'] == '')
            return FALSE;

        return TRUE;
    }

	/****
	** to display admin notice for extension status
	***/ 
	public function extension_status(){
	
			$product_id = $this->main_product_id;
			if(!$product_id){
				return false;
			}
			//return ;
			$license_data = get_option( $product_id , false);
			
			$key = ($license_data["key"])?$license_data["key"]:false;
			return $key;    
	}
	
	public function deactivation_check_for_mainplugin(){
			$this->licence_deactivation_check($this->main_product_id);
	}
	
	
	public function  notice_dismiss_script(){
	?>
	<script type="text/javascript">
	/**** backend admin notices***/
			
				jQuery(".nativeemail-admin-notice").on( "click" , ".notice-dismiss" , function(){
				
				//jQuery(".nativeemail-admin-notice .notice-dismiss").on( "click" , function(){
						var extensionId = jQuery(this).parent(".nativeemail-admin-notice").attr("attr");
						
						jQuery.ajax({
							url: ajaxurl,
							type:"post",
							data: {action: 'native_dismiss_acf_notice',"extensionId":extensionId},
							success:function(response){
							},
							error:function(){
								alert("error occured dismissing notice");
							}
						});
						
				});
	</script>		
	<?php
	}
   public function native_dismiss_acf_notice(){
			$extensionId = $_POST["extensionId"];	
			delete_option($extensionId);
			$res = add_option($extensionId  , "yes");
			var_dump($res , $extensionId);
			exit;
   }	
}
?>