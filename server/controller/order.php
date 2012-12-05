<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

// search form var
list($name, $product_no, $order_no, $type, $time_start, $time_end, $state) 
    = _get('name', 'product_no', 'order_no', 'type', 'time_start', 'time_end', 'state');

if (!isset($_GET['state']))
    $state = $target;
if ($state === 'all')
    $state = '';

$conds = compact(
    'name',
    'product_no',
    'order_no',
    'time_start',
    'time_end',
    'type',
    'state');

$types = Product::types();
$state_map = $config['order_states'];
$next_action_map = $config['order_next_action'];
$next_button_map = $config['next_button_map'];

switch ($user_type) {
    case 'Customer':

        if ($by_ajax && is_numeric($target)) {
            $order_id = $target;
            $order = new Order($order_id);
            switch ($action) {
                case 'change_remark':
                    $remark = _post('remark');
                    if ($remark) {
                        $customer->changeOrderRemark($order, $remark);
                    }
                    echo $order->customer_remark;
                    exit;

                case 'get_price_detail_div':
                    if ($order->customer_price) {
                        $price = $order->priceData('customer');
                        $view_name = 'order.price';
                        include smart_view('append.div');
                    }
                    exit;
                
                default:
                    throw new Exception("unkown action: $action");
                    break;
            }
        }

        $customer = $customer->id; // for next
        break;

    case 'Admin':
    case 'SuperAdmin':
        $factories = Factory::names();

        // get some divs
        if ($by_ajax && is_numeric($target) && preg_match('/get_.+_div/', $action)) {
            include FrameFile::controller('order.get_div');
            exit;
        }

        // 对订单的操作，通过表单post过来的
        if ($action && $by_post && is_numeric($target)) {
            include FrameFile::controller('order.control');
            exit;
        }

        list($customer, $username, $factory) 
            = _get('customer', 'username', 'factory');
        $conds = array_merge(
            $conds,
            compact('username', 'factory'));

        $page['styles'][] = 'admin';
        break;
    
    default:
        throw new Exception("unkown user type: $user_type");
        break;
}
$conds['customer'] = $customer;

$per_page = 50;
$total = BigOrder::count($conds);
$paging = new Paginate($per_page, $total);
$paging->setCurPage(_get('p') ?: 1);
$big_orders = BigOrder::read(array_merge(
    array(
    'limit' => $per_page,
    'offset' => $paging->offset()),
    $conds));

// we don't need these two lines
if (empty($orders)) 
    $orders = array();

$matter = $view;
$view = 'board?master';

$page['scripts'][] = 'jquery.validate.min';
$page['scripts'][] = 'widget';
