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

begin_test();
$id = 101;
$model = new BasicModel($id);
test($model->id, $id, array('name' => 'autoload'));

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
    'city' => '深圳',
    'district' => '福田区',
    '');
