<div class="modal-template-forget c-forgettmp3 fade in modal" id="forgettmp3" tabindex="-1" role="dialog" aria-labelledby="myModalForgetLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="template-image template-image-hide">


                </div>
                <h3 class="modal-title">Forget Password!</h3>
            </div>
            <div class="modal-body">
                <div id="modal-alert-forget" class="alert alert-danger"></div><div class="row"><div class="col-sm-12">
                        <div class="txtpart"><div style="padding-left:33px">
                                <div class="form-group">
                                    <div class="input-icon3">
                                        <i class="fa fa-envelope fa-2x"></i> <input type="text" name="forget_email" id="forget_email" placeholder="email" class="form-control form-control-solid placeholder-no-fix" value="" size="20" class="" placeholder="email or username" required></div>
                                </div></div> </div>
                        <div class="btnpart" align="right"><div class="form-actions text-center">
                                <button type="button" class="btn btn-success uppercase new_pass" id="getPassword">Get new password</button>
                            </div></div></div></div>
                             <div class="form-group captchadivforgot marginbottom0">
                        <div align="center" class="g-recaptcha" data-sitekey="" id="forgot3captcha"></div>
                    </div> 

            </div>
            <div class="modal-footer">
                <div class="forgetMessageEmail" align="center">
                    Password change instruction will be e-mailed to you.
                </div>
            </div>
        </div>
    </div>
</div>
<style type="text/css">
    
    .txtpart{float:left;width:60%; margin-left:15px}
    .btnpart{float:right; width:35%;}

    @media screen and (max-width: 782px){
        .txtpart{float:none; width: -moz-calc(100% - 18px);
    width: -webkit-calc(100% - 18px);
    width: calc(100% - 18px); }
    .btnpart{float:none; width:100%;}
    }
</style>