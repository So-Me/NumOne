<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */
?>
<div>
<h2 class="user-Infor-title">请填写详细的用户信息</h2>
<form method="post" class="add">
    <div class="user-Infor-div">
        <label class="user-id">帐号：</label>
        <input name="username" type="name" value="<?= $username ?>" class="required user-Infor-input" />
    </div>
    <div class="user-Infor-div">
        <label class="user-password">密码：</label>
        <input name="password" type="name" value="<?= $password ?>" class="required user-Infor-input" />
    </div>
    <div class="user-Infor-div">
        <label class="user-compellation">姓名：</label>
        <input name="realname" type="name" value="<?= $realname ?>" class="required user-Infor-input" />
    </div>
    <div class="user-Infor-div">
        <label class="user-phone">联系电话：</label>
        <input name="phone" type="name" value="<?= $phone ?>" class="phone user-Infor-input" />
    </div>
    <div class="user-Infor-div">
        <label class="user-qq">QQ：</label>
        <input name="qq" type="name" value="<?= $qq ?>" class="qq user-Infor-input" />
    </div>
    <div class="user-Infor-div">
        <label class="user-email">邮箱：</label>
        <input name="email" type="name" value="<?= $email ?>" class="email user-Infor-input" />
    </div>
    <div class="user-Infor-div">
        <label class="user-adress">收件地址：</label>
        <input name="address" type="name" value="<?= $address ?>" class="user-Infor-input" />
    </div>
    <div class="user-Infor-div">
        <label class="user-remark">备注：</label>
        <input name="remark" type="name" value="<?= $remark ?>" class="user-Infor-input" />
        <span>客户不可见</span>
    </div>
    <input class="mbtn" type="submit" value="确定" />
</form>
</div>
