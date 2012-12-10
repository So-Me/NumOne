<?php
!(defined('IN_APP') && defined('ON_TEST')) && exit('ILLEGAL EXECUTION');

$dbConfig = array_merge($config['db'], array('force' => 'master'));
Pdb::setConfig($dbConfig);

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
$bigCategory = BigCategory::add('餐饮美食');
BigCategory::add('休闲娱乐');
test(BigCategory::count(), 2, array('name' => 'add BigCategory'));

begin_test();
$category = Category::add($bigCategory, '民族清真');
Category::add($bigCategory, '西餐');
test(Category::count(), 2, array('name' => 'add Category'));

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
    'latilongi' => '22.546692,114.065162', // 真的有这家兰州拉面 广东省深圳市福田区福中一路
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
$query = array('kind' => 'Category', 'bigCategoryId' => $bigCategory->id);
$url = build_url($query);
$data = query($url);
$i = reset($data->items);
test($i->big_category, $bigCategory->id, array('name' => "get Category: $url"));

begin_test();
$query = array(
    'kind' => 'ShopList', 
    'distance' => 1000, 
    'latilongi' => '22.548867,114.072197', // 兰州拉面1000米以内
    'districtId' => $district->id);
$url = build_url($query);
$data = query($url);
$i = reset($data->items);
test($i->name, '兰州拉面', array('name' => "get ShopList(within distance): $url"));

begin_test();
$query['latilongi'] = '22.566305,114.09138'; // 1000米以外
$url = build_url($query);
$data = query($url);
$ic = $data->itemCount;
test($ic, 0, array('name' => "get ShopList(out of distance): $url"));

begin_test();
$query = array('kind' => 'Shop', 'id' => 1);
$url = build_url($query);
$data = query($url);
test($data->name, '兰州拉面', array('name' => "get Shop: $url"));
