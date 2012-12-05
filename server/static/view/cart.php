<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */
?>
<div class="indicator">
    <span>1、选购货品</span>
    <span class="sep"></span>
    <span class="on">2、核对货品及收件地址</span>
    <span class="sep"></span>
    <span>3、提交订单</span>
</div>
<div class="title">
    <h2>我的购物车</h2>
    <a href="<?= ROOT ?>">&lt;&lt;返回继续选购</a>
</div>
<?php if ($orders_count): ?>
    <h3>确认订单信息</h3>
    <div class="table-title-row">
        <span class="col name title">货品名称</span>
        <span class="col e-info title">详细参数</span>
        <span class="col num title">数量</span>
        <span class="col price title">英格预估价</span>
        <span class="col del title">删除</span>
    </div>
    <?php foreach ($orders as $order): ?>
        <?php $prd = $order->product(); ?>
        <div class="product-entry" data-id="<?= $order->id ?>">
            <div class="row" >
                <div class="col name">
                    <div class="image-wrap">
                        <img src="<?= $prd->image1_thumb ?>" />
                    </div>
                    <div class="text-wrap">
                        <span class="text"><?= $prd->name ?></span>
                        <span>货号：<?= $prd->no ?></span>
                    </div>
                </div>
                <div class="col e-info">
                    <div>
                        <span class="">材质：<?= $order->material ?></span>
                        <span class="e">手寸：<?= $order->size ?></span>
                        <span class="e">刻字：<?= $order->carve_text ?></span>
                        <span class="e">镶口：<?= $prd->rabbet_start ?>-<?= $prd->rabbet_end ?> ct</span>
                    </div>
                    <div>
                        <span class="">辅石：<?= $prd->small_stone ?>粒</span>
                        <span class="e">工费：<?= $labor_expense ?>元/件</span>
                        <span class="e">损耗：<?= $wear_tear ?>%</span>
                    </div>
                </div>
                <div class="col num">1</div>
                <div class="col price">
                    <div>￥<?= fp($order->estimate_price) ?></div>
                </div>
                <div class="col del">
                    <div class="popup">
                        <div>确定删除？</div>
                        <span class="ok-btn">确定</span>
                        <span class="cancel-btn">取消</span>
                    </div>
                    <span class="del btn">删除</span>
                </div>
            </div>
            <form class="remark" method="post" action="<?= ROOT ?>order">
                <input type="hidden" name="target" value="<?= $order->id ?>" />
                <input type="hidden" name="action" value="change_remark">
                <div class="remark">
                    <?php $customer_remark = $order->customer_remark; ?>
                    <span class="text-show"><?= $customer_remark ?: '填写备注信息&gt;' ?></span>
                    <input class="text-in" type="text" name="remark" placeholder="填写备注信息&gt;" value="<?= $customer_remark ?>" />
                    <input type="submit" class="mbtn" value="确定">
                </div>
            </form>
        </div>
    <?php endforeach ?>
    <div class="total-info">
        <span class="count">
            共计：
            <strong><?= $cart->count() ?>件</strong>
        </span>
        <span class="price">
            预估总价：
            <strong>￥<?= fp($cart->totalPrice()) ?></strong>
        </span>
    </div>
    <form method="post">
        <div class="addr-info">
            <span>请确认您的收件地址：</span>
            <span class="edit-addr-btn">编辑</span>
        </div>
        <?php foreach ($addresses as $addr): ?>
            <div class="addr">
                <input type="radio" name="address" value="<?= $addr->id ?>" id="addr<?= $addr->id ?>" data-id="<?= $addr->id ?>" checked />
                <label for="addr<?= $addr->id ?>"><?= $addr->name ?></label>
                <span><?= $addr->phone ?></span>
                <span><?= $addr->detail ?></span>
            </div>
        <?php endforeach ?>
        <input type="submit" value="提交订单" class="submit-btn" <?= ($orders_count == 0) ? 'disabled title="不可提交"' : '' ?> />
    </form>
<?php else: ?>
    <div class="empty-cart">Sorry,你的购物车还是空的哦...</div>
<?php endif ?>

