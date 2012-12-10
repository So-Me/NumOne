<?php
!(defined('IN_APP') && defined('ON_TEST')) && exit('ILLEGAL EXECUTION');

Pdb::setConfig($config['db']);

// clear side effects for all
// unset all session
if (1) {
    foreach ($_SESSION as $key => $value) {
        unset($_SESSION[$key]);
    }
}

// clear db entries that was insert by test
include 'clear_db.php';

$all_pass = true;

require CORE_ROOT . 'BasicModel.php';
$user_lib_file = APP_ROOT . 'lib' . DS . 'function.php';
if (file_exists($user_lib_file))
    require_once $user_lib_file;

// test for add
begin_test();
$province = Province::add('广东省');
test(Province::count(), 1, array('name' => 'add province'));

begin_test();
$city = City::add($province, '深圳');
test(City::count(), 1, array('name' => 'add city'));

begin_test();
$district = District::add($city, '福田区');
test(District::count(), 1, array('name' => 'add district'));

begin_test();
$info = array(
    'name' => '兰州拉面',
    'category' => 4,
    'district' => $district->id,
    'latilongi' => '22.546692,114.065162', // 真的有这家兰州拉面
    'images' => array('/test/static/img/5123370_143953049318_2.jpg'));
$shop = Shop::add($info);
test(Shop::count(), 1, array('name' => 'add shop'));

// test for read

begin_test();
$query = array('kind' => 'BigCategory');
$url = build_url($query);
$data = query($url);
$bc = reset($data->items);
test($bc->name, '餐饮美食', array('name' => "get BigCategory: $url"));

begin_test();
$bigCategoryId = '2';
$query = array('kind' => 'Category', 'bigCategoryId' => $bigCategoryId);
$url = build_url($query);
$data = query($url);
$i = reset($data->items);
test($i->big_category, $bigCategoryId, array('name' => "get Category: $url"));

begin_test();
$query = array(
    'kind' => 'ShopList', 'distance' => 1000, 
    'latilongi' => '22.543105,114.057907',
    'districtId' => 1);
$url = build_url($query);
$data = query($url);
d($data);
$i = reset($data->items);
test($i->name, 'xxxxx', array('name' => "get ShopList: $url"));
