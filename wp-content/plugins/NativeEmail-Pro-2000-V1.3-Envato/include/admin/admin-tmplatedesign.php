<?php
global $native_settings;

if (isset($_POST['submit']) && $_POST['submit'] != '') {


    /*
      if(isset($_FILES['file']['name']) && $_FILES['file']['name'] !=''){
      $admin_settings->email_add_header_image($_FILES['file']);
      }
     */

    if (isset($_POST) && !empty($_POST)) {
        foreach ($_POST as $meta_key => $meta_value):
            $native_settings->set($meta_key, $meta_value);
        endforeach;
    }
    echo "<script type='text/javascript'>
						jQuery(document).ready(function(){
								jQuery('#myModal').modal('show');
						});
					</script>";
}


$font = $native_settings->get('emailalertpro_template_font_family_name');

$emailalertpro_template_phone_section = stripslashes($native_settings->get('emailalertpro_template_phone_section'));
$emailalertpro_template_email_subject = stripslashes($native_settings->get('emailalertpro_template_email_subject'));
$emailalertpro_template_header_title = stripslashes($native_settings->get('emailalertpro_template_header_title'));
$emailalertpro_template_header_section = stripslashes($native_settings->get('emailalertpro_template_header_section'));
$email_alert_home_link = stripslashes($native_settings->get('email_alert_home_link'));
$email_alert_contact_link = $native_settings->get('email_alert_contact_link');
$emailalertpro_colorpicker_color_change = $native_settings->get('emailalertpro_colorpicker_color_change');
$emailalertpro_colorpicker_body_color = $native_settings->get('emailalertpro_colorpicker_body_color');
$emailalertpro_colorpicker_background_color = $native_settings->get('emailalertpro_colorpicker_background_color');


$emailalertpro_template_readmore = stripslashes($native_settings->get('emailalertpro_template_readmore'));
$emailalertpro_template_portfolio_text_box = stripslashes($native_settings->get('emailalertpro_template_portfolio_text_box'));
$emailalertpro_template_portfolio_link_box = stripslashes($native_settings->get('emailalertpro_template_portfolio_link_box'));
$emailalertpro_template_footer_section = stripslashes($native_settings->get('emailalertpro_template_footer_section'));
$emailalertpro_template_excerpt_length = stripslashes($native_settings->get('emailalertpro_template_excerpt_length'));
$emailalertpro_template_text_length = stripslashes($native_settings->get('emailalertpro_template_text_length'));

$emailalertpro_template_font_size = stripslashes($native_settings->get('emailalertpro_template_font_size'));
$emailalertpro_template_hfont_size = stripslashes($native_settings->get('emailalertpro_template_hfont_size'));
$emailalertpro_template_text_spacing = stripslashes($native_settings->get('emailalertpro_template_text_spacing'));
?>

