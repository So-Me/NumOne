<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

switch ($target) {
    case 'gold_price':
        $time_start = _get('time_start');
        $time_end = _get('time_end');
        $type = _get('type');

        $material_types = $config['material_type_map'];

        $p = _get('p') ?: 1;
        $per_page = 50;
        $total = Price::total($type);
        $paging = new Paginate($per_page, $total);
        $paging->setCurPage($p);
        $prices = Price::history(array(
            'type' => $type,
            'limit' => $per_page,
            'offset' => $paging->offset()));
        break;

    case 'sale':
        $divide = _get('divide') ?: 'day'; // day or month

        $format_map = array(
            'day' => 'Y年m月d日',
            'month' => 'Y年m月');

        $data = Statistics::saleRecord(compact('divide'));
        $date = new DateTime();
        $format = $format_map[$divide];
        $date->sub(DateInterval::createFromDateString("1 $divide"));
        $end = $date->format($format);
        $date->sub(DateInterval::createFromDateString("59 $divide"));
        $start = $date->format($format);
        break;

    case '':
        if ($by_ajax && $action === 'get_post_gold_price_div') {
            $view_name = 'gold.price.post';
            include smart_view('append.div');
            exit;
        }

        if ($by_post && $action === 'post_gold_price') {

            $name_map = array(
                'PT950',
                'AU750',
                'PT990',
                'AU990');

            foreach ($name_map as $name) {
                $price = _post($name);
                $en = _post('en' . $name);
                if ($en && $price) {
                    $admin->updatePrice($name, $price);
                }
            }
            redirect('statistics/gold_price');
            exit;
        }
        break;
    
    default:
        throw new Exception("unkown target: $target");
        break;
}


$matter = $view . '.' . $target;
$view = 'board?master';
