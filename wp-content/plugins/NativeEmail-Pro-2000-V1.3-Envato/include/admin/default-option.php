<?php
add_action('emailalertpro_add_default' , 'emailalertpro_add_default');
add_action('nativeeamil_add_versioncontrol' , 'emailalertpro_add_plugin_version');
add_action('nativeeamil_remove_versioncontrol' , 'emailalertpro_remove_plugin_version');

function emailalertpro_add_default(){
	global $emailalertpro;
	do_action("emailalertpro_create_table");
	do_action("nativeemail-change-option");	
	$common_class = new emailalertpro_commonclass;
	$emailalertpro_templates =  new emailalertpro_templates;
	$common_class->add_category_number('500');
    $admin_email = get_option('admin_email');    
	$common_class->add_subscriber( $admin_email , $state = 'active' , $comma_separated_category_id = null );
}


function emailalertpro_add_plugin_version(){
		update_option('NATIVEEMAILPLUGIN', 'NATIVEEMAILPLUGIN-1.3');
}

function emailalertpro_remove_plugin_version(){
		delete_option('NATIVEEMAILPLUGIN');
}

if(!function_exists('get_the_permalink')){
	
	function get_the_permalink($id = null){
			return	get_permalink($id);
	}	
}
?>