<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

<style>
.input-icon {
  position: relative;
}
    .input-icon > i {
  color: #ccc;
  display: block;
  position: absolute;
  margin: 11px 2px 4px 10px;
  z-index: 3;
  width: 16px;
  font-size: 16px;
  text-align: center;
}
    .input-icon > .form-control {
  padding-left: 33px !important;
}
    
    div.checker {
  display:inline-block; margin-right:10px; vertical-align:text-bottom
}
</style>
<script src="//www.google.com/recaptcha/api.js?onload=CaptchaCallback&render=explicit" async defer></script>
<div class="modal fade modal-template-login c-logtmp2 in" id="tmp2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="template-image template-image-hide">


                </div>
                <h3 class="modal-title" align="center">Modal title</h3>
            </div>
            <div class="modal-body marginbottom0 paddingbottom1">
                <div id="modal-alert"></div>
                <div class="form-group">
                    <div class="input-icon">
                        <i class="fa fa-user fa-2x"></i> <input type="text" class="form-control form-control-solid placeholder-no-fix" id="user_login" name="log" placeholder="User Name" required> </div>
                </div>
                <div class="form-group"><div class="input-icon">
                        <i class="fa fa-lock fa-2x"></i> 
                    <input type="password" name="pwd" id="user_pass" placeholder="Password" class="form-control form-control-solid placeholder-no-fix" value="" size="20" class="" placeholder="Password" required> </div>               
                </div>
                 <div class="form-group"><div class="row">
                 <div class="col-sm-12 marginbottom15 captchaDiv">
                            <div align="center" class="g-recaptcha" data-sitekey="" id="temp2captcha">
                            </div>
                        </div>     
                    <div class="col-sm-6">
                 
                    <div class="chkbox-wrap-2">
                    <div class="checker">
                    <input type="checkbox" name="rememberme" value="" id="remember"></div>
                    </div>
                    <div class="r-memb-r"><label class="rememberme check">Remember</label></div> 
</div>
                    <div class="col-sm-6" align="right"><button type="button" class="btn loginbtn uppercase">Login</button></div>
                    
                    </div>
                </div>
               
            </div>
            <div class="modal-footer">    
                <div class="col-sm-6" align="left"><a href="javascript:;" id="forget-password" class="forget-password">Forgot Password?</a></div>
                
                <div class="col-sm-6 pull-right-lg"><a href="javascript:;" id="register-text" class="reg">Create an account</a></div>
                
                
                
            </div>
        </div>
    </div>  
</div>


