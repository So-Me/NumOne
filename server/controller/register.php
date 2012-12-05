<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

if ($has_login)
    redirect();

list(
    $username, 
    $password, 
    $repassword,
    $realname,
    $phone,
    $email
) = _post(
    'username',
    'password',
    'repassword',
    'realname',
    'phone',
    'email'
);

$msg = '';

if ($by_post) {
    $ERROR_INFO = $config['error']['info'];
    if (empty($password)) {
        $msg = $ERROR_INFO['PASSWORD_EMPTY'];
    } elseif (empty($repassword)) {
        $msg = $ERROR_INFO['REPASSWORD_EMPTY'];
    } elseif ($password !== $repassword) {
        $msg = $ERROR_INFO['PASSWORD_NOT_SAME'];
    } elseif (empty($username)) {
        $msg = $ERROR_INFO['USERNAME_EMPTY'];
    } elseif (User::find($username)) {
        $msg = $ERROR_INFO['USER_ALREADY_EXISTS'];
    } elseif (empty($realname)) {
        $msg = $ERROR_INFO['REALNAME_EMPTY'];
    } elseif (empty($phone)) {
        $msg = $ERROR_INFO['PHONE_EMPTY'];
    } elseif (empty($email)) {
        $msg = $ERROR_INFO['EMAIL_EMPTY'];
    } else {
        $customer = Customer::register(
            compact(
                'username', 
                'password', 
                'realname', 
                'phone',
                'email'
            ));
        $user = $customer->user();
        $user->login();
        $back_url = _req('back_url') ?: DEFAULT_LOGIN_REDIRECT_URL;
        redirect($back_url);
    }
}

$view .= '?master';
$page['scripts'][] = 'jquery.validate.min';
