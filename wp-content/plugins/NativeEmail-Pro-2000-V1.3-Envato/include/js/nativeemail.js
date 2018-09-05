/* jquery code to handle front ui effects */
/** include file**/

	jQuery(document).ready(function(e) {
		
		var thankyouforupdate = 'You have successfully updated your subscription.';
		var thankyoumessage = 	"Thank you for subscribing"
		
		
		jQuery('.native_categorylist li input').click(function(event) {  //on click 
		
		if(jQuery(this).parent("li").find("li.children").hasClass("children")){
				if(jQuery(this).is(":checked")){				///		
						//alert(jQuery(this).parent("li").html());
						jQuery(this).parent("li").find("li input").each(function(){ // check select status
								jQuery(this).attr("checked" , "checked");
							});
				}
			else{
					jQuery(this).parent("li").find("li input").each(function(){ // check select status
							jQuery(this).removeAttr("checked");
						});
				}					
			};
		});
		
		jQuery("body").find(".widget-email-alert-form").submit(function(){
		
			var dhis  = jQuery(this);
			var useremail = jQuery(this).find(".emailaertpro_mail").val();
			
			if(useremail == '')
				{
					jQuery(this).find(".emailaertpro_error_message").html('<span style="color:red;">Please Enter Your Email</span>');
					return false;
					}
			var x 		= 	useremail;
			var atpos	=	x.indexOf("@");
			var dotpos	=	x.lastIndexOf(".");
			if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
  			{
  				jQuery(this).find(".emailaertpro_error_message").html("Please Enter Valid Email Address");
  				return false;
  			}
			
			var  homeurl	 = jQuery(".website_url").val();
			var ajaxurl 	 = homeurl+'/wp-admin/admin-ajax.php';
			var taxonomy	 = jQuery(this).find(".selected_category_for_db").val();
			var subscribe_form	 = jQuery(this).find(".subscribe_form").val();
			var post_type	 = jQuery(this).find(".selected_post_for_db").val();
			var selected_cats = [];
			jQuery(this).find(':checkbox:checked').each(function(i){
							selected_cats[i] = jQuery(this).val();
					});
		jQuery.ajax({
        type: 'post',
        url: ajaxurl,
        data: { 
			action: "handle_email_subscription",
			'useremail':useremail , 
			'selected_cats': selected_cats ,
			'taxonomy':taxonomy , 
			'post_type':post_type,
			'subscribe_form':subscribe_form		
		},
        success:function(response){
				response = jQuery.parseJSON(response);
				if(response.status == 'pro'){
					dhis.find(".emailaertpro_error_message").html(response.message);
					return false;
				}
				if(response.user_type == 'new' || response.user_type == 'old')
				{
					dhis.find(".emailaertpro_mail").val('');
					if(	response.user_type == 'old'){
							dhis.find("#email_message").html(thankyouforupdate);
						}
					else{
						dhis.find("#email_message").html(thankyoumessage);
						}
						dhis.find(".widget_area_email").hide();
					if (typeof modal !== 'undefined' && jQuery.isFunction(modal)){ /*	jQuery('#myModal').modal('hide')*/ }
					}
				}
			});
		return false;	
	    });
		
		jQuery(".select-all").click(function(){
			
			var selectall = 'Select all';
			var unselectall = 'Unselect';
						if(jQuery(this).html() == selectall){
							jQuery(this).parent("div").find("input").each(function(i ,v){
							//console.log(this);
							console.log(this);
										this.checked = true;  //select all checkboxes with class "checkbox1"
							});
							jQuery(this).html(unselectall)
						}else if(jQuery(this).html() == unselectall){
						
							jQuery(this).parent("div").find("input").each(function(i ,v){
										this.checked = false;  //select all checkboxes with class "checkbox1"
							});
							jQuery(this).html(selectall)
						}
						
					});
	
	});
	
	//jQuery('#myModal').on('shown.bs.modal', function () { jQuery('#subscription_email').focus(); });
	jQuery('#myModal').bind('shown.bs.modal', function () { jQuery('#subscription_email').focus(); });
