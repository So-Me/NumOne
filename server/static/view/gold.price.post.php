<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */
?>
<div class="title">发布金价</div>
<form action="<?= ROOT ?>statistics" method="post">
    <input type="hidden" name="action" value="post_gold_price">
    <div>
        <span>
            <input type="checkbox" name="enPT950" checked>
            <label>PT950</label>
            <input type="text" name="PT950">
        </span>
        <span>
            <input type="checkbox" name="enAU750" checked>
            <label>AU750</label>
            <input type="text" name="AU750">
        </span>
    </div>
    <div>
        <span>
            <input type="checkbox" name="enPT990" >
            <label>PT990</label>
            <input type="text" name="PT990">
        </span>
        <span>
            <input type="checkbox" name="enAU990" >
            <label>AU990</label>
            <input type="text" name="AU990">
        </span>
    </div>
    <input type="submit" value="确定">
</form>
