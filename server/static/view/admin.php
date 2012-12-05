<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */
?>
<ul>
    <?php foreach ($admins as $admin): ?>
    <li>
        <strong><?= $admin->name ?></strong>
        <span>创建日期：<?= $admin->create_time ?></span>
    </li>
    <?php endforeach; ?>
</ul>
