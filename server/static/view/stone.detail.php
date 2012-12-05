<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */
?>
<div>
    <span>重量：<?= $stone->weight ?>ct</span>
    <span>切工：<?= $stone->cut ?></span>
</div>
<div>
    <span>颜色：<?= $stone->color ?></span>
    <span>抛光：<?= $stone->polish ?></span>
</div>
<div>
    <span>净度：<?= $stone->clarity ?></span>
    <span>对称：<?= $stone->symmetry ?></span>
</div>
<div>
    <span>证书：<?= $stone->certificate ?></span>
    <span>证书号：<?= $stone->no ?></span>
</div>
<div>
    <span>备注：<?= $stone->remark ?></span>
</div>
