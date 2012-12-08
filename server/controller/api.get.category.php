<?php
!defined('IN_APP') && exit('ILLEGAL EXECUTION');

$BigCategoryId = _req('BigCategoryId');

$conds = array();
if ($BigCategoryId) {
    $conds['BigCategoryId'] = $BigCategoryId;
}
$data = Category::jsonData($conds);

output_data($data);
