<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */
?>
<h3 class="title"><?= $title ?></h3>
<form method="post" action="<?= ROOT . 'order' ?>">
    <input type="hidden" name="action" value="change_price">
    <input type="hidden" name="target" value="<?= $order_id ?>">
    <input type="hidden" name="type" value="<?= $type ?>">

    <span>订单号： <?= $order->bigOrder()->sn ?></span>
    <span>姓名：<?= $order->customer()->user()->name ?></span>
    <span>工厂名称：<?= $order->factory()->name ?></span>
    <?php $price = $order->priceData($type); ?>
    <div>
        <?php 
        $cal_price = $price->finalPrice();
        $real_price = $order->real_price;
        ?>
        <span>合计价格：</span>
        <span><?= fp($cal_price) ?></span>
        <?php if ($type === 'Customer'): ?>
            <span>实际价格：</span>
            <input type="text" name="real_price" value="<?= fp($real_price) ?>">
            <span>优惠</span>
            <span><?= fp($cal_price - $real_price) ?></span>
        <?php endif ?>
    </div>
    <div class="box-container">
        <div class="box">
            <?php 
            $gold_weight = $price->gold_weight;
            $wear_tear = $price->wear_tear;
            $gold_price = $price->gold_price;
            ?>
            <div class="total1"><?= ($gold_weight + $gold_weight * $wear_tear / 100.0) * $gold_price ?></div>
            <div>
                <label for="gold_weight">金重：</label>
                <input type="text" value="<?= $gold_weight ?>" name="gold_weight" id="gold_weight" class="required" />
            </div>
            <div>
                <label for="wear_tear">损耗：</label>
                <input type="text" value="<?= $wear_tear ?>" name="wear_tear" id="wear_tear" class="required" />
                <span>%</span>
            </div>
            <div>
                <label for="gold_price">金价：</label>
                <input type="text" value="<?= $gold_price ?>" name="gold_price" id="gold_price" class="required" />
            </div>
        </div>
        <div>(金重+金重*损耗）*金价</div>
    </div>
    <div class="box-container">
        <div class="box">
            <?php 
            $labor_expense = $price->labor_expense;
            $small_stone = $price->small_stone;
            $st_expense = $price->st_expense; ?>
            <div class="total2"><?= $labor_expense + $small_stone * $st_expense ?></div>
            <div>
                <label for="labor_expense">工费：</label>
                <input type="text" value="<?= $labor_expense ?>" name="labor_expense" id="labor_expense" class="required" />
            </div>
            <div>
                <label for="small_stone">辅石数量：</label>
                <input type="text" value="<?= $small_stone ?>" name="small_stone" id="small_stone" class="required" />
            </div>
            <div>
                <label for="st_expense">辅石工费：</label>
                <input type="text" value="<?= $st_expense ?>" name="st_expense" id="st_expense" class="required" />
            </div>
        </div>
        <div>工费+辅石数量*辅石工费</div>
    </div>
    <div class="box-container">
        <?php 
        $st_price = $price->st_price;
        $st_weight = $price->st_weight; ?>
        <div class="box">
            <div class="total3"><?= $st_price * $st_weight ?></div>
            <div>
                <label for="st_price">辅石价：</label>
                <input type="text" value="<?= $st_price ?>" name="st_price" id="st_price" class="required" />
            </div>
            <div>
                <label for="st_weight">辅石重量：</label>
                <input type="text" value="<?= $st_weight ?>" name="st_weight" id="st_weight" class="required" />
            </div>
        </div>
        <div>辅石价*重量</div>
    </div>
    <div class="box-container">
        <?php 
        $model_expense = $price->model_expense;
        $risk_expense = $price->risk_expense; ?>
        <div class="box">
            <div class="total4"><?= $model_expense + $risk_expense ?></div>
            <div>
                <label for="model_expense">起版费：</label>
                <input type="text" value="<?= $model_expense ?>" name="model_expense" id="model_expense" class="required" />
            </div>
            <div>
                <label for="risk_expense">风险费：</label>
                <input type="text" value="<?= $risk_expense ?>" name="risk_expense" id="risk_expense" class="required" />
            </div>
        </div>
        <div>版费+风险费</div>
    </div>
    <?php if ($type === 'Factory'): ?>
        <div class="more-info">
            其中，本单使用英格提供的辅石
            <input name="factory_st" value="<?= $order->factory_st ?>" class="required" />
            粒，共
            <input name="factory_st_weight" value="<?= $order->factory_st_weight ?>" class="required" />
            克拉
        </div>
    <?php elseif ($type === 'Customer'): ?>
        <div class="more-info">
            <span>客户下单当天的金价为</span>
            <span>PT950：<?= Price::get('PT950', $order->submit_time) ?>元/克</span>
            <span>AU750：<?= Price::get('AU750', $order->submit_time) ?>元/克</span>
        </div>
    <?php endif ?>
    <input type="submit" value="确定">
</form>
