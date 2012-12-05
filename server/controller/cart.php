<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

if ($user_type !== 'Customer')
    exit('no permission');

if ($by_ajax) {
    switch ($action) {
        case 'add':
            $id = _req('id');
            $material = _req('material');
            $size = _req('size');
            $carve_text = _req('carveText');

            $customer->addProductToCart(
                new Product($id),
                compact(
                    'material',
                    'size',
                    'carve_text'));
            $cart = $customer->cart();
            echo $cart->count();
            exit;
        
        case 'del':
            $id = _req('id');
            $customer->delProductFromCart(new Order($id));
            echo $customer->cart()->count();
            exit;

        default:
            throw new Exception("nuknow action: $action");
            break;
    }
} else {
    $cart = $customer->cart();
    $orders = $cart->orders();
    $orders_count = count($orders);
    $addresses = $customer->addresses();

    if ($orders_count > 0) {
        $labor_expense = Setting::get('labor_expense');
        $wear_tear = Setting::get('wear_tear');
    }
}

if ($by_post) {
    $customer->submitCart();
    redirect('order/tobeconfirmed');
}

$view .= '?master';

$page['scripts'][] = 'jquery.form';
