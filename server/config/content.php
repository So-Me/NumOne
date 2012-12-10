<?php
!defined('IN_APP') && exit('ILLEGAL EXECUTION'); // in fact, even if this is exucted by user, would it show anything?
/**
 * @file    common
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

$config['site']['name'] = '沃生活';

// pages need login
$config['controllers_need_login'] = array('setting');

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

$config['nav']['top'] = '
管理面板 index
帮助 help 
';

$config['nav']['side'] = '
商铺管理 shop
 - 添加 ?a=add
 + 查看 
分类管理 category
 + 查看 
 - 添加大类 ?a=add&target=BigCategory
 - 添加小类 ?a=add&target=Category
地区管理 district
 + 查看
 - 添加省级地区 ?a=add&target=Province
 - 添加市县级地区 ?a=add&target=City
 - 添加区 ?a=add&target=District
';
