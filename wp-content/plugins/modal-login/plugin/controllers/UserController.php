<?php 

class UserController extends BaseController {


    /**
    * Show the profile for the given user.
    */
    public function showProfile()
    {
        $user = User::find(1);
        print_r($user);
        //return $this->view->render('user/profile', ['user' => $user]);

    }
    public function ajaxLogin(){

        //check_ajax_referer( 'ajax-login-nonce', 'security' ); // on the second log in attempt with no page refresh this
                                                              // function fails her

        // Nonce is checked, get the POST data and sign user on
        $info = array();
        $info['user_login'] = $_POST['username'];
        $info['user_password'] = $_POST['password'];
        $info['remember'] = $_POST['remember'];

        $user = wp_signon( $info, false );

        if ( is_wp_error($user) ){
                echo json_encode(array('loggedin'=>false, 'message'=>__('Wrong username or password.')));
                die();
        }

        //setting the user variables so the globals have content without an actual page load
        wp_set_current_user( $user->ID, $user->user_login );
        wp_set_auth_cookie( $user->ID, true, false );
        do_action( 'wp_login', $user->user_login );

        ob_start();
        //gzp_logged_in_menu();
        $menu_content = ob_get_contents();
        ob_end_clean();

        echo json_encode(array('loggedin'=>true, 'message'=>__('Login successful, redirecting...'), 'menu_content'=>$menu_content,'user_signon'=>$user));

        die();
	}
//add_action( 'wp_ajax_nopriv_ajaxlogin', 'ajax_login' );

}
?>