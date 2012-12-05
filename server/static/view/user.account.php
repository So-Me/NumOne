<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */
?>
<?php include smart_view('account.search'); ?>
<div>
    <span>账户：</span>
    <span><?= $user_->name ?></span>
    <span>用户名：</span>
    <span><?= $user_->realname ?></span>
    <span>账户余额：</span>
    <span><?= $account->remain ?></span>
    <button class="recharge-btn" data-id="<?= $target ?>">用户充值</button>
</div>
<?php include smart_view('paging'); ?>
<table>
    <tr>
        <td>交易时间</td>
        <td>名称</td>
        <td>相关订单</td>
        <td>金额（元）</td>
        <td>类型</td>
        <td> 账户余额（元）</td>
        <td>支付方式</td>
        <td>备注</td>
    </tr>
    <?php foreach ($history as $entry): ?>
        <?php if ($entry->order) {
            $order_no = $entry->order()->bigOrder()->sn;
        } else {
            $order_no = '';
        } ?>
        <tr>
            <td><?= $entry->time ?></td>
            <td><?= $entry->name ?></td>
            <td><a href="<?= ROOT . 'order?order_no=' . $order_no ?>"><?= $order_no ?></a></td>
            <td><?= $entry->type === 'consume' ? '-' : '' ?><?= $entry->money ?></td>
            <td><?= $entry->type ?></td>
            <td><?= $entry->remain ?></td>
            <td><?= $entry->pay_type ?></td>
            <td><?= $entry->remark ?></td>
        </tr>
    <?php endforeach ?>
</table>
