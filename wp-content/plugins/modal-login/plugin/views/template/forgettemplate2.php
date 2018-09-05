
<div class="modal-template-forget c-forgettmp2" id="forgettmp2">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="template-image template-image-hide">


                </div>
                <h3 class="modal-title"  align="center">Forget Password!</h3>
            </div>
            <div class="modal-body paddingbottom1">
                <div id="modal-alert-forget" class="alert alert-danger"></div>
                <div class="form-group">
                    <div class="input-icon">
                        <i class="fa fa-envelope fa-2x"></i> <input type="text" name="forget_email" id="forget_email" placeholder="email" class="form-control form-control-solid placeholder-no-fix" value="" size="20" class="" placeholder="email or username" required></div>
                </div>
                
                 <div class="form-group captchadivforgot marginbottom15">
                    <div align="center" class="g-recaptcha" data-sitekey="" id="forgot1captcha"></div>
                </div>     
            </div>     
             <div class="modal-footer">   
              <div class="form-actions text-center">
                    <button type="button" class="btn btn-success uppercase new_pass" id="getPassword">Get new password</button>
                </div>
             <div class="forgetMessageEmail">
                    Password change instruction will be e-mailed to you.
                </div>               
               
            </div>      
        </div>
    </div>  
</div>