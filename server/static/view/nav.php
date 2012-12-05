<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

// 左边栏导航

?>
<dl class="main-nav">
    <?php foreach ($navs as $top_key => $sub): ?>
        <dt><a href="<?= ROOT . $top_key . '/' . $sub['default'] ?>"><?= $sub['title'] ?></a></dt>
        <?php foreach ($sub['sub'] as $entry): $link = $entry['link']; ?>
            <dd class="<?= ($top_key == $controller && $target == $link) ? 'on' : '' ?>"><a href="<?= ROOT . $top_key . '/' . $link ?>"><?= $entry['name'] ?></a></dd>
        <?php endforeach ?>
    <?php endforeach ?>
</dl>
