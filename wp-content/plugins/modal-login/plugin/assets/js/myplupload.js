jQuery.fn.exists = function() {  
    return jQuery(this).length > 0;
};
jQuery(document).ready(function($) {

    if ($(".plupload-upload-uic").exists()) {
        var pconfig = false;
        $(".plupload-upload-uic").each(function() {
            var $this = $(this);
            var id1 = $this.attr("id");            
            var imgId = id1.replace("plupload-upload-ui", "");
            plu_show_thumbs(imgId);
            base_plupload_config=JSON.stringify(basedata.plupload_init);
            
            base_plupload_config = base_plupload_config.replace(new RegExp("&quot;", 'g'), '"');
            
            pconfig = JSON.parse(JSON.stringify(base_plupload_config));
            //console.log($.parseJSON(pconfig))
            pconfig=$.parseJSON(pconfig);
            //console.log(pconfig["multipart_params"])
 
            pconfig["browse_button"] = imgId + pconfig["browse_button"];
            pconfig["container"] = imgId + pconfig["container"];
            pconfig["drop_element"] = imgId + pconfig["drop_element"];
            pconfig["file_data_name"] = imgId + pconfig["file_data_name"];
            pconfig["multipart_params"]["imgid"] = imgId;
            pconfig["multipart_params"]["_ajax_nonce"] = $this.find(".ajaxnonceplu").attr("id").replace("ajaxnonceplu", "");
 
            if ($this.hasClass("plupload-upload-uic-multiple")) {
                pconfig["multi_selection"] = true;
            }
 
            if ($this.find(".plupload-resize").exists()) {
                var w = parseInt($this.find(".plupload-width").attr("id").replace("plupload-width", ""));
                var h = parseInt($this.find(".plupload-height").attr("id").replace("plupload-height", ""));
                pconfig["resize"] = {
                    width: w,
                    height: h,
                    quality: 90
                };
            }
 
            var uploader = new plupload.Uploader(pconfig);
 
            uploader.bind('Init', function(up) {
 
            });
 
            uploader.init();
 
            // a file was added in the queue
            uploader.bind('FilesAdded', function(up, files) {
                $.each(files, function(i, file) {
                    $this.find('.filelist').append('<div class="file" id="' + file.id + '"><b>' +
 
                    file.name + '</b> (<span>' + plupload.formatSize(0) + '</span>/' + plupload.formatSize(file.size) + ') ' + '<div class="fileprogress"></div></div>');
                });
 
                up.refresh();
                up.start();
            });
 
            uploader.bind('UploadProgress', function(up, file) {
 
                $('#' + file.id + " .fileprogress").width(file.percent + "%");
                $('#' + file.id + " span").html(plupload.formatSize(parseInt(file.size * file.percent / 100)));
            });
 
            // a file was uploaded
            uploader.bind('FileUploaded', function(up, file, response) {


                $('#' + file.id).fadeOut();
                response = response["response"];
                // add url to the hidden field
                if ($this.hasClass("plupload-upload-uic-multiple")) {
                    // multiple
                    var v1 = $.trim($("#" + imgId).val());
                    if (v1) {
                        v1 = v1 + "," + response;
                    } else {
                        v1 = response;
                    }
                    $("#" + imgId).val(v1);
                } else {
                    // single
                    $("#" + imgId).val(response + "");
                }
                // show thumbs

                plu_show_thumbs(imgId);
                if (imgId != "img110"){
                    image_change(imgId);
                }
            });
        });
    }
});
// load image to the template
var image_change = function(img_id){
    var $ = jQuery;
    $("#makeItRound").attr('checked', false);
    $("#templateToShow").find(".template-image").removeClass('template-image-round');
    $("#registerToShow").find(".template-image").removeClass('template-image-round');
    $("#forgetToShow").find(".template-image").removeClass('template-image-round');
    if(img_id!="remove") {
        $(".roundImgDiv").show();
        $("#templateToShow").find(".template-image").addClass('template-image-show');
        $("#templateToShow").find(".template-image").removeClass('template-image-hide');
        $("#templateToShow").find(".template-image").addClass('template-image-square');
        $("#registerToShow").find(".template-image").addClass('template-image-show');
        $("#registerToShow").find(".template-image").removeClass('template-image-hide');
        $("#registerToShow").find(".template-image").addClass('template-image-square');
        $("#forgetToShow").find(".template-image").addClass('template-image-show');
        $("#forgetToShow").find(".template-image").removeClass('template-image-hide');
        $("#forgetToShow").find(".template-image").addClass('template-image-square');
        var src = $(".img_path").val();
        //$("#templateToShow").find("img").attr("src", src);
        $("#templateToShow").find(".template-image").attr("style", "background:url("+src+") no-repeat");
        $("#registerToShow").find(".template-image").attr("style", "background:url("+src+") no-repeat");
        $("#forgetToShow").find(".template-image").attr("style", "background:url("+src+") no-repeat");
        $(".img-option").show();
        $(".roundImgDiv").show();
        $("input[name=makeItRound]").bootstrapSwitch('state',false);
    }
    else{
        $(".roundImgDiv").hide();
        $("#templateToShow").find(".template-image").addClass('template-image-hide');
        $("#templateToShow").find(".template-image").removeClass('template-image-show');
        $("#registerToShow").find(".template-image").addClass('template-image-hide');
        $("#registerToShow").find(".template-image").removeClass('template-image-show');
        $("#forgetToShow").find(".template-image").addClass('template-image-hide');
        $("#forgetToShow").find(".template-image").removeClass('template-image-show');
        $(".roundImgDiv").hide();
        $(".img-option").hide();
        $('#makeItRound').prop('checked', false);
        //$("input[name=makeItRound]").bootstrapSwitch('state',false);
    }
};
function plu_show_thumbs(imgId) {
    var $ = jQuery;

    if (imgId == "img1"){
        var thumbsC = $("#" + imgId + "plupload-thumbs");
        thumbsC.html("");
        // get urls
        var imagesS = $("#" + imgId).val();
        var images = imagesS.split(",");

        for (var i = 0; i < images.length; i++) {
            if (images[i]) {
                var thumb = $('<div class="thumb" id="thumb' + imgId + i + '"><img src="' + images[i] + '" alt="" /><div class="thumbi"><a id="thumbremovelink' + imgId + i + '" href="#" rel="header" class="remove">Remove</a></div> <div class="clear"></div></div>');
                thumbsC.append(thumb);
                $(".img_path").val(images[i]);
                $(".default-img").hide();
                thumb.find("a").on("click", function () {
                    var ki = $(this).attr("id").replace("thumbremovelink" + imgId, "");
                    ki = parseInt(ki);
                    var kimages = [];
                    imagesS = $("#" + imgId).val();
                    images = imagesS.split(",");
                    for (var j = 0; j < images.length; j++) {
                        if (j != ki) {
                            kimages[kimages.length] = images[j];
                        }
                    }
                    $("#" + imgId).val(kimages.join());
                    plu_show_thumbs(imgId);
                    checkDefaultImg();
                    image_change("remove");
                    return false;
                });
            }
        }
        if (images.length > 1) {
            thumbsC.sortable({
                update: function(event, ui) {
                    var kimages = [];
                    thumbsC.find("img").each(function() {
                        kimages[kimages.length] = $(this).attr("src");
                        $("#" + imgId).val(kimages.join());
                        plu_show_thumbs(imgId);
                    });
                }
            });
            thumbsC.disableSelection();
        }
    }
    else{
        var thumbsC = $("#" + imgId + "plupload-thumbs");
        thumbsC.html("");
        // get urls
        var imagesS = $("#" + imgId).val();
        var images = imagesS.split(",");

        for (var i = 0; i < images.length; i++) {
            if (images[i]) {
                var thumb = $('<div class="thumb10" id="thumb' + imgId + i + '"><img src="' + images[i] + '" alt="" /><div class="thumbi"><a id="thumbremovelink' + imgId + i + '" href="javascript:;" class="remove" rel="bgimage">Remove</a></div> <div class="clear"></div></div>');
                thumbsC.append(thumb);
                $(".img_path_bg").val(images[i]);
                //$(".default-img").hide();
                thumb.find("a").on("click", function () {
                    var ki = $(this).attr("id").replace("thumbremovelink" + imgId, "");
                    ki = parseInt(ki);
                    var kimages = [];
                    imagesS = $("#" + imgId).val();
                    images = imagesS.split(",");
                    for (var j = 0; j < images.length; j++) {
                        if (j != ki) {
                            kimages[kimages.length] = images[j];
                        }
                    }
                    $("#" + imgId).val(kimages.join());
                    plu_show_thumbs(imgId);
                    //checkDefaultImg()
                    //image_change("remove")
                    $(".img_path_bg").val("");
                    return false;
                });
            }
        }
        if (images.length > 1) {
            thumbsC.sortable({
                update: function(event, ui) {
                    var kimages = [];
                    thumbsC.find("img").each(function() {
                        kimages[kimages.length] = $(this).attr("src");
                        $("#" + imgId).val(kimages.join());
                        plu_show_thumbs(imgId);
                    });
                }
            });
            thumbsC.disableSelection();
        }
    }

};

function checkDefaultImg(){
    var $ = jQuery;
    var imgVal = $(".thumb");
    if(imgVal.length == 0){
        $(".default-img").show();
        $(".img_path").val($(".default-img").attr("ref"));
    }
};



