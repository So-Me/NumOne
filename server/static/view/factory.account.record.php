<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */
?>
<ol>
    <?php foreach ($records as $entry): ?>
        <li>
            <span><?= $entry['time'] ?></span>
            <span>打款<?= $entry['money'] ?>元</span>
            <span>备注：<?= $entry['remark'] ?></span>
        </li>
    <?php endforeach ?>
</ol>
