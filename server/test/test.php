<?php

require 'lib.php'; // functions for test

require_once APP_ROOT . 'lib/function.php';
require_once APP_ROOT . 'lib/autoload.php';
include_once APP_ROOT . 'config/common.php';

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

// case 1 autoload
begin_test();
$id = 101;
$model = new Model($id);
test($model->id, $id, array(
    'name' => 'autoload'));

// case 2 test for kind_of_equal()
begin_test();
$a = array('z' => 3, 'a' => 42);
$b = array('a' => 42, 'z' => 3);
test(kind_of_equal($a, $b), true, array('name' => 'test for kind_of_equal()'));

// case 3 register Customer, user db
begin_test();
$username = 'test_user';
$password = 'password';
$realname = '小池';
$phone = '13711231212';
$email = 'cumt.xiaochi@gmail.com';
$info = compact(
    'username',
    'password',
    'realname',
    'phone',
    'email');
$customer = Customer::register($info);
test(1, 1, array('name' => 'register Customer, db'));

// case 4 User::check($username, $password)
begin_test();
test(
    User::check($username, $password),
    true,
    array('name' => 'User::check($username, $password)'));

// case 5 Super Admin create Admin, db
begin_test();
$username = 'test_admin';
$password = 'password';
$user = User::getByName('root');
$superadmin = $user->instance();
$admin = $superadmin->createAdmin(compact('username', 'password'));
$ideal_arr = array(
    'name' => $username,
    'password' => md5($password),
    'type' => 'Admin');
$id = Pdb::lastInsertId();
$real_arr = Pdb::fetchRow(
    'name, password, type', 
    User::$table, 
    array('id=?' => $id));
test($real_arr, $ideal_arr, array('name' => 'Super Admin create Admin, db'));

// case 6 Admin update gold Price
begin_test();
$admin->updatePrice('PT950', '1903.21');
$admin->updatePrice('Au750', '1723.45');
test(1, 1, array('name' => 'Admin update gold Price'));

// case 7 Admin add Factory
begin_test();
$info = array(
    'name' => '嘉黛_test',
    'contact' => '吴小牛',
    'phone' => '13526523659',
    'qq' => '5833652584',
    'city' => '湖北武汉');
$factory = $admin->addFactory($info);
test(count(Factory::names()), 1, array('name' => 'Admin add Factory'));

// case 8 Admin post Product, db
begin_test();
$prd_types = Product::types();
$info = array(
    'name' => '唯爱心形群镶女戒_test',
    'type' => reset(array_keys($prd_types)),
    'material' => json_encode(array(
        'PT950', 
        '白18K金',
        '黄18K金',
        '红18K金')),
    'rabbet_start' => '0.30',
    'rabbet_end' => '0.60',
    'weight' => 9,
    'small_stone' => 3,
    'st_weight' => 2.1,
    'image1_400' => '/test/static/img/i400-1.jpg',
    'image2_400' => '/test/static/img/i400-2.jpg',
    'image3_400' => '/test/static/img/i400-3.jpg',
    'image1_thumb' => '/test/static/img/i80-1.jpg',
    'image2_thumb' => '/test/static/img/i80-2.jpg',
    'image3_thumb' => '/test/static/img/i80-3.jpg');
$product = $admin->postProduct($info);
// add more
// for ($i=0; $i < 50; $i++) {
//     $info2 = $info;
//     $info2['name'] = $info['name'] . $i;
//     $admin->postProduct($info2);
// }
// but what if we count?
test(
    Pdb::fetchRow('*', Product::$table, array('id=?' => $product->id)),
    $info,
    array(
        'name' => 'Admin post Product, db',
        'compare' => 'in'));

// case 9 Admin del Product
begin_test();
$info = array_merge($info, array('name' => 'product test to del'));
$product_to_del1 = $admin->postProduct($info);
$product_to_del2 = $admin->postProduct($info);
$old_num = Product::count();
$admin->delProduct($product_to_del1);
$admin->delProduct($product_to_del2->id);
$new_num = Product::count();
test($old_num - 2, $new_num, array('name' => 'Admin del Product'));

// case 10 Customer edit Address
begin_test();
$address = $customer->defaultAddress();
$address->edit(array(
    'name' => '小池',
    'phone' => '14722320989',
    'detail' => '深圳罗湖区田贝'));
test(1, 1, array('name' => 'Customer edit Address'));

// case 11 Customer add Product to Cart
begin_test();
$opts = array(
    'material' => 'PT950',
    'size' => 12,
    'carve_text' => 'I love U');
