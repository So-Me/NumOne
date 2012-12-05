<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

// login out
if (isset($_GET['logout']) && isset($user)) {
    // 因为可能时间久远，用户已经session失效，但依然点击了注销按钮
    if (is_object($user)) {
        $user->logout(); 
    }
    
    redirect();
}

// if user is already logged in, 
// to index since we didn't provide such a link
if ($has_login) {
    redirect(); // to index
}

$username = _post('username');
$password = _post('password');

$msg = '';
if ($by_post) {
    if (User::check($username, $password)) {
        $user = User::getByName($username);
        $user->login();
        $type = strtolower($user->type);
        $$type = $user->instance();
        $back_url = _get('back_url') ?: DEFAULT_LOGIN_REDIRECT_URL;

        switch ($user->type) {
            case 'SuperAdmin':
                $back_url = 'user';
                break;

            case 'Admin':
            case 'Customer':
                break;
            
            default:
                throw new Exception("unkonwn user type: $user->$type");
                break;
        }
        redirect($back_url);
        
    } else {
        $msg = $config['error']['info']['USERNAME_OR_PASSWORD_INCORRECT'];
    }
}

$view .= '?master';

$page['scripts'][] = 'jquery.validate.min';
