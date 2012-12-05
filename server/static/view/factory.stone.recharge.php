<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */
?> 
<h4>英格供料</h4>
<div>
    <span>工厂：</span>
    <span><?= $factory->name ?></span>
    <span>客户名：</span>
    <span><?= $factory->contact ?></span>
</div>
<div>
    <span>余料：</span>
    <span><?= $account->remain ?>ct</span>
</div>
<form action="<?= ROOT ?>factory" method="post">
    <input type="hidden" name="action" value="recharge_stone">  
    <input type="hidden" name="target" value="<?= $factory->id ?>">  
    <div>
        <label for="weight">供料：</label>
        <input type="text" name="weight" id="weight" />
        <span>ct</span>
    </div>
    <div>
        <label for="remark">备注：</label>
        <input type="text" name="remark" id="remark" />
    </div>
    <input type="submit" value="确定" />
</form>