$order = $customer->addProductToCart($product, $opts);
$opts['carve_text'] = 'I love U 2';
$order_another = $customer->addProductToCart($product, $opts);
test(1, 1, array('name' => 'Customer add Product to Cart'));

// case 12 Cart count()
begin_test();
$cart = $customer->cart();
test(+$cart->count(), 2, array('name' => 'Cart count()'));

// case 13 Customer del a Product from Cart
begin_test();
$opts = array(
    'material' => 'PT950',
    'size' => 12,
    'carve_text' => 'I love U');
$opts2 = $opts;
$opts2['carve_text'] = $opts['carve_text'] . '3';
$order_to_del = $customer->addProductToCart($product, $opts2);
$old_num = $customer->cart()->count();
$customer->delProductFromCart($order_to_del);
$new_num = $customer->cart()->count();
test(
    $old_num - 1,
    $new_num,
    array('name' => 'Customer del a Product from Cart'));

// case 14 Customer submit a Cart
begin_test();
$old_entry_num = Pdb::count(BigOrder::$table);
$big_order = $customer->submitCart();
$entry_num = Pdb::count(BigOrder::$table);
test(
    $old_entry_num + 1,
    +$entry_num,
    array('name' => 'Customer submit a Cart'));

// case 15 Admin(?) edit Stone
begin_test();
$info = array(
    'weight' => '3',
    'cut' => 'EX',
    'color' => '',
    'polish' => '',
    'clarity' => '',
    'symmetry' => '',
    'certificate' => '',
    'no' => '',
    'remark' => '');
$stone = $order->stone();
$stone->edit($info);
test(1, 1, array('name' => 'Admin(?) edit Stone'));

// case 15
begin_test();
$order->changeFactory($factory);
test(1, 1, array('name' => 'Admin change Order\'s Factory'));

// case 16 Customer customize Order
begin_test();
$info = array(
    'material' => 'PT950',
    'stone' => '9',
    'size' => '13',
    'carve_text' => 'for test',
    'images' => array(ROOT . 'test/static/img/i400-3.jpg'),
    'remark' => 'customize for test');
$customer->customizeOrder($info);
test(1, 1, array('name' => 'Customer customize Order'));

// case 16 Admin recharge customer's Account then use it to pay order
begin_test();
$account = $customer->account();
$admin->rechargeAccount($account, 4000);
//sleep(1);
$admin->payOrder($order, 200, 'what?');
test(1, 1, array('name' => 'Admin recharge customer\'s Account then use it to pay order'));

// case 17 Admin Confirmed Order (Send Order to Factory)
begin_test();
$admin->sendOrderToFactory($order);
test(1, 1, array('name' => 'Admin Confirmed Order (Send Order to Factory)'));

// case 18 Admin recharge Factory Account, then use it(stone)
begin_test();
$factory_account = $factory->account();
$admin->rechargeAccount($factory_account, 30000, 'hello');
$factory_st_account = $factory->stAccount();
$admin->rechargeAccount($factory_st_account, 2.8, 'hellzz');

// 注意，这里有问题，
// 凡是和账户相关的time，都应该有个timestamp不然不能确定准确的执行时间
// 但是，即使是time()依然是以秒为单位的
//sleep(1);
$remark = 'hellozze';
$weight = 2.1;
$num = 3;
$admin->useStoneForOrder($factory, $order, $weight, $num, $remark);
$admin->payFactoryForOrder($factory, $order, 3000, 'remark');
test(1, 1, array('name' => 'Admin recharge Factory Account, then use it(stone)'));

// case 19 Admin add Customer
$info = array(
    'username' => 'test_cuser',
    'password' => 'password',
    'realname' => '小三',
    'phone' => '1392910065',
    'qq' => '2981793048',
    'email' => 'cumt.xao@gmail.com',
    'address' => '北京某地',
    'remark' => '这个备注是干啥的？');
$admin->addCustomer($info);
test(1, 1, array('name' => 'Admin add Customer'));

// case 16 Statistics
// begin_test();
// $date = new DateTime();
// $interval = new DateInterval('P1D');
// $day_count = 500;
// for ($i=1; $i < $day_count; $i++) { 
//     Pdb::insert(
//         array(
//             'order_no' => uniqid(),
//             'customer' => $customer->id,
//             'state' => 'Done',
//             'paid' => rand(3000, 8000),
//             'state' => 'Done',
//             'submit_time' => 'NOW()',
//             'done_time' => $date->format('Y-m-d H:i:s')),
//         Order::$table);
//     $date->sub($interval);
// }
// $data = Statistics::saleRecord(array('divide' => 'day'));
// test(count($data), 60, array('name' => 'Statistics'));
