<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */
?>
<form action="<?= ROOT ?>product/post" class="auto-load post" enctype="multipart/form-data" method="post">
    <div class="left">
        <div class="upload">
            <h3>产品图片上传</h3>
            <span>图片尺寸要求不小于：400px *400px</span>
            <div>
                <span>主图：</span>
                <input type="file" name="image1" />
            </div>
            <div> 默认采用主图显示在产品列表中</div>
            <div>
                <span>附图1：</span>
                <input type="file" name="image2" />
            </div>
            <div>
                <span>附图2：</span>
                <input type="file" name="image3" />
            </div>
        </div>
        <img src="<?= $image1_thumb ?>" title="主图" />
        <img src="<?= $image2_thumb ?>" title="附图1" />
        <img src="<?= $image3_thumb ?>" title="附图2" />
    </div>
    <div class="right">
        <div>
            <label for="name">标题：</label>
            <input name="name" type="text" value="<?= $name ?>" id="name" class="required" />
        </div>
        <div>
            <label for="no">款号：</label>
            <input name="no" type="text" value="<?= $no ?>" id="no" class="required" />
        </div>
        <div>
            <label for="type">分类：</label>
            <?php widget('select', array('no_default' => true)); ?>
        </div>
        <div>
            <label for="material">材质：</label>
            <div>
                <input name="material[]" type="checkbox" value="PT950" id="material0" class="required" <?= in_array('PT950', $materials) ? 'checked' : '' ?> /><label for="material0">PT950</label>
                <input name="material[]" type="checkbox" value="黄18K金" id="material1" class="required" <?= in_array('黄18K金', $materials) ? 'checked' : '' ?> /><label for="material1">黄18K金</label>
                <input name="material[]" type="checkbox" value="白18K金" id="material2" class="required" <?= in_array('白18K金', $materials) ? 'checked' : '' ?> /><label for="material2">白18K金</label>
                <input name="material[]" type="checkbox" value="红18K金" id="material3" class="required" <?= in_array('红18K金', $materials) ? 'checked' : '' ?> /><label for="material3">红18K金</label>
            </div>
        </div>
        <div>
            <label for="weight">重量：</label>
            <input name="weight" type="text" value="<?= $weight ?>" id="weight" class="required" />
            <span>18K金</span>
        </div>
        <div>
            <label for="">镶口：</label>
            <input name="rabbet_start" type="text" value="<?= $rabbet_start ?>" id="rabbet_start" class="required" />
            <input name="rabbet_end" type="text" value="<?= $rabbet_end ?>" id="rabbet_end" class="required" />
        </div>
        <div>
            <label for="small_stone">辅石数量：</label>
            <input name="small_stone" type="text" value="<?= $small_stone ?>" id="small_stone" class="required" />
            <label for="st_weight">重量：</label>
            <input name="st_weight" type="text" value="<?= $st_weight ?>" id="st_weight" class="required" />
            <span>克拉</span>
        </div>
        <div>
            <label>名品：</label>
            <input name="is_brand" type="checkbox" id="is_brand" value="1" <?= $is_brand ? 'checked' : '' ?> >
            <label for="is_brand" class="after">是</label>
            <?php 
            widget(
                'select', 
                array(
                    'field_name' => 'brand',
                    'no_default' => true)); ?>
        </div>
        <div>
            <label for="remark">说明：</label>
            <input name="remark" type="text" value="<?= $remark ?>" id="remark" class="" />
            <span>仅自己可见</span>
        </div>
        <input type="hidden" value="<?= $image1 ?>" name="image1" />
        <input type="hidden" value="<?= $image1_400 ?>" name="image1_400" />
        <input type="hidden" value="<?= $image1_thumb ?>" name="image1_thumb" />
        <input type="hidden" value="<?= $image2 ?>" name="image2" />
        <input type="hidden" value="<?= $image2_400 ?>" name="image2_400" />
        <input type="hidden" value="<?= $image2_thumb ?>" name="image2_thumb" />
        <input type="hidden" value="<?= $image3 ?>" name="image3" />
        <input type="hidden" value="<?= $image3_400 ?>" name="image3_400" />
        <input type="hidden" value="<?= $image3_thumb ?>" name="image3_thumb" />
        <input type="submit" value="发布产品" />
    </div>
</form>
