<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */
?> 
<h4>用户账户充值</h4>
<div>
    <span>帐号：</span>
    <span><?= $user_->name ?></span>
    <span>客户名：</span>
    <span><?= $user_->realname ?></span>
</div>
<div>
    <span>余额：</span>
    <span><?= $account->remain ?>元</span>
</div>
<form action="<?= ROOT ?>user" method="post">
    <input type="hidden" name="action" value="recharge">  
    <input type="hidden" name="target" value="<?= $cus->id ?>">  
    <div>
        <label for="money">充值：</label>
        <input type="text" name="money" id="money" />
        <span>元</span>
    </div>
    <div>
        <label for="remark">备注：</label>
        <input type="text" name="remark" id="remark" />
    </div>
    <input type="submit" value="确定" />
</form>


