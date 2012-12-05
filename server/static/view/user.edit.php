<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */
?>
<h4 class="title">审核用户</h4>
<form action="<?= ROOT . 'user/' . $cus_id ?>" method="post">
    <input type="hidden" name="a" value="edit">
    <div>
        <label for="username">帐号：</label>
        <input name="username" id="username" value="<?= $user_->name ?>">
        <label for="password">修改密码：</label>
        <input name="password" id="password">
    </div>
    <div>
        <label for="realname">姓名：</label>
        <input name="realname" id="realname" value="<?= $user_->realname ?>">
        <label for="phone">电话：</label>
        <input name="phone" id="phone" value="<?= $user_->phone ?>">
    </div>
    <div>
        <label for="qq">QQ：</label>
        <input name="qq" id="qq" value="<?= $cus->qq ?>">
        <label for="email">邮箱：</label>
        <input name="email" id="email" value="<?= $user_->email ?>">
    </div>
    <div>
        <label for="address">地址：</label>
        <input name="address" id="address" value="<?= $cus->defaultAddress()->detail ?>">
    </div>
    <div>
        <label for="remark">备注：</label>
        <input name="remark" id="remark" value="<?= $cus->remark ?>">
        <span>客户不可见</span>
    </div>
    <div>
        <label for="">状态：</label>
        <?php 
        $state = $cus->state;
        widget('select', array(
            'field_name' => 'state',
            'no_default' => true,
            'data' => $customer_states)) ?>
    </div>
    <input type="submit" value="确定">
</form>
