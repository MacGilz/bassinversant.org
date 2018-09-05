<?php

/* * 	
 * manage categories functions
 *  */

class EmailAlertPro_category_manage {
	public $category_to_exclude = array();
	public $category_to_include = array();
	public $category_number = 10;
	public $hierarchical = false;
	public $orderby = 'name';
	public $order = 'ASC';
	public $parent_catid = 0;
	
	public $catFieldName = 0;
	
	
    function __construct() {
			$this->category_number = $this->category_number();
			$this->category_to_exclude = $this->category_to_exclude();
			$this->category_to_include = $this->category_to_include();		
			$this->catFieldName  = 'category[]';
    }

    function category_number(){
        global $emailalertpro;
        if ((get_option($emailalertpro['CATEGORYNUMBER'])) && get_option($emailalertpro['CATEGORYNUMBER']) > 0) {
            return get_option($emailalertpro['CATEGORYNUMBER']);
        } else
            return $emailalertpro['category_number_to_return'];
    }

    function category_to_exclude(){
        global $native_settings;
		$category_to_include = $this->category_to_include = $native_settings->get('category_to_exclude');
		return $category_to_include;
    }

    function category_to_include() {
			global $native_settings;
			//todo test this
			$category_to_exclude = $native_settings->get('category_to_exclude' , '');
			$category_to_include = $this->category_to_include = $native_settings->get('category_to_include' , '');
			$category_to_include =  implode("," , @array_diff( explode(",",$category_to_include) , explode(",",$category_to_exclude)));
			
			return $category_to_include;
	}

    function show_empty_category_list() {
        global $emailalertpro;
        if (get_option($emailalertpro['show_empty_category_list'])) {
            return (get_option($emailalertpro['show_empty_category_list']));
        } else
            return '0';
    }

    function hierarchical_category_tree( $catid , $post_type = 'post', $taxonomies = 'category', $category_to_include = null , $show_select = false , $selectedList = '') {
	
        // user to display at front end side
        //$hide_empty = $this->show_empty_category_list();
        //$category_to_exclude = $this->category_to_exclude();
        
		$this->category_to_include = $category_to_include;
		if ( $category_to_include == null )
				$this->category_to_include = $category_to_include = $this->category_to_include();
				
        $class = '';
		$this->parent_catid = $catid;
        
		$next = $this->get_common_terms( $taxonomies );//get_terms
		
		if ( $this->parent_catid > 0) {
            $class = "class='children'";
        }
        $return = '';
		 
			
			
        if ($next  && !is_wp_error( $next )) {
            $return .= '<ul class="native_categorylist catman">';
            foreach ($next as $key => $cat):
                
				$checked = '';
				if ($show_select) {
					//var_dump($selectedList);
					$select_list_array = explode(",", $selectedList);
					
					if (in_array($cat->term_id, $select_list_array)) {
						$checked = "checked";
					}
				}
				
				$return .= '<li ' . $class . '><input type="checkbox" name="'.$this->catFieldName.'" value="' . $cat->term_id . '"  '.$checked.'><label 	class="cat-manage widget-email-alert-label">' . $cat->name . '</label>';
                $this->hierarchical =true;
				
				$return .= $this->hierarchical_category_tree( $cat->term_id, $post_type, $taxonomies, $category_to_include , $show_select , $selectedList);
				
                $return .= '</li>';
            endforeach;
            $return .= '</ul>';
        }
		else if(is_wp_error( $next )){
					$return .= '<li>';
                    $return .= $taxonomies.' ';
                    $return .= $next->get_error_message();
                    $return .= '</li>';
			}
        return $return;
    }

    /*     * *
     * * displays category list 
     * * $taxonomies type of  taxonomies
     * * $selected_post_type  post
     * * $category_to_include display into the list
     * * $show_select ? true => mark the provided list 	
     * */

