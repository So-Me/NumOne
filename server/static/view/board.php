<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */
?>
<?php include smart_view('nav'); ?>
<div class="right-frame">
    <?php include smart_view('crumb'); ?>
    <div class="matter <?= str_replace('.', '-', $matter) ?>">
        <?php include smart_view($matter); ?>
    </div>
</div>
