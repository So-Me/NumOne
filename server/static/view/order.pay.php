<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */
?>
<h4>填写客户付款情况</h4>
<div>
    <span>订单号：</span>
    <span><?= $order->order_no ?></span>
    <span>姓名：</span>
    <span><?= $cus->user()->name ?></span>
    <span>名称：</span>
    <span><?= $order->product()->name ?></span>
</div>
<div>
    帐户余额：
    <?= $account->remain ?>
    ，应收
    <?= $should_pay ?>
    ，已收
    <?= $paid ?>
    ，未收
    <?= $unpaid ?>
</div>
<form action="<?= ROOT . 'order/' . $order_id ?>" method="post">
    <input type="hidden" name="a" value="deduct">
    <div>
        <label>扣款金额：</label>
        <input type="text" name="deduct" value="" class="required" >
        <span>* 请填写数值</span>
    </div>
    <label>备注说明：</label>
    <textarea name="remark"></textarea>
    <input type="submit" value="确定" />
</form>
