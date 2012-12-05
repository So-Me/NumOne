<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */
?>
<form method="post" class="add">
    <?php if ($msg): ?><div class="msg"><?= $msg ?></div><?php endif; ?>
    <div>
        <label>用户名：</label>
        <input name="username" type="text" value="<?= $username ?>" placeholder="username" class="required" />
    </div>
    <div>
        <label>密码：</label>
        <input name="password" type="text" value="<?= $password ?>" placeholder="password" class="required" />
    </div>
    <div><input type="submit" value="创建管理员" /></div>
</form>
