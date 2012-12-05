<?php
!defined('IN_PTF') && exit('Access Denied');
/**
 * @file    chart2d
 * @author  ryan <cumt.xiaochi@gmail.com>
 * @created Jul 5, 2012 9:14:52 PM
 */

// 移除所有没有销量的日子（从开始）
foreach ($data as $k => $v) {
    if ($v['sum'] == 0) {
        unset($data[$k]);
    }
}
?>
<style type="text/css">
.curve {
}
.curve li {
    height: 10px;
    width: 8px;
    background-color: #aaa;
    margin: 1px;
    display: inline-block;
}
.curve li:hover {
    background-color: #777;
}
.base-line {
    border-top: 1px solid #777;
}
</style>
<?php if ($data): ?>
    <?php 
    $max_view_height = 300; // px
    $sum_arr = array_map(function ($arr) {
        return $arr['sum'];
    }, $data);
    $max = max($sum_arr);
    if ($max === 0) {
        $max = 1;
    }
    $ratio = $max_view_height * 1.0 / $max;
    $sum = array_sum($sum_arr);
    ?>
    <ul class="curve" style="height: <?php echo $max_view_height+70; ?>px">
        <?php foreach ($data as $entry): ?>
            <?php  
            $value = $entry['sum'];
            $height = $value * $ratio;
            $height++;
            $pos = - $max_view_height + $height;
            $title = $entry['date'] . "\n订单：" . $entry['count'] . "个\n金额：" . $value . "元";
            ?>
            <li title="<?= $title ?>" style="height:<?= (int)$height ?>px"></li>
        <?php endforeach; ?>
    </ul>
    <div class="base-line"></div>
<?php else: ?>
    <div>还没有数据</div>
<?php endif ?>