    function get_all_category_list( $taxonomies = 'category', $selected_post_type = 'post', $category_to_include = null, $show_select = false , $selectedList = '') {
		//var_dump($taxonomies , $selected_post_type , $category_to_include , $show_select  , $selectedList );
		
		
		global $native_settings;
        $emailcommon = new emailalertpro_commonclass;
        $state = $emailcommon->get_display_category_fashion();
        $selected_taxonomy_for_user = $taxonomies;
		$return = '';
		
        if ( $state == 'yes') {
            $return.= $this->hierarchical_category_tree( 0 , $selected_post_type, $taxonomies, $category_to_include , $show_select , $selectedList );
        } 
		else {
		
            //display at frontend widget
            $hide_empty = $this->show_empty_category_list();
            $this->category_to_exclude = $this->category_to_exclude();
            $this->category_to_include = $category_to_include;
		   
		   if ( $category_to_include == null )
                 $this->category_to_include = $this->category_to_include();

            if (isset($taxonomies) && $taxonomies != '') {
                $selected_category = $taxonomies;
            } else {
                $selected_category = $native_settings->get('native_selected_term_type', 'category');
            }
			$this->hierarchical =false;
            $this->parent_catid  = '';
			$categories = $this->get_common_terms( $selected_category );//get_terms
            $return = '';


            $return = '<ul class="native_categorylist catman2">';
            if (!empty($categories) && !is_wp_error( $categories )) {
                foreach ($categories as $category) {
                    $checked = '';
                    if ($show_select) {
                        $select_list_array = explode(",", $selectedList);
                        if (in_array($category->term_id, $select_list_array)) {
                            $checked = "checked";
                        }
                    }

                    $return .= '<li>';
                    //$return .= '<input type="checkbox"  ' . $checked . ' name="category[]" value="' . $category->term_id . '">';
                    $return .= '<input type="checkbox"  ' . $checked . ' name="'.$this->catFieldName.'" value="' . $category->term_id . '">';
                    $return .= '<label class="cat-manage widget-email-alert-label">' . $category->name . '</label>';
                    $return .= '</li>';
                }
            }
			else if(is_wp_error( $categories )){
					$return .= '<li>';
                    $return .= $selected_category.' ';
                    $return .= $categories->get_error_message();
                    $return .= '</li>';
			}else{
					$return .= '<li>';
                    $return .= __('empty category list');
                    $return .= '</li>';
			}
            $return .= '</ul>';
        }
		
        $return .= '<input type="hidden" name="selected_category_for_db" value="' . $selected_taxonomy_for_user . '" class="selected_category_for_db">';
        $return .= '<input type="hidden" name="selected_post_type_for_db" value="' . $selected_post_type . '" class="selected_post_for_db">';
		
        return $return;
    }

	
	function get_common_terms( $selected_category , $args = null){
			global $native_settings;
		$taxonomies = array($selected_category);
		$category_number = $this->category_number();
		$category_to_exclude = $this->category_to_exclude;
		
		if(!is_array($this->category_to_include)){
			$category_to_include = explode( ",",$this->category_to_include);
		}
		else{
			$category_to_include = $this->category_to_include;
		}
		
		//var_dump(is_admin());
		
		if( $native_settings->get('native_selected_term_type', 'category') != $taxonomies && is_admin() == true ){
			$category_to_exclude = '';
			$category_to_include = '';
		}
		
		if($args == null){
			
			 $args = array(
					'orderby' => $this->orderby,
					'order' =>   $this->order,
					'number' =>  $category_number,
					'exclude' => $category_to_exclude,
					'include' => $category_to_include,
					'hide_empty' => false,
					'fields' => 'all',
					'hierarchical' => $this->hierarchical,
				);
				 
			//if( $this->parent_catid ){
				  $args['parent'] = $this->parent_catid;
			//}
			//else{
				//unset($args['parent']);
			//}
		}
		$categories = get_terms( $taxonomies, $args);	
		//print(count($categories));
		//exit;
		return $categories;
	}
}
?>