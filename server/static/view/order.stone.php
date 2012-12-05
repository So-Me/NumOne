<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */
?> 
<div>填写主石信息</div>
<form action="<?= ROOT ?>order" method="post">
    <input type="hidden" name="action" value="edit_stone" /> 
    <input type="hidden" name="target" value="<?= $order_id ?>" /> 
    <div>
        <label for="weight">重量：</label>
        <input type="text" name="weight" id="weight" value="<?= $stone->weight ?>" />
        <label for="cut">切工：</label>
        <input type="text" name="cut" id="cut" value="<?= $stone->cut ?>" />
    </div>
    <div>
        <label for="color">颜色：</label>
        <input type="text" name="color" id="color" value="<?= $stone->color ?>" />
        <label for="polish">抛光：</label>
        <input type="text" name="polish" id="polish" value="<?= $stone->polish ?>" />
    </div>
    <div>
        <label for="clarity">净度：</label>
        <input type="text" name="clarity" id="clarity" value="<?= $stone->clarity ?>" />
        <label for="symmetry">对称：</label>
        <input type="text" name="symmetry" id="symmetry" value="<?= $stone->symmetry ?>" />
    </div>
    <div>
        <label for="certificate">证书：</label>
        <input type="text" name="certificate" id="certificate" value="<?= $stone->certificate ?>" />
        <label for="no">证书号：</label>
        <input type="text" name="no" id="no" value="<?= $stone->no ?>" />
    </div>
    <div>
        <label for="remark">备注：</label>
        <input type="text" name="remark" id="remark" value="<?= $stone->remark ?>" />
    </div>
    <input type="submit" value="确定">
</form>
