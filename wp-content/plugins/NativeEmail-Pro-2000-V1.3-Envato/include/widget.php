<?php
/* 	add widgets	 */
add_action('widgets_init', 'EmailAlertPro_widget');
add_shortcode('NativeEmail', 'shortcode_display_emailalertpro_widget');

//add user to subscription list --hooks
add_action('wp_ajax_handle_email_subscription', 'handle_email_subscription');
add_action('wp_ajax_nopriv_handle_email_subscription', 'handle_email_subscription');
add_action('wp_ajax_get_category_list_at_widget_for_widget', 'get_category_list_at_widget_for_widget');
add_action('admin_footer', 'widget_script');

class EmailAlertProwidget extends WP_Widget {

    // constructor
    function __construct() {
        //parent::WP_Widget(false, $name = __('Native Email', 'EmailAlertPro'));
        parent::__construct(false, $name = __('Native Email', 'EmailAlertPro'));
    }

    // widget form creation
    function form($instance) {

    if ($instance) {
            $title = esc_attr(@$instance['title']);
            $text = esc_attr(@$instance['text']);
            $textarea = esc_textarea(@$instance['textarea']);
            $widget_native_selected_term_type = esc_attr(@$instance['widget_native_selected_term_type']);
            $widget_native_selected_post_type = esc_attr(@$instance['widget_native_selected_post_type']);
            $widget_native_category_list_name = esc_attr(@$instance['widget_native_category_list_name']);
            $widget_native_category_button_classes = esc_attr(@$instance['widget_native_category_button_classes']);
			//var_dump($widget_native_category_list_name);
			
        } else {
            $title = '';
            $text = '';
            $textarea = '';
            $widget_native_selected_term_type = '';
            $widget_native_selected_post_type = '';
            $widget_native_category_button_classes = '';
			$widget_native_category_list_name = '';
        }
        ?>
		
        <p class="post_type">
            <label for="native_selected_post_type">Select Post type</label>
            <?php
            $args = array(
                'public' => true,
                '_builtin' => false
            );

            $output = 'objects'; // names or objects, note names is the default
            $operator = 'or'; // 'and' or 'or'

            $post_types = get_post_types($args, $output, $operator);
            $select_post_type = $widget_native_selected_post_type; //get_option('native_selected_post_type' , 'post');

            echo '<select name="' . $this->get_field_name("widget_native_selected_post_type") . '" >';
            foreach ($post_types as $key => $cat) {
                $selected = '';
                if ($cat->name == $select_post_type)
                    $selected = 'selected="selected"';
                echo '<option value="' . $cat->name . '" ' . $selected . '>' . $cat->label . '</option>';
            }
            echo '</select>';
            ?>
        </p>
        <p class="term_type">
            <label>Select Category</label>
       <?php
            $args = array('public' => true);
            $output = 'objects'; // or names
            $operator = 'or'; // 'and' or 'or'

            $cats = get_taxonomies($args, $output, $operator);


            $select_term_type = $widget_native_selected_term_type;
            $select_term_type = ( $select_term_type != '' ) ? $select_term_type : 'category';

            print '<select class="widget_category_change"  name="' . $this->get_field_name("widget_native_selected_term_type") . '">';
            foreach ($cats as $key => $cat) {
                $selected = '';
                if ($cat->name == $select_term_type) {
                    $selected = 'selected="selected"';
                    $selected_term = $cat->name;
                }
                print '<option value="' . $cat->name . '" ' . $selected . '>' . $cat->label . '</option>';
            }
            print '</select>';
			
            print '<div class="emailaertpro_error_message"></div>';

            $category_list_field_name = $this->get_field_name("widget_native_category_list_name");
            
			//var_dump($category_list_field_name);
			
			$category_list = get_category_list_at_widget_for_widget($selected_term, $select_post_type, $widget_native_category_list_name, '' , 5, $category_list_field_name);
			
            print $category_list;
            ?>
		</p>

        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">
                <?php _e('Widget Title', 'EmailAlertPro'); ?>
            </label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>	 
        <p>	
            <label for="<?php echo $this->get_field_id('textarea'); ?>"><?php _e('Message Above Widget:', 'EmailAlertPro'); ?></label>
            <textarea class="widefat" id="<?php echo $this->get_field_id('textarea'); ?>" name="<?php echo $this->get_field_name('textarea'); ?>"><?php echo $textarea; ?></textarea>
        </p>
        <p>	
            <label for="<?php echo $this->get_field_id('widget_native_category_button_classes'); ?>">
				<?php _e('Add comma separated classes for submit button eg: class 1 , class 2 etc.', 'EmailAlertPro'); ?>
			</label>
            <input class="widefat" id="<?php echo $this->get_field_id('widget_native_category_button_classes'); ?>" name="<?php echo $this->get_field_name('widget_native_category_button_classes'); ?>" type="text" value="<?php echo $widget_native_category_button_classes; ?>" />
        </p>
        <?php
    }

