<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

$final = $order->priceData('factory')->finalPrice();
$unpay = $final - $order->paid_factory;
?>
<div class="title">给订单打款</div>
<div>
    <span>工厂：</span>
    <span><?= $factory->name ?></span>
    <span>联系人：</span>
    <span><?= $factory->contact ?></span>
</div>
<div>
    <span>订单号：</span>
    <span><?= $order->bigOrder()->sn ?></span>
    <span>订单金额：</span>
    <span><?= $final ?>元</span>
</div>
<div>
    <span>未结清：</span>
    <span><?= $unpay ?>元</span>
</div>
<form method="post">
    <input type="hidden" name="action" value="pay">
    <input type="hidden" name="target" value="<?= $factory->id ?>">
    <input type="hidden" name="order" value="<?= $order->id ?>">
    <div>
        <label for="money">打款：</label>
        <input type="text" name="money" id="money">
        <span>元</span>
    </div>
    <div>
        <label for="remark">备注：</label>
        <input type="text" name="remark" id="remark">
    </div>
    <input type="submit" value="确定">
</form>
