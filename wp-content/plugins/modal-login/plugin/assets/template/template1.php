<?php //KBS ?>
<div class="modal fade modal-template-login c-logtmp1 in" id="tmp1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between">


                <div class="col-10">
                <h3 class="modal-title text-left">Modal title</h3>
                    </div>
                            <div class="col-2">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
            </div>
            <div class="modal-body">
                <div id="modal-alert"></div>
                <div class="form-group">
                    <input type="text" class="form-control form-control-solid placeholder-no-fix" id="user_login" name="log" placeholder="Identifiant" required> 
                </div>
                <div class="form-group">
                    <input type="password" name="pwd" id="user_pass" placeholder="Mot de passe" class="form-control form-control-solid placeholder-no-fix" value="" size="20" class="" placeholder="Mot de passe" required>                
                </div>
                <div class="form-group nomarginbottom">
                    <div class="row">
                        <div class="col-12 marginbottom15 captchaDiv">
                            <div align="center" class="g-recaptcha" data-sitekey="" id="temp1captcha">
                            </div>
                        </div>                    
                        <div class="col-sm-8">
                        <div class="row d-flex justify-content-between">
                            <div class="col-sm-6"><button type="button" class="btn loginbtn uppercase">Login</button></div>
                            <div class="col-sm-6">
                            <div class="">
                                <div class="">
                                  <div class="checkbox">
                                    <label>
                                      <input type="checkbox"  name="rememberme" value="" id="remember"> Se souvenir de moi
                                    </label>
                                  </div>
                                </div>
                            </div>
                        </div></div></div>
                        <div class="col-sm-4 padzero pull-right-lg">
                            <a href="javascript:;" id="forget-password" class="forget-password">Forgot Password?
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">                  
                <a href="/demande-adhesion/" id="adherer" class="reg">Adhérer</a>
            </div>
        </div>
    </div>  
</div>