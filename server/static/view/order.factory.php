<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */
?>
<div class="title">选择工厂</div>
<form action="<?= ROOT ?>order" method="post">
    <input type="hidden" name="action" value="change_factory">
    <input type="hidden" name="target" value="<?= $order->id ?>">
    <div>
        <?php
        $field_name = 'factory_id';
        $no_default = 1;
        $data = $factories;
        include smart_view('widget.select');
        ?>
    </div>
    <input type="submit" value="确定" />
</form>
