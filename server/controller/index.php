<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
/**
 * @file    index
 * @author  ryan <cumt.xiaochi@gmail.com>
 * @created Jun 27, 2012 6:24:01 PM
 */

if ($user_type === 'Admin') {
    redirect('order/all');
}
if ($user_type === 'SuperAdmin') {
    redirect('admin');
}

list(
    $name, 
    $no, 
    $stone_size,
    $type
) = _get(
    'name',
    'no',
    'stone_size',
    'type');

$mode = _get('mode') ?: 'list';

$cur_page = _get('p') ?: 1;

$page_num_map = array(
    'list' => 10,
    'image' => 24);

$per_page = $page_num_map[$mode];
$conds = compact(
    'name',
    'no',
    'stone_size',
    'type');
$total = Product::count($conds);
$paging = new Paginate($per_page, $total);
$paging->setCurPage($cur_page);

$products = Product::read(array_merge(
    $conds,
    array(
        'limit' => $per_page,
        'offset' => $paging->offset())));

$chosen_map = SesState::chosenProducts();

$types = Product::types();

$view .= '?master';

$page['scripts'][] = 'widget';
