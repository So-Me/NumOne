<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */
?>
<h3 class="title">实际价格组成明细</h3>
<input type="hidden" name="a" value="change_price">
<input type="hidden" name="type" value="<?= $type ?>">
<span class="pri-info">订单号： <?= $order->bigOrder()->sn ?></span>
<span class="pri-info">姓名：<?= $order->customer()->user()->name ?></span>
<span class="pri-info">名称：<?= $order->product()->name ?></span>
<span class="pri-info">材质：<?= $order->material ?></span>
<div class="total-price">
    <?php 
    $final_price = $price->finalPrice();
    $real_price = $order->real_price;
    ?>
    <span>合计价格：</span>
    <span class="num"><?= fp($real_price) ?>元</span>
    <span class="more">(原价：<?= fp($final_price) ?>元，已优惠<?= fp($final_price - $real_price) ?>元)</span>
</div>
<div class="box-wrap gold">
    <div class="total b">￥<?= $price->gold_weight * (1 + 1.0 * $price->wear_tear / 100) * $price->gold_price ?></div>
    <div class="box b">
        <div class="b">
            <span for="gold_weight">金重：</span>
            <span><?= $price->gold_weight ?></span>
        </div>
        <div class="b">
            <span for="wear_teaar">损耗：</span>
            <span><?= $price->wear_tear ?></span>
        </div>
        <div class="b">
            <span for="gold_price">金价：</span>
            <span><?= $price->gold_price ?></span>
        </div>
    </div>
    <div class="explain">(金重+金重*损耗）*金价</div>
</div>
<div class="box-wrap labor">
    <?php 
    $labor_expense = $price->labor_expense; 
    $small_stone = $price->small_stone;
    $st_expense = $price->st_expense;
    ?>
    <div class="total b">￥<?= $labor_expense + $small_stone * $st_expense ?></div>
    <div class="box b">
        <div class="b">
            <span for="labor_expense">工费：</span>
            <span><?= $labor_expense ?></span>
        </div>
        <div class="b">
            <span for="small_stone">辅石数量：</span>
            <span><?= $small_stone ?></span>
        </div>
        <div class="b">
            <span for="st_expense">辅石工费：</span>
            <span><?= $st_expense ?></span>
        </div>
    </div>
    <div class="explain">工费+辅石数量*辅石工费</div>
</div>
<div class="box-wrap small-stone">
    <?php  
    $st_price = $price->st_price;
    $st_weight = $price->st_weight;
    ?>
    <div class="total b">￥<?= $st_price * $st_weight ?></div>
    <div class="box b">
        <div class="b">
            <span for="st_price">辅石价：</span>
            <span><?= $st_price ?></span>
        </div>
        <div class="b">
            <span for="st_weight">辅石重量：</span>
            <span><?= $st_weight ?></span>
        </div>
    </div>
    <div class="explain">辅石价*重量</div>
</div>
<div class="box-wrap others">
    <?php  
    $model_expense = $price->model_expense;
    $risk_expense = $price->risk_expense;
    ?>
    <div class="total b">￥<?= $model_expense + $risk_expense ?></div>
    <div class="box b">
        <div class="b">
            <span for="model_expense">起版费：</span>
            <span><?= $model_expense ?></span>
        </div>
        <div class="b">
            <span for="risk_expense">风险费：</span>
            <span><?= $risk_expense ?></span>
        </div>
    </div>
    <div class="explain">版费+风险费</div>
</div>
<div class="more-info">
    <span>客户下单当天的金价为</span>
    <span class="pt950">PT950：<?= Price::get('PT950', $order->submit_time) ?>元/克</span>
    <span class="au750">AU750：<?= Price::get('AU750', $order->submit_time) ?>元/克</span>
</div>
