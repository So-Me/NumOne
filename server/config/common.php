<?php
!defined('IN_APP') && exit('ILLEGAL EXECUTION'); // in fact, even if this is exucted by user, would it show anything?
/**
 * @file    common
 * @author  ryan <cumt.xiaochi@gmail.com>
 * @created Jun 30, 2012 10:38:22 AM
 */

if (isset($_SERVER['HTTP_APPNAME'])) { // on server
    define('ON_SERVER', TRUE);
    
    define('DEBUG', TRUE);
    
    define('UP_DOMAIN', 'xxxx');
} else {
    define('ON_SERVER', FALSE);
    
    define('DEBUG', TRUE);
    
    define('JS_VER',  time());
    define('CSS_VER', time());
}

define('ROOT', '/'); // 这个东西，尤其可恶，实在不觉得有存在的必要。。

$config['site']['name'] = '沃生活';

$config['db'] = array(
    'host' => 'localhost',
    'dbname' => 'jewelry',
    'username' => 'root',
    'password' => 'xiaosan'
);

if (ON_SERVER) {
    // 会覆盖之前的配置
    $config['db'] = array(
        'master' => array('host' => SAE_MYSQL_HOST_M),
        'slave'  => array('host' => SAE_MYSQL_HOST_S),
        'port'   => SAE_MYSQL_PORT,
        'dbname' => SAE_MYSQL_DB,
        'username' => SAE_MYSQL_USER,
        'password' => SAE_MYSQL_PASS
    );
    include 'server.php';
}

// error info
$config['error']['info'] = array(
    'PASSWORD_EMPTY' => 'plz enter password',
    'REPASSWORD_EMPTY' => '请重新输入密码以确认',
    'NEW_PASSWORD_EMPTY' => '请输入新密码',
    'PASSWORD_NOT_SAME' => '两次输入的密码不一致，请重新输入',
    'USERNAME_EMPTY' => 'username empty',
    'USERNAME_OR_PASSWORD_INCORRECT' => '用户名或者密码不正确',
    'PASSWORD_INCORRECT' => '密码不正确',
    'USER_ALREADY_EXISTS' => '这个用户名已经被使用，请重新选择用户名',
    'REALNAME_EMPTY' => '请填写真实姓名',
    'PHONE_EMPTY' => '请填写手机号码',
    'EMAIL_EMPTY' => '请填写您的电子邮箱', );

// pages need login
$config['controllers_need_login'] = array('setting');
