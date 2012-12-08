<?php
!defined('IN_APP') && exit('ILLEGAL EXECUTION');

$big_category = _req('big_category');
$startIndex = _req('startIndex') ?: 0;
$itemPerPage = _req('itemPerPage') ?: 10;

$data = BigCategory::jsonData(
    compact('big_category', 'startIndex', 'itemPerPage'));

output_jsons($data);
