<?php
class emailalertpro_admin{

	function emailalertpro_general_settings(){
		if ( !function_exists('add_action') ) {
			exit();
		}

global $emailalertpro , $wpdb, $wp_version, $current_tab;
$admin_settings = new emailalertpro_commonclass;
$current_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : 'nativeemailpro';

// show our form

echo "<div class=\"wrap\">";



if ( version_compare($GLOBALS['wp_version'], '3.8', '<=') ) {
	echo "<div id=\"icon-options-general\" class=\"icon32\"></div>";
}
$tabs = array( 
				'nativeemailpro'   =>  	'Account',
				'notification' 	   => 	'General',
				'widget'    	   =>  	'Widgets',
				'layoutpicker'	   =>	'Layout Picker',
				'tmplatedesign'    =>	'Template Design',
				'contentcontrol'   => 	'Content Control',
			    'registered' 	   => 	'User Management',
				//'sentlog'		   =>	'Sent Log',
			   );
	          

echo "<div class=\"nav-tab-wrapper\">";
foreach ( $tabs as $tab_key => $tab_caption ) {
			$active = ($current_tab == $tab_key) ? "nav-tab-active" : "";
	echo "<div class='tab-cover'>";
		echo "<a class=\"nav-tab " . $active . "\" href=\"?page=nativeemailpro&amp;tab=" . $tab_key . "\">" . $tab_caption . "</a>";
	echo "</div>";	
}
echo "</div>";




// send error message if no WordPress page exists
$sql = "SELECT ID FROM $wpdb->posts WHERE post_type='page' AND post_status='publish' LIMIT 1";
$id = $wpdb->get_var($sql);
if ( empty($id) ) {
			echo "<div id=\"page_message\" class=\"error\">
			<p class=\"s2_error\"><strong>" . __('You must create a WordPress page for this plugin to work correctly.', 'emailalertpro') . "</strong></p></div>";
	}
	
// detect or define which tab we are in

	

if ( function_exists('wp_nonce_field') ) {
	//wp_nonce_field('emailalertpro-options_subscribers' . $s2nonce);
}

	switch ($current_tab) {
		case 'account':
				require(dirname(__FILE__).'/admin-account.php');
		break;
		case 'widget':
				require(dirname(__FILE__).'/admin-widget.php');
				//require(dirname(__FILE__).'/general-display.php');
		break;
		case 'widgets':
				require(dirname(__FILE__).'/admin-widgets.php');
		break;
		case 'notification':
				require(dirname(__FILE__).'/admin-notification.php');
		break;
		case 'layoutpicker':
				require(dirname(__FILE__).'/admin-layoutpicker.php');
				//require(dirname(__FILE__).'/template-settings.php');
		break;
		case 'tmplatedesign':
				require(dirname(__FILE__).'/admin-tmplatedesign.php');
		break;
		case 'registered':
				require(dirname(__FILE__).'/admin-usermanagement.php');
		break;
		case 'contentcontrol':
				require(dirname(__FILE__).'/admin-contentcontrol.php');
		break;
		case 'appearance':
				require(dirname(__FILE).'/apperance.php');
		break;
		case 'sentlog':
				require(dirname(__FILE__).'/admin-sentlog.php');
		break;
		default:
				require(dirname(__FILE__).'/admin-account.php');
		break;
	}
	echo "</div>";	
	
		}
	
	function general_settings(){
			require(dirname(__FILE__).'/widget.php');
		}
	
	}
add_action('admin_footer', 'admin_footer_bootstrap_modal');
add_action( 'wp_ajax_template_logo',  'template_logo_callback' );
	
function admin_footer_bootstrap_modal(){

	if(isset($_GET['page']) && (@$_GET['page'] == 'nativeemailpro' or (@$_GET['page'] == 'nativeprotection' && @$_GET['status'] == 'activated'))){
	?>
	<!-- Modal -->
<div id="myModal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" style="display:none;" >
 <div class="modal-dialog modal-sm" style="width:120px;">  
    <div class="modal-content bs-example-modal-sm" >
      <!--
	  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<h4 class="modal-title" id="myModalLabel"></h4>
      </div>
      <div class="modal-body">
		<h3  style="color:green;font-weight:bold;text-align:center;">Settings updated</h3>
      </div>
	  --->
      <div class="modal-footer" style="text-align:center;">
        <button type="button" class="btn btn-default" data-dismiss="modal" id="saved_button">Saved</button>
      </div>
    </div>
  </div>
</div>
<style type="text/css">
.fade {
    -webkit-transition: opacity 1s linear !important;
    transition: opacity 1s linear !important;
}
.modal-backdrop, .modal-backdrop.fade.in{
	opacity:0 !important;
}
body.modal-open{
	overflow:auto;
}
</style>
<script type="text/javascript">
	setTimeout(function() {
		jQuery('#myModal').modal('hide');
	}, 2000);
	jQuery(function(){
		jQuery('select').selectivity({
			showSearchInputInDropdown:false
		});
	});
</script>
	<?php
		}
}

function template_logo_callback(){
			if(isset($_FILES['file']['name']) && $_FILES['file']['name'] !=''){
				$admin_settings = new emailalertpro_commonclass;
				$result = $admin_settings->email_add_header_image($_FILES['file']);
			}
			if($result['status']){
				echo json_encode($result);
			}
			exit;
		}
?>