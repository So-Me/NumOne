<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */
?>
<form>
    <label>交易时间：</label>
    <input type="text" name="time_start" value="<?= $time_start ?>">
    <input type="text" name="time_end" value="<?= $time_end ?>">
    <label>类型：</label>
    <?php $field_name = 'type'; include smart_view('widget.select') ?>
    <?php $field_name = 'sort'; $data = $sorts; $no_default = 1; include smart_view('widget.select') ?>
    <input type="submit" value="搜索">
</form>
