<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

if ($by_ajax && $action === 'get_price') {
    $prd = new Product($target);
    $material = _get('material');
    echo fp($prd->estimatePrice(compact('material')));
    exit;
}

if ($user_type !== 'Admin')
    die('you should be Admin');

if ($by_ajax) {
    switch ($action) {
        case 'del':
            $ids = _get('ids');
            $ids = json_decode($ids);
            $admin->delProduct($ids);
            exit;
            break;

        default:
            throw new Exception("unkown action: $action");
            break;
    }
}

$types = Product::types();
switch ($target) {
    case '':
        list(
            $name,
            $no,
            $type,
            $sort1,
            $sort2) = _get(
                'name',
                'no',
                'type',
                'sort1',
                'sort2');

        $sort = $sort1 ? $sort1 . ' ' . $sort2 : '';

        $p = _get('p') ?: 1;
        $per_page = 50;
        $total = Product::count(array(
            'name' => $name,
            'no'   => $no,
            'type' => $type));
        $paging = new Paginate($per_page, $total);
        $paging->setCurPage($p);
        $products = Product::read(array(
            'limit' => $per_page,
            'offset' => $paging->offset(),
            'name' => $name,
            'no'   => $no,
            'type' => $type,
            'sort' => $sort));
        break;
    case 'post':

        $types = Product::types();
        $brands = Product::brands();

        list(
            $name,
            $no,
            $type,
            $material,
            $weight,
            $rabbet_start,
            $rabbet_end,
            $small_stone,
            $st_weight,
            $remark
        ) = _post(
            'name',
            'no',
            'type',
            'material',
            'weight',
            'rabbet_start',
            'rabbet_end',
            'small_stone',
            'st_weight',
            'remark');
        $is_brand = _post('is_brand') ? 1 : 0;
        $brand = _post('brand');

        $image1 = _post('image1');
        $image1_400 = _post('image1_400');
        $image1_thumb = _post('image1_thumb');
        $image2 = _post('image2');
        $image2_400 = _post('image2_400');
        $image2_thumb = _post('image2_thumb');
        $image3 = _post('image3');
        $image3_400 = _post('image3_400');
        $image3_thumb = _post('image3_thumb');

        $material = _post('material');
        $materials = $material ?: array();
        $material = json_encode($materials);

        if ($by_post) {

            $img_names = array(
                'image1',
                'image2',
                'image3');
            foreach ($img_names as $img_name) {
                if ($_FILES[$img_name]['name']) {

                    $uploading = 1;

                    // upload
                    $$img_name = make_image($_FILES[$img_name]); // orgin

                    // big
                    ${$img_name . '_400'} = make_image(
                        $_FILES[$img_name],
                        array(
                            'crop' => 1,
                            'resize' => 1,
                            'width' => 400,
                            'height' => 400));

                    // thumb
                    ${$img_name . '_thumb'} = make_image(
                        $_FILES[$img_name],
                        array(
                            'crop' => 1,
                            'resize' => 1,
                            'width' => 80,
                            'height' => 80));
                }
            }

            if (!isset($uploading)) {
                $info = compact(
                    'name',
                    'no',
                    'type',
                    'weight',
                    'rabbet_start',
                    'rabbet_end',
                    'material',
                    'small_stone',
                    'st_weight',
                    'is_brand',
                    'remark',
                    'image1',
                    'image1_400',
                    'image1_thumb',
                    'image2',
                    'image2_400',
                    'image2_thumb',
                    'image3',
                    'image3_400',
                    'image3_thumb');
                if ($is_brand) {
                    $info['brand'] = $brand;
                }
                $admin->postProduct($info);
                
                redirect('product');
            }
        }
        break;
    case 'batch':
        break;
    
    default:
        throw new Exception("unkown: $target");
        break;
}

$matter = $view . ($target ? '.' . $target : '');
$view = 'board?master';

$page['scripts'][] = 'jquery.validate.min';
$page['scripts'][] = 'widget';
