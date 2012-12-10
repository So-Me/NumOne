<?php
!defined('IN_APP') && exit('ILLEGAL EXECUTION');

$bigCategoryId = _req('bigCategoryId');

$conds = array();
if ($bigCategoryId) {
    $conds['bigCategoryId'] = $bigCategoryId;
}

$data = Category::jsonData($conds);

output_data($data);
