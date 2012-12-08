<?php
!defined('IN_APP') && exit('ILLEGAL EXECUTION');

$BigCategoryId = _req('BigCategoryId');
if (empty($BigCategoryId)) {
    output_error(400, "no BigCategoryId");
}
$startIndex = _req('startIndex') ?: 0;
$itemPerPage = _req('itemsPerPage') ?: 10;

$data = Category::jsonData(
    compact('BigCategoryId', 'startIndex', 'itemPerPage'));

output_data($data);
