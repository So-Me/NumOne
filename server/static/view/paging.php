<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

$min = $paging->viewMin();
$max = $paging->viewMax();
$cur_page = $paging->curPage();
$href_prefix = $paging->hrefPrefix();
?>
<?php if ($paging->maxPage() > 1): ?>
<div class="paging">
    <?php if (!$paging->startCanShow()): ?><span class="ommision">...</span><?php endif; ?>
    <?php for ($i = $min; $i <= $max; $i++): ?>
        <a class="num btn <?= $i == $cur_page? 'on' : '' ?>" href="?<?= $href_prefix . $i ?>"><?= $i ?></a>
    <?php endfor; ?>
    <?php if ($paging->reachEnd()): ?><span class="ommision">...</span><?php endif; ?>
    <?php if (!$paging->endCanShow()): ?><a href="?<?= $href_prefix . ($cur_page + 1) ?>" data-p="<?= $cur_page+1 ?>" class="next-page-btn btn">下一页</a><?php endif; ?>
    <br class="clear-fix" />
</div>
<?php endif; ?>