<div class="container1">
    <form action="" method="post" name="templates" enctype="multipart/form-data">
        <div class="row-app">
            <div class="col-separator-first box"> 

                <!-- // END navbar -->

                <div class="preheading widget">
                    <div class="row col-separator col-separator-first box">
                        <div class="col-lg-3"><!--<h2>Content Control</h2>---></div>
                        <div class="col-lg-6">
                            <span class="text-left bg-title h1"></span>	 
                        </div>
                        <div class="col-lg-3">
                            <input type="submit" class="button-primary1 emailprobutton pull-right btn btn-primary btn-sm strong" name="submit" value="Save" />
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <div class="template_settings_panel innerLR1">
                    <div class="layout-app">
                        <div class="row-app">
                            <div class="row">
                                <div class="">
                                    <div class="col-lg-4">
                                        <div class="lefttemplate template_cover">
                                            <div class="font_setting partion form-group">
                                                <div class="panel-heading"> Font settings
                                                    <div class="down" style="float:right" alt="font_setting">Collapse</div>
                                                </div>
                                                <div class="all_cover">
                                                    <div class="new_post">
                                                        <div class="template_item">
                                                            <label>Select font</label>
                                                            <div class="col-md-7">
                                                                <select name='emailalertpro_template_font_family_name' id="select2_1">
                                                                    <option style="font-family: 'Comic Sans MS'" value="Comic Sans MS" <?php print ($font == 'Comic Sans MS') ? 'selected="selected"' : ''; ?>>Comic Sans MS</option>
                                                                    <option style="font-family: 'Georgia, serif'" value="Georgia, serif" <?php print ($font == 'Georgia, serif') ? 'selected="selected"' : ''; ?>>Georgia, serif</option>
                                                                    <option style="font-family:'Arial'" value="Arial" <?php print ($font == 'Arial') ? 'selected="selected"' : ''; ?>>Arial</option>
                                                                    <option style="font-family:'Tahoma, Geneva, sans-serif'" value="Tahoma, Geneva, sans-serif" <?php print ($font == 'Tahoma, Geneva, sans-serif') ? 'selected="selected"' : ''; ?>>Tahoma, Geneva, sans-serif</option>
                                                                    <option style="font-family:'Verdana, Geneva, sans-serif'" value="Verdana, Geneva, sans-serif" <?php print ($font == 'Verdana, Geneva, sans-serif') ? 'selected="selected"' : ''; ?>>Verdana, Geneva, sans-serif</option>
                                                                    <option style="font-family:'Arial, Helvetica, sans-serif'" value="Arial, Helvetica, sans-serif" <?php print ($font == 'Arial, Helvetica, sans-serif') ? 'selected="selected"' : ''; ?>>Arial, Helvetica, sans-serif</option>
                                                                    <option style="font-family:'Impact, Charcoal, sans-serif'" value="Impact, Charcoal, sans-serif" <?php print ($font == 'Impact, Charcoal, sans-serif') ? 'selected="selected"' : ''; ?>>Impact, Charcoal, sans-serif</option>
                                                                    <option style="font-family: 'Times New Roman'" value="Times New Roman" <?php print ($font == 'Times New Roman') ? 'selected="selected"' : ''; ?>> Times New Roman</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="template_item">
                                                            <label>Header font size</label>
                                                            <div class="col-md-7">
                                                                <select name="emailalertpro_template_hfont_size">
                                                                    <?php
                                                                    for ($i = 1; $i <= 30; $i++) {
                                  $selected = ( $i == $emailalertpro_template_hfont_size ) ? "selected='selected'" : '';
									print '<option value="' . $i . '" ' . $selected . '>';
									print $i . ' <label>PX</label>';
									print '</option>';
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="template_item">
                                                            <label>Text font size</label>
                                                            <div class="col-md-7">
                                                                <select name="emailalertpro_template_font_size">
                                                                    <?php
                                                                    for ($i = 1; $i <= 30; $i++) {
                                                                        $selected = ($i == $emailalertpro_template_font_size ) ? "selected='selected'" : '';
                                                                        print '<option value="' . $i . '" ' . $selected . '>';
                                                                        print $i . ' <label>PX</label>';
                                                                        print '</option>';
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="template_item">
                                                            <label>Font spacing</label>
                                                            <div class="col-md-7">
                                                                <select name="emailalertpro_template_text_spacing">
                                                                    <?php
                                                                    for ($i = 1; $i <= 30; $i++) {
                                                                        $selected = ($i == $emailalertpro_template_text_spacing ) ? "selected='selected'" : '';
                                                                        print '<option value="' . $i . '" ' . $selected . '>';
                                                                        print $i . ' <label>PX</label>';
                                                                        print '</option>';
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>



                                            <div class="head_part partion form-group">
                                                <div class="panel-heading"> Header settings
                                                    <div class="down" style="float:right" alt="head_part">Collapse</div>
                                                </div>
                                                <div class="template_item" >
                                                    <label for="noc" style=""> Logo upload</label>
                                                    <div class="logosection">

                                                        <div class="file">
                                                            <div class="upload button pull-left fileinput-button col-md-7">
                                                                <!----
                                                                Upload logo
                                <input type="file" name="file" id="upload-logo-file"/>
                                                                --->
                                                                        <!---<i class="glyphicon glyphicon-plus"></i>--->
                                                                Upload logo
                                                                <!-- The file input field used as target for the file upload widget -->
                                                                <input id="upload-logo-file" type="file" name="file">
                                                            </div>

                                                            <div class="row col-md-12" style="margin-top: 10px">(Max width 200 px)</div>
                                                        </div>
                                                        <div class="log">
                                                            <?php if ($admin_settings->email_get_header_image()) { ?>
                                                                <img src="<?php echo $admin_settings->email_get_header_image(); ?>"  alt="Native Email"  id="template-logo-perview"/>
                                                            <?php } ?>
                                                        </div>

                                                        <!-- The global progress bar -->
                                                        <div id="progress" class="progress" style="width: 100%; background: rgb(255, 255, 255) none repeat scroll 0% 0%; margin-bottom: 0px; position: relative; float: left; margin-top: 10px;">
                                                            <div class="progress-bar progress-bar-success"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="template_item">
                                                    <label>Additional header text</label>
                                                    <input type="text" name="emailalertpro_template_phone_section" value="<?php echo$emailalertpro_template_phone_section; ?>">
                                                </div>
                                                <div class="template_item">
                                                    <label>Subject for email</label>
                                                    <input type="text"   name="emailalertpro_template_email_subject" value="<?php print $emailalertpro_template_email_subject; ?>" />
                                                </div>
                                                <div class="template_item">
                                                    <label>Title</label>
                                                    <input type="text"   name="emailalertpro_template_header_title" value="<?php print $emailalertpro_template_header_title; ?>" />
                                                </div>
                                                <div class="template_item">
                                                    <label>Heading  text</label>
                                                    <textarea  cols="40" rows="5"  name="emailalertpro_template_header_section"><?php print $emailalertpro_template_header_section; ?>
                                                    </textarea>
                                                </div>
                                                <?php ?>
                                                <?php if ($email_alert_home_link == '') $email_alert_home_link = site_url(); //get_bloginfo('site_url');?>
                                                <div class="template_item">
                                                    <label>Home link</label>
                                                    <input type="text" name="email_alert_home_link" value="<?php echo $email_alert_home_link; ?>"/>
                                                </div>
                                                <div class="template_item">
                                                    <label>Contact link</label>
                                                    <input type="text" name="email_alert_contact_link" value="<?php echo $email_alert_contact_link; ?>"/>
                                                </div>
                                            </div>
                                            <!-- head part-->
                                            <div class="color_settings partion form-group">
                                                <div class="panel-heading"> Colour settings
                                                    <div class="down" style="float:right" alt="color_settings">Collapse</div>
                                                </div>
                                                <div class="template_item">
                                                    <label>Header/ footer colour</label>
                                                    <div id="colorpickerHolder" class="colorselec" style="background-color:#<?php print $emailalertpro_colorpicker_color_change; ?>"></div>
                                                    <input type="hidden"  value="<?php print $emailalertpro_colorpicker_color_change; ?>" name="emailalertpro_colorpicker_color_change" id="color_picker_value" />
                                                </div>
                                                <div class="template_item">
                                                    <label>Background colour</label>
                                                    <div id="colorpickerHolder1" class="colorselec" style="background-color:#<?php print $emailalertpro_colorpicker_background_color; ?>"></div>
                                                    <input type="hidden"  value="<?php print $emailalertpro_colorpicker_background_color; ?>" name="emailalertpro_colorpicker_background_color" id="background_color_picker_value" />
                                                </div>
                                                <div class="template_item">
                                                    <label>Email body colour</label>
                                                    <div id="colorpickerHolder2" class="colorselec" style="background-color:#<?php print $emailalertpro_colorpicker_body_color; ?>"></div>
                                                    <input type="hidden"  value="<?php print $emailalertpro_colorpicker_body_color; ?>" name="emailalertpro_colorpicker_body_color" id="body_color_picker_value" />
                                                </div>
                                            </div>
                                            <!---color settings---->
                                            <div class="body_content partion form-group">
                                                <div class="panel-heading"> Content settings
                                                    <div class="down" style="float:right" alt="body_content">Collapse</div>
                                                </div>

                                                <div class="template_item">
                                                    <label>Post title text length</label>
                                                    <input type="text"   name="emailalertpro_template_text_length" value="<?php print $emailalertpro_template_text_length; ?>" />
                                                </div>
                                                <div class="template_item">
                                                    <label>Post excerpt text length</label>
                                                    <input type="text"   name="emailalertpro_template_excerpt_length" value="<?php print $emailalertpro_template_excerpt_length; ?>" />
                                                </div>
                                                <div class="template_item">
                                                    <label> Read more button text</label>
                                                    <input type="text"   name="emailalertpro_template_readmore" value="<?php print $emailalertpro_template_readmore; ?>" />
                                                </div>
                                                <div class="template_item">
                                                    <label>Potfolio box text</label>
                                                    <input type="text" name="emailalertpro_template_portfolio_text_box" value="<?php print $emailalertpro_template_portfolio_text_box; ?>" />
                                                </div>
                                                <div class="template_item">
                                                    <label>Portfolio link</label>
                                                    <input type="text" name="emailalertpro_template_portfolio_link_box" value="<?php print $emailalertpro_template_portfolio_link_box; ?>" />
                                                </div>
                                            </div>
                                            <div class="form-group footer partion">
                                                <div class="panel-heading"> Footer settings
                                                    <div class="down" style="float:right" alt="footer">Collapse</div>
                                                </div>
                                                <div class="template_item">
                                                    <label>Footer text</label>
                                                    <textarea  cols="40" rows="5"  name="emailalertpro_template_footer_section"><?php print $emailalertpro_template_footer_section; ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="selected_template " style="">
                                            <?php $link = admin_url('admin-ajax.php?action=get_email_perview'); ?>
                                            <div class="box-generic"> 

                                                <!-- Slim Scroll -->
                                                <div class="slim-scroll" data-scroll-height="255px">
                                                    <iframe src="<?php echo $link; ?>" width="100%" height="1600px"> </iframe>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>



<script type="text/javascript">
    /*jslint unparam: true */
    /*global window, $ */
    jQuery(function () {
		//'use strict';
		jQuery('#upload-logo-file').fileupload({
			url: '<?php echo admin_url('admin-ajax.php?action=template_logo'); ?>',
			dataType: 'json',
			change: function (e, data) {
				jQuery('#progress .progress-bar').html();
				jQuery('#progress .progress-bar').css('width','0%');
		 },
		  done: function (e, data) {
			
			if (data.result.status) {
				jQuery("#template-logo-perview").attr("src", data.result.response);
				jQuery('#progress .progress-bar').html('Uploaded');
			}
			else {
				console.log(data.result.response);
			}

		//console.log();
		//jQuery.each(data.result.files, function (index, file) {
		//jQuery('<p/>').text(file.name).appendTo('#files');
		//});
		},
		progressall: function (e, data) {
				var progress = parseInt(data.loaded / data.total * 100, 10);
				jQuery('#progress .progress-bar').css(
						'width',
						progress + '%'
						);
				jQuery('#progress .progress-bar').html(progress + '% Uploading...');
		}
		}).prop('disabled', !jQuery.support.fileInput).parent().addClass(jQuery.support.fileInput ? undefined : 'disabled');
    });
</script>