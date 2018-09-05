(function($){
    $(window).load(function() {
        
        var moreParts;
        var base_url=location.protocol + '//' + location.host;
        var redirect_url=base_url+'/wp-login.php?action=logout';
        $('#wpadminbar').find('a').each(function() {
            var parts = $(this).attr('href').split('/');
            if(parts[(parts.length)-1]=="wp-login.php"){
                $(this).addClass("modal-login-loginClass");
            }
            if(parts[(parts.length)-1]=="wp-login.php?action=register"){
                $(this).addClass("modal-login-regClass");
            }
            if(parts[(parts.length)-1]=="wp-login.php?action=lostpassword"){
                $(this).addClass("modal-login-forgetClass");
            }
            moreParts = parts[(parts.length)-1].split("&");
            if(moreParts[0]=="wp-login.php?action=logout"){
                 $(this).addClass("modal-login-logOutClass");
            }
        });
        //getting the nonce
        var nonce="";
        for(var i=1;i<moreParts.length;i++){
            if(moreParts[i].indexOf('_wpnonce') > -1){
                nonce = moreParts[i];
            }
        }
        // creatign the real redirect url
        var new_redirect_url=base_url+'/wp-login.php?action=logout'+'&'+nonce;
        var terms = redirect_url.split("/");
        /*if(terms[2]=="plugina.localhost" || terms[2]=="localhost"){
            new_redirect_url=base_url+'/wp-login.php?action=logout'+'&'+nonce;
        }
        else{*/
            var n = redirect_url.indexOf('&_wpnonce=');
            redirect_url = redirect_url.substring(0, n != -1 ? n : redirect_url.length);
            /*if (redirect_url.indexOf("?") >= 0){
                new_redirect_url = redirect_url+'&'+nonce;
            }
            else{
               new_redirect_url = redirect_url+'?&'+nonce;
            }*/
        //}

        //$('.modal-login-logOutClass').attr('href',redirect_url);

        $(".modal-login-logOutClass").on("click",function(e){ 
            e.preventDefault();
            //$("#loaderModal").modal("show");
            var page = getUrlParameter('page');
            

            var search_params={
                 "action"  : "check_other"
             };
             jQuery.ajax({
                 url : 'admin-ajax.php',
                 dataType : "json",
                 type : "post",
                 data : search_params,
                 success: function(response){
                   if(page!="configureModalLogin"){
                        window.location.href = response.log_out_redirect_url;
                    }
                    else{
                        window.location.href = $("#log_out_redirect_url").val();
                    } 
                }
             });

            /*var search_params={
                 "action"  : "check_logout_modal"
             };
             jQuery.ajax({
                 url : base_url+'/wp-login.php?action=logout'+'&'+nonce,
                 dataType : "json",
                 type : "post",
                 /*data : search_params,*/
                /*complete: function(e, xhr, settings){
                    if(page!="configureModalLogin"){
                        window.location.href = redirect_url;
                    }
                    else{
                        window.location.href = $("#log_out_redirect_url").val();
                    }
                }
             });*/

        });

        var getUrlParameter = function getUrlParameter(sParam) {
            var sPageURL = decodeURIComponent(window.location.search.substring(1)),
                sURLVariables = sPageURL.split('&'),
                sParameterName,
                i;

            for (i = 0; i < sURLVariables.length; i++) {
                sParameterName = sURLVariables[i].split('=');

                if (sParameterName[0] === sParam) {
                    return sParameterName[1] === undefined ? true : sParameterName[1];
                }
            }
        };

        /*
        $(".modal-login-logOutClass").on("click",function(e){
            e.preventDefault();
            //$("#loaderModal").modal("show");
            

            var search_params={
                 "action"  : "check_logout_modal"
             };
             jQuery.ajax({
                 url : base_url+'/wp-login.php?action=logout'+'&'+nonce,
                 dataType : "json",
                 type : "post",
                 success : function(response){
                    console.log("ddd");
                     if(response.loggedout==false){
                        
                     }
                     if(response.loggedout==true){
                         //window.location.href = blog.options["log_out_redirect_url"];
                         window.location.href = "www.zeasite.com";
                     }                     

                 }
             });

        });
        */

    });
}(jQuery));