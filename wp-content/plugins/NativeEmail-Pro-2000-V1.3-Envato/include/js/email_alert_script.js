jQuery(document).ready(function(){
	
	jQuery(".down").click(function(){
		var cover = jQuery(this).attr("alt");
		
		if(jQuery("."+cover).hasClass("templatehidden")){
			jQuery("."+cover).removeClass("templatehidden");
			
				jQuery(this).html('Collapse');			
			}
		else{	
			jQuery("."+cover).addClass("templatehidden");
			jQuery(this).html('Expand');			
		}
		})
	
	 var color_val = jQuery("#color_picker_value").val();
		
		jQuery('#colorpickerHolder').ColorPicker({
		// 	flat: true ,
		color:color_val,
		onChange: function (hsb, hex, rgb){
			jQuery("#colorpickerHolder").css('background-color','#' + hex);		
			jQuery("#color_picker_value").val(hex);	
		}
	});
	
	 var text_picker_value = jQuery("#text_picker_value").val();
	 jQuery('#Textcolor').ColorPicker({
		color:text_picker_value,
		onChange: function (hsb, hex, rgb){
			jQuery("#Textcolor").css('background-color','#' + hex);		
			jQuery("#text_picker_value").val(hex);	
		}
	});
	
	var color_val = jQuery("#background_color_picker_value").val();
	 jQuery('#colorpickerHolder1').ColorPicker({
		 	color:color_val,
		 	onChange: function (hsb, hex, rgb){
			
			jQuery("#colorpickerHolder1").css('background-color','#' + hex);		
			jQuery("#background_color_picker_value").val(hex);	
		}
	});
	
	var color_val = jQuery("#body_color_picker_value").val();
	 jQuery('#colorpickerHolder2').ColorPicker({
		 	color:color_val,
			onChange: function (hsb, hex, rgb){
			jQuery("#colorpickerHolder2").css('background-color','#' + hex);		
			jQuery("#body_color_picker_value").val(hex);	
		}
	});
	});