    // widget update
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        // Fields
        $instance['title'] = strip_tags($new_instance['title']);
        // $instance['text']   	= strip_tags($new_instance['text']);
        $instance['textarea'] = strip_tags($new_instance['textarea']);
        $instance['widget_native_selected_term_type'] = strip_tags($new_instance['widget_native_selected_term_type']);
        $instance['widget_native_selected_post_type'] = strip_tags($new_instance['widget_native_selected_post_type']);
        $instance['widget_native_category_list_name'] = strip_tags(implode(",", $new_instance['widget_native_category_list_name']));
        $instance['widget_native_category_button_classes'] = strip_tags($new_instance['widget_native_category_button_classes']);
        return $instance;
    }

    // widget display
    function widget($args, $instance) {
	
        extract($args);

        // these are the widget options

        $title = apply_filters('widget_title', $instance['title']);

        $message = $instance['textarea'];
        $widget_native_selected_term_type = $instance['widget_native_selected_term_type'];
        $widget_native_selected_post_type = $instance['widget_native_selected_post_type'];
        $widget_native_category_list_name = $instance['widget_native_category_list_name'];
        $classes = $widget_native_category_button_classes = $instance['widget_native_category_button_classes'];


        echo $before_widget;
        echo '<div class="widget-email-alert">';

		//echo do_shortcode($title);

        if ($title)
            print '<div class="widget-email-alert-title"><h1 class="widget-title">' . $title . '</h1></div>';
        if ($message) {
            print '<div class="emailalertpro_message widget-email-alert-description">' . $message . '</div>';
        }
        
		echo display_emailalertpro_widget($widget_native_selected_term_type, $widget_native_selected_post_type, $widget_native_category_list_name, $classes);

        echo '</div>';
        echo $after_widget;
    }

}

function EmailAlertPro_widget() {
    require_once( EAPSITEPATH . 'include/widget.php');
    register_widget('EmailAlertProwidget');
}

function shortcode_display_emailalertpro_widget($args = null) {
	global $native_settings;

    $selected_taxonomy = $native_settings->get( 'native_selected_term_type', false );

    $atermtype = isset($args['term_type']) ? $args['term_type'] : '';

    if (isset($atermtype) && $atermtype != '') {
        $term_type = $args['term_type'];
    } elseif (!isset($atermtype) && $atermtype == '' && $selected_taxonomy) {
        $term_type = $selected_taxonomy;
    } else {
        $term_type = 'category';
    }

    if (isset($args['post_type']) && $args['post_type'] != '') {
        $post_type = $args['post_type'];
    } else {
        $post_type = 'post';
    }
    if (isset($args['cate_list']) && $args['cate_list'] != '') {
        $cate_list = $args['cate_list'];
    } else {
        $cate_list = '';
    }
    if (isset($args['classes']) && $args['classes'] != '') {
        $classes = $args['classes'];
    } else {
        $classes = '';
    }
    return display_emailalertpro_widget($term_type, $post_type, $cate_list = '', $classes);
}

function display_emailalertpro_widget( $term_type = 'category', $post_type = 'post', $cate_list = '', $classes = '') {
    global $native_settings;
	
    $native_users = new native_users;
    $category_manage = new EmailAlertPro_category_manage;
	$common = new emailalertpro_commonclass;
	
    if ($term_type == '') {
        $term_type = $native_settings->get('native_selected_term_type', 'category');
    }
	
    if ($post_type == '') {
			$post_type = 'post';
    }


    //$widget_native_selected_post_type , $widget_native_selected_term_type
    $widget = '';

    $widget.='<div class="widget_email_alert_cover">   
			  <form class="widget-email-alert-form" name="widget-email-alert-check-with-input" method="post" enctype="multipart/form-data">' .
            wp_nonce_field('native_nonce_field', 'native_nonce_field') . '
					<div id="email_message"></div>
		   		<div class="widget_area_email">
                   <div class="native_categorylist_cover">';

    $native_users->term_type = $term_type;

    $subscriber = $native_users->native_email_fetch_user_detail();

    $subscriber_id = $subscriber['email'];

    $selected_cat_list = $subscriber['cat_ids'];
	
	$widget.= $common->checkbox_selection_process();

	 $category_list = $category_manage->get_all_category_list( $term_type , $post_type  , $cate_list , false );
	
    //$category_list = $category_manage->get_all_category_list( $term_type, $post_type, $cate_list, false);
	
	$category_list = apply_filters( "ne_widget_display_filter" , $category_list , $term_type, $post_type, $cate_list, false );
	
	$widget.= $category_list;

    if (is_string($classes)) {
        $classes = str_replace(",", " ", $classes);
    } else {
        $classes = '';
    }
    $widget.='</div>
                   <p class="emailaertpro_error_message" ></p>
				   <input type="hidden" name="website" value="' . site_url() . '" class="website_url"/>
				   <input type="text" name="emailaertpro_mail" placeholder="Enter your email" class="emailaertpro_mail widget-area" value="' . $subscriber_id . '"/>
                   <input type="submit" name="subscribe" value="subscribe" class="btn-primary emailaertpro_mail_submit emailprobutton ' . $classes . '"/>
	          </div> 
            </form> 
           </div>';
		   
    $widget .= link_to_demo_site();
	
    return $widget;
}


