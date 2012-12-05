<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */
?>
<div class="detail-info">
    <div class="address">
        <?php $address = $cus->defaultAddress() ?>
        <h4>收件人信息</h4>
        <div><?= $address->name ?> <?= $address->phone ?></div>
        <div><?= $address->detail ?></div>
    </div>
    <div class="log">
        <h4>订单处理日志</h4>
        <?php if ($user_type == 'Admin'): ?>
            <span>跟进&nbsp;&gt;</span>
        <?php endif ?>
        <?php $order_log = $order->log(); ?>
        <?php foreach ($order_log as $entry): ?>
            <div class=""><?= $entry['time'] ?> <?= $entry['remark'] ?></div>
        <?php endforeach ?>
    </div>
    <br class="clear-fix" />
</div>
