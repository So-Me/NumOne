<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */
if (!isset($div_name))
    $div_name = str_replace('.', '-', $view_name);
$long_class_name = $div_name . '-append-div';
?>
<div class="<?= $div_name ?> append-div <?= $long_class_name ?>">
    <img src="<?= ROOT ?>static/img/close-btn.gif" class="close-btn">
    <?php include smart_view($view_name); ?>
</div>