function handle_email_subscription() {
    // set cookie
    $common = new emailalertpro_commonclass;

    if (NativeEmail_check_user_status()) {
        echo json_encode(array('status' => 'pro', 'message' => 'Please upgrade your subscription.'));
        exit();
    }
    $useremail = $_POST['useremail'];
    /**
     *  remember user enter email
     */
    setcookie("nativevisitor", $useremail, time() + 3600, "/");

    if (!empty($_POST['selected_cats'])) {
        $selected_cats = implode(',', $_POST['selected_cats']);
    }
    if (!empty($_POST['taxonomy'])) {
        $taxonomy = $_POST['taxonomy'];
    }
    if (!empty($_POST['post_type'])) {
        $post_type = $_POST['post_type'];
    }

    $res = $common->email_alert_subscribe_user($useremail, $selected_cats, $taxonomy, $post_type);

    if ($res['rows'] >= 1) {
        $res['type'] = $res['status'];
        $res['status'] = 'ok';
    } else {
        $res['status'] = $res['error'];
    }
    echo json_encode($res);
    exit;
}


function get_category_list_at_widget_for_widget( $select_taxonomy = null , $select_post_type = 'post' , $selected_list = '' , $catToInclude = '' , $return = null, $field_name = null) {	
		$catManage = new EmailAlertPro_category_manage;
		$catManage->catFieldName = $field_name.'[]';
		
    
		if (isset($select_taxonomy) && $select_taxonomy == null) {
			$select_taxonomy = $_POST['taxonomy'];
			$select_taxonomy = ($select_taxonomy == '') ? 'category' : $select_taxonomy;
		}
	
		$catArgs = array('taxonomy' => $select_taxonomy);
		$response = array();
		$cat_list = '';
		
		//var_dump("===".$catToInclude);
		
		$cat_list .= '<div class="cat_list native_categorylist widget">';
		$cat_list .= $catManage->get_all_category_list( $select_taxonomy , $select_post_type  , $catToInclude , true ,$selected_list);
		$cat_list .= '</div>'; 
		
		$response = array();
		$response['category_list'] = $cat_list;
		$response['status'] = 'success';
		$category_list_html = $response['category_list'];
		
		//$category_list_html = apply_filters( 'ne_catlist_at_widget_for_widget'  , $category_list_html , $categories );
		
    if ($return) {
        return $cat_list;
    } else {
        echo json_encode($response);
        exit;
    }
}


function widget_script() {
    $category_list_field_name = ''; //test this
    print '<script> 
			jQuery(document).ready(function(){
				var field_name = "' . $category_list_field_name . '";
				if(jQuery(".widget_category_change").length){
					jQuery("body").on( "change" , ".widget_category_change" , function(){
					var current_val = jQuery(this).val();
					var dhis = jQuery(this);
								jQuery.ajax({ 
									type: "POST",
									url:"'.admin_url("admin-ajax.php").'",
									data:{action:"get_category_list_at_widget_for_widget","field_name":field_name, "taxonomy":current_val},
									beforeSend:function(){	jQuery(".emailaertpro_error_message").html("please wait while loading category list ..")},	
									success:function(response){
										jQuery(".emailaertpro_error_message").html("");
										response = jQuery.parseJSON(response);
										if(response.status == "success")
										dhis.parent("p").parent("div").find(".cat_list").html(response.category_list);
										}
								});
						
							});
					}
				jQuery("body").on( "click" , ".native_categorylist li input" , function(){
				
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
				});
		</script>';
	print '<style type="text/css">
			.widget-inside .native_categorylist .children{
				margin-left:10px;
			}
			</style>';	
}


?>