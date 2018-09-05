<div class="modal-template-registration c-regtmp2 fade in modal" id="regtmp2" tabindex="-1" role="dialog" aria-labelledby="myModalForgetLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="template-image template-image-hide">


                </div>
                <h3 class="modal-title text-center">Register title</h3>
            </div>
            <div class="modal-body paddingbottom1">
                <div id="modal-alert-reg" class="alert alert-danger"></div>
                <div class="form-group">
                    <div class="input-icon">
                        <i class="fa fa-user fa-2x"></i> <input type="text" class="form-control form-control-solid placeholder-no-fix" id="reg_user" name="reg_user" placeholder="User Name" required> </div>
                </div>
                <div class="form-group">
                   <div class="input-icon">
                       <i class="fa fa-envelope fa-2x"></i>  <input type="text" name="reg_email" id="reg_email" placeholder="Email" class="form-control form-control-solid placeholder-no-fix" value="" size="20" class=""  required></div>
                </div> 
                <div class="form-group marginbottom15 captchadivreg">
                    <div align="center" class="g-recaptcha" data-sitekey="" id="register2captcha"></div>
                </div>                 
            </div>
            <div class="modal-footer">                  
                <div class="form-actions text-center">
                    <button type="button" class="btn btn-success uppercase regbutton reg">Register</button>
                </div>
                <div class="text-center ">
                    <span class="emailText"> A password will be e-mailed to you.</span>
                </div>
            </div>
        </div>
    </div>  
</div>