<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */
?>
<h4>修改订单信息</h4>
<div>
    <span>订单号：</span>
    <span><?= $order->order_no ?></span>
    <span>姓名：</span>
    <span><?= $cus->user()->name ?></span>
    <span>名称：</span>
    <span><?= $product->name ?></span>
</div>
<form action="<?= ROOT . 'order/' . $order_id ?>" method="post">
    <input type="hidden" name="a" value="edit_order">
    <div>
        <label>材质：</label>
        <?php 
        $field_name = 'material';
        $material = $order->material;
        include smart_view('widget.select') 
        ?>
        <label>手寸：</label>
        <?php $size = $order->size ?>
        <select name="size">
            <?php foreach (range(7, 19) as $i): ?>
                <option <?= $size == $i ? 'selected' : '' ?> ><?= $i ?></option>
            <?php endforeach ?>
        </select>
    </div>
    <div>
        <label>刻字：</label>
        <input name="carve_text" type="text" value="<?= $order->carve_text ?>">
    </div>
    <div>
        <label>备注：</label>
        <input name="customer_remark" type="text" value="<?= $order->customer_remark ?>">
        <span>客户可见</span>
    </div>
    <input type="submit" value="确定">
</form>
