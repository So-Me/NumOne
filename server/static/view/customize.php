<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */
?>
<div>
    <h2 class="title">我要定制</h2>
    <span>请详细填写您的定制需求单</span>
</div>
<form method="post" enctype="multipart/form-data">
    <div>
        <div>
            <label for="material">材质：</label>
            <?php  
            $field_name = 'material';
            $no_default = 1;
            $class = 'required';
            include smart_view('widget.select');
            ?>
            <label for="stone">主石：</label>
            <input name="stone" id="stone" value="<?= $stone ?>" class="required">
        </div>
        <div>
            <label for="size">手寸：</label>
            <input name="size" id="size" value="<?= $size ?>" class="required">
            <label for="carve_text">刻字：</label>
            <input name="carve_text" id="carve_text" value="<?= $carve_text ?>">
        </div>
        <div>
            <label>图片：</label>
            <input type="file" name="image" class="">
        </div>
        <ul class="images">
            <?php $i = 0; ?>
            <?php foreach ($images as $image_src): ?>
                <li>
                    <img src="<?= $image_src ?>">
                    <span class="del-img-btn">x</span>
                    <input type="hidden" name="image_input[<?= $i ?>]" value="<?= $image_src ?>">
                </li>
                <?php $i++; ?>
            <?php endforeach ?>
        </ul>
        <div class="remark">
            <label for="remark">备注：</label>
            <textarea name="remark" id="remark" value="<?= $remark ?>"></textarea>
        </div>
        <input type="submit" value="确定">
    </div>
</form>
