<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">


<style>
.input-icon3 {
  position: relative;
}
    .input-icon3 > i {
  color: #fff !important;
  display: block;
  position: absolute;
  margin: 0;
  z-index: 3;
  width: 50px;
  left: -49px;
  padding: 9px;
  background-color:rgba(0,0,0,.5);
  font-size: 16px;
  text-align: center;
}
    .input-icon3 > .form-control {
  
       
       
            border-radius:0 !important
}
    
    div.checker {
  display:inline-block; margin-right:10px; vertical-align:text-bottom
}
     #tmp3 .forget-password, #tmp3 .reg, #regtmp3 .emailText, #forgettmp3 .forgetMessageEmail{font-size:14px}
    #tmp3 .loginbtn, #regtmp3 .regbutton, #forgettmp3 .new_pass{font-size:15px}
 #tmp3 .loginbtn, #regtmp3 .regbutton {padding: 30px 20px ; border-radius:0 !important; width:100%}   
  #forgettmp3 .new_pass{ border-radius:0; width:100%}  
</style>
<div class="modal fade modal-template-login c-logtmp3 in" id="tmp3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="template-image template-image-hide">


                </div>
                <h3 class="modal-title">Modal title</h3>
            </div>
            <div class="modal-body">
                <div id="modal-alert"></div>
                <div class="row"><div class="col-sm-12">
                <div style="float:left;width:69%; margin-left:15px"><div style="padding-left:33px">
                <div class="form-group">
                    <div class="input-icon3">
                        <i class="fa fa-user fa-2x"></i> <input type="text" class="form-control form-control-solid placeholder-no-fix" id="user_login" name="log" placeholder="User Name" required> </div>
                </div>
                <div class="form-group"><div class="input-icon3">
                        <i class="fa fa-lock fa-2x"></i> 
                    <input type="password" name="pwd" id="user_pass" placeholder="Password" class="form-control form-control-solid placeholder-no-fix" value="" size="20" class="" placeholder="Password" required> </div>               
                </div>
                    
                </div></div>
                
                <div style="float:right; width:25%;" align="right"><button type="button" class="btn loginbtn uppercase">Login</button></div>
                </div> </div> 
                    
                    <div><div class="row">
                  <div class="col-sm-6">
                 
                    <div class="chkbox-wrap-2">
                    <div class="checker">
                    <input type="checkbox" name="rememberme" value="" id="remember"></div>
                    </div>
                    <div class="r-memb-r"><label class="rememberme check">Remember</label></div> 
</div>
<div align="center" class="g-recaptcha col-sm-12 captchaDiv" data-sitekey="" id="temp3captcha"></div>
                   
                </div>
            </div></div>
            <div class="modal-footer">    
                
                <div class="col-sm-6 zeropad" align="left"><a href="javascript:;" id="forget-password" class="forget-password">Forgot Password?</a></div>
                <div class="col-sm-6 zeropad pull-right-lg"><a href="javascript:;" id="register-text" class="reg">Create an account</a></div>
                
                
                
            </div>
        </div>
    </div>  
</div>
