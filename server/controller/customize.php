<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

$materials = $config['product_material_map'];

$material = _post('material');
$stone = _post('stone');
$size = _post('size');
$carve_text = _post('carve_text');
$remark = _post('remark');
$images = _post('image_input');
if (empty($images))
    $images = array();
$images = $images ? $images : array();

if ($by_post) {
    if ($_FILES['image']['name']) {
        $image = make_image($_FILES['image']);
        $images[] = $image;
    } elseif ($action === 'del_img') {
        $images = array_values($images);
    } else {
        $info = compact(
            'material',
            'stone',
            'size',
            'carve_text',
            'remark',
            'images');
        $customer->customizeOrder($info);
        redirect('order/all');
    }
}

$page['scripts'][] = 'jquery.validate.min';
$view = "$view?master";
