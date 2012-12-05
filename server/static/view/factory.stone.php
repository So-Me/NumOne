<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */
?>
<?php include smart_view('account.search'); ?>
<div>
    <span>工厂名称：</span>
    <span><?= $factory->name ?></span>
    <span>联系人：</span>
    <span><?= $factory->contact ?></span>
    <span>账户余额：</span>
    <span><?= $account->remain ?></span>
    <button class="supply-btn" data-id="<?= $target ?>">英格供料</button>
</div>
<?php include smart_view('paging'); ?>
<table data-id="<?= $factory->id ?>">
    <tr>
        <td>交易时间</td>
        <td>名称</td>
        <td>相关订单</td>
        <td>重量（ct）</td>
        <td>数量</td>
        <td>类型</td>
        <td>支付方式</td>
        <td>剩余辅石（ct）</td>
        <td>备注</td>
    </tr>
    <?php $st_type_map = $config['st_type']; ?>
    <?php foreach ($history as $entry): ?>
        <?php $order_no = $entry->order ? $entry->order()->bigOrder()->sn : ''; ?>
        <tr>
            <td><?= $entry->time ?></td>
            <td><?= $entry->name ?></td>
            <td><a href="<?= ROOT . 'order?order_no=' . $order_no ?>"><?= $order_no ?></a></td>
            <td><?= $entry->type === 'consume' ? '-' : '' ?><?= $entry->money ?></td>
            <td><?= $entry->num ?></td>
            <td><?= $st_type_map[$entry->type] ?></td>
            <td><?= $entry->pay_type ?></td>
            <td><?= $entry->remain ?></td>
            <td><?= $entry->remark ?></td>
        </tr>
    <?php endforeach ?>
</table>
