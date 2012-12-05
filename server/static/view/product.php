<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */
?> 
<form>
    <div class="search">
        <div class="e">
            <label for="name">名称：</label>
            <input name="name" id="name" class="ti" type="text" value="<?= $name ?>" />
        </div>
        <div class="e">
            <label for="no">款号：</label>
            <input name="no" id="no" class="ti" type="text" value="<?= $no ?>" />
        </div>
        <div class="e">
            <label for="">分类：</label>
            <?php
            $data = $types;
            include smart_view('widget.select');
            ?>
        </div>
        <div class="e">
            <label for="">排序：</label>
            <select name="sort1" class="">
                <option selected="" value="">排序条件</option>
                <option value="count_sold">已售数量</option>
            </select>
            <select name="sort2" class="">
                <option selected="" value="desc">降序</option>
                <option value="asc">升序</option>
            </select>
        </div>
        <input type="submit" class="mbtn" value="搜索" />
    </div>
</form>
<div class="page-info">
    <?php include smart_view('paging'); ?>
    <div class="total">共找到：<?= $total ?>条</div>
</div>
<table>
    <tr class="title">
        <th class="col title ckb"><input type="checkbox" name="" class="group all" /></th>
        <th class="col title name">名称</th>
        <th class="col title no">款号</th>
        <th class="col title type">分类</th>
        <th class="col title rabbet">镶口</th>
        <th class="col title stone">辅石</th>
        <th class="col title weight">估重（K金）</th>
        <th class="col title price-estimate">估价</th>
        <th class="col title remark">说明</th>
        <th class="col title paid">已售</th>
        <th class="col title control">操作</th>
    </tr>
    <?php foreach ($products as $prd): $materials = implode('&nbsp;', $prd->materials()) ?>
        <tr data-id="<?= $prd->id ?>">
            <td class="col ckb"><input type="checkbox" class="group" /></td>
            <td class="col name">
              <img src="<?= $prd->image1_thumb ?>" alt="缩略图" />
              <div class="text-wrap">
                    <span class="text"><?= $prd->name ?></span>
              </div>
            </td>
            <td class="col no"><?= $prd->no ?></td>
            <td class="col type"><?= $types[$prd->type] ?></td>
            <td class="col rabbet"><?= $prd->rabbet_start . '-' . $prd->rabbet_end ?>ct</td>
            <td class="col stone"><?= $prd->small_stone ?></td>
            <td class="col weight"><?= $prd->weight ?></td>
            <td class="col price-estimate">￥<?= $prd->estimatePrice() ?></td>
            <td class="col remark"><?= $prd->remark ?></td>
            <td class="col paid"><?= $prd->sold_count ?></td>
            <td class="col control"><button class="mbtn">编辑</button></td>
        </tr>
    <?php endforeach ?>
</table>
<div>
    <?php include smart_view('paging'); ?>
    <input type="checkbox" class="group all" />
    <button>批量导出</button>
    <button>批量删除</button>
</div>
