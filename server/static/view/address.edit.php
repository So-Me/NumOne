<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */
?>
<div>修改地址</div>
<form action="<?= ROOT ?>address" method="post">
    <input type="hidden" name="action" value="edit" /> 
    <input type="hidden" name="target" value="<?= $addr_id ?>" /> 
    <div>
        <label for="name">姓名：</label>
        <input name="name" type="text" value="<?= $address->name ?>">
    </div>
    <div>
        <label for="phone">电话：</label>
        <input name="phone" type="text" value="<?= $address->phone ?>">
    </div>
    <div>
        <label for="detail">地址：</label>
        <input name="detail" type="text" value="<?= $address->detail ?>">
    </div>
    <input type="submit" value="确定">
</form>
