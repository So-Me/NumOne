<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
?>
<div class="small-wrap">
    <div class="gold-price">
        <span class="lbl">今日金价</span>
        <span class="info">PT950: <?= fp(Price::current('PT950')) ?>元/克</span>
        <span class="info">AU750: <?= fp(Price::current('AU750')) ?>元/克</span>
    </div>
    <div class="account">
        <?php if ($has_login): ?>
            <?php if ($user_type === 'Customer'): ?>
                <span class="welcom">你好，<?= htmlspecialchars($user->name) ?></span>
                <?php if ($user_type === 'Customer'): ?>
                    <a class="cart" href="<?= ROOT ?>cart">购物车 (<span class="count"><?= $cart->count() ?></span>)</a>
                <?php endif; ?>
                <a href="<?= ROOT ?>order/all" class="my-order">我的订单</a>
            <?php else: ?>
                <span><?= htmlspecialchars($user->name) ?></span>
                <a href="<?= ROOT ?>order/all">管理中心</a>
            <?php endif ?>
            
            <a href="<?= ROOT ?>login?logout=1">注销</a>
        <?php else: ?>
            <a href="<?= ROOT ?>login?back=<?= $request_uri ?>">登录</a>
            <a href="<?= ROOT ?>register?back=<?= $request_uri ?>">注册</a>
        <?php endif; ?>
    </div>
</div>
<h1>
    <a href="<?= ROOT ?>" title="<?= $config['site']['name'] ?>">
        <img src="<?= ROOT ?>static/img/logo.png" alt="英格" title="回首页" />
    </a>
</h1>


