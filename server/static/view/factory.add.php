<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */
?>
<div>请填写详细的工厂信息</div>
<form method="post" class="add">
    <div>
        <label for="name">工厂名称：</label>
        <input name="name" type="text" value="<?= $name ?>" id="name" class="required" />
    </div>
    <div>
        <label for="contact">联系人：</label>
        <input name="contact" type="text" value="<?= $contact ?>" id="contact" class="required" />
    </div>
    <div>
        <label for="phone">联系电话：</label>
        <input name="phone" type="text" value="<?= $phone ?>" id="phone" class="required phone" />
    </div>
    <div>
        <label for="qq">QQ：</label>
        <input name="qq" type="text" value="<?= $qq ?>" id="qq" class="qq" />
    </div>
    <div>
        <label for="email">邮箱：</label>
        <input name="email" type="text" value="<?= $email ?>" id="email" class="email" />
    </div>
    <div>
        <label for="address">工厂地址：</label>
        <input name="address" type="text" value="<?= $address ?>" id="address" class="" />
    </div>
    <div>
        <label for="remark">备注：</label>
        <input name="remark" type="text" value="<?= $remark ?>" id="remark" class="" />
    </div>
    <input type="submit" value="确定" />
</form>
