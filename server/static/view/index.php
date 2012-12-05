<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
/**
 * @file    index
 * @author  ryan <cumt.xiaochi@gmail.com>
 * @created Jul 17, 2012 9:51:11 AM
 */
?>
<form name="search">
    <div class="search">
        <div class="type">
            <input name="type" type="hidden" value="<?= $type ?>" />
            <div class="small-wrap"> 
                <a class="customize-btn" href="<?= ROOT ?>customize">我要定制</a>
                <ul class="types">
                    <?php foreach (Product::types() as $t): ?>
                        <li class="<?= $type === $t ? 'on' : '' ?>"><?= $t ?></li>
                    <?php endforeach; ?>
                    <li class="brand"><span>名品</span></li>
                </ul>
            </div>
        </div>
        <div class="bg"></div>
        <div class="pattern-bg"></div>
        <div class="small-wrap">
            <div class="e e-first">
                <label for="name">名称：</label>
                <input id="name" class="text-in" type="text" name="name" value="<?= $name ?>" />
            </div>
            <div class="e">
                <label for="no">款号：</label>
                <input id="no" class="text-in" type="text" name="no" value="<?= $no ?>" />
            </div>
            <div class="e">
                <label for="stone-size">镶石大小：</label>
                <input id="stone-size" class="text-in" type="text" name="stone_size" value="<?= $stone_size ?>" />
                <span>ct</span>
            </div>
            <input class="search-btn mbtn" type="submit" value="搜索" />
        </div>
    </div>
</form>
<div class="small-wrap c">
    <div class="page-info ">
        <?php include smart_view('paging'); ?>
        <div class="total">共有<?= $total ?>款</div>
        <div class="view-switch">
            <span class="list-mode btn <?= $mode === 'list' ? 'list-on on' : '' ?>" data-mode="list" title="列表模式">列表</span>
            <span class="image-mode btn <?= $mode === 'image' ? 'image-on on' : '' ?>" data-mode="image" title="大图模式">大图</span>
        </div>
    </div>
    <ul class="product-list <?= $mode ?> <?= $mode ?>-pl">
        <?php foreach ($products as $prd):  ?>
            <?php 
            $prd_id = $prd->id;
            $materials = $prd->materials();
            ?>
            <li class="entry" data-id="<?= $prd_id ?>">
                <div class="left slide">
                    <div class="pic-frame">
                        <div class="img-wrap">
                            <img class="prd" src="<?= $prd->image1_400 ?>" />
                            <img class="prd" src="<?= $prd->image2_400 ?>" />
                            <img class="prd" src="<?= $prd->image3_400 ?>" />
                        </div>
                    </div>
                    <ul class="indicator">
                        <li></li>
                        <li></li>
                        <li></li>
                    </ul>
                </div>
                <?php if ($mode === 'list'): ?>
                    <div class="mid">
                        <div><?php $stop = 1; ?>
                            <strong class="name"><?= $prd->name ?></strong>
                            <span>款号：<?= $prd->no ?></span>
                        </div>
                        <div>镶口：<?= $prd->rabbet_start ?>-<?= $prd->rabbet_end ?> ct</div>
                        <div class="material">
                            <span>材质：</span>
                            <?php $default_material = $prd->defaultMaterial(); ?>
                            <ul class="material-selector" data-selected="<?= $default_material ?>">
                                
                                <?php foreach ($materials as $id => $value): ?>
                                    <li data-id="<?= $id ?>" class="<?= $value === $default_material ? 'on' : '' ?>"><?= $value ?></li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                        <div class="size">
                            <label for="size">手寸：</label>
                            <input class="ti" type="text" name="size" id="size" />
                        </div>
                        <div class="carve-text">
                            <span>刻字：</span>
                            <div class="carve">
                                <span class="trigger">输入&gt;</span>
                                <span class="text"></span>
                                <div class="carve-box">
                                    <div>刻字内容：</div>
                                    <div>
                                        <input type="text" name="carve_text" class="ti" />
                                        <button class="ok-btn mbtn">确定</button>
                                    </div>
                                    <img src="<?= ROOT ?>static/img/heart-add.gif" class="add-heart-btn">
                                </div>
                            </div>
                            <span class="instruction">由字母、数字、图形组成；至多5个字符。</span>
                        </div>
                        <div>
                            <span>辅石：</span>
                            <span><?= $prd->small_stone ?>粒</span>
                        </div>
                        <div>
                            <span>工费：</span>
                            <span><?= Setting::get('labor_expense') ?>元/件</span>
                            <span class="wt-label"> 损耗：</span>
                            <span><?= Setting::get('wear_tear') ?>%</span>
                        </div>
                    </div>
                    <div class="right">
                        <div class="already" style="<?= !isset($chosen_map[$prd_id]) ? 'display:none' : '' ?>">已下单 <span class="num"><?= i($chosen_map[$prd_id], 0) ?></span></div>
                        <div class="add btn">+&nbsp;下订单</div>
                        <div class="estimate">
                            <span>预估价：</span>
                            <span class="price">￥<span class="num"><?= fp($prd->estimatePrice(array('material' => $prd->defaultMaterial()))) ?></span></span>
                        </div>
                    </div>
                <?php endif ?>
                <br class="clear-fix" />
            </li>
        <?php endforeach ?>
    </ul>
    <?php include smart_view('paging'); ?>
    <br class="clear-fix" />
</div>
