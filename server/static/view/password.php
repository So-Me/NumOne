<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */
?>
<div class="info">请妥善保存您的密码，以防被盗！</div>
<form method="post">
    <?php if ($msg): ?>
        <div class="msg"><?= $msg ?></div>
    <?php endif ?>
    <div>
        <label>原密码：</label>
        <input name="password" type="password" class="required ti">
        <span class="entry-info">*必须知道原密码才可以修改！</span>
    </div>
    <div>
        <label>新密码：</label>
        <input name="new_password" type="password" class="required ti">
        <span class="entry-info">*</span>

    </div>
    <div>
        <label>确认密码：</label>
        <input name="re_password" type="password" class="required ti">
        <span class="entry-info">*</span>
    </div>
    <input type="submit" class="mbtn" value="确定">
</form>
