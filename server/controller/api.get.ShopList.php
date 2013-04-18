<?php
!defined('IN_APP') && exit('ILLEGAL EXECUTION');

$startIndex = _req('startIndex') ?: 0;
$itemsPerPage = _req('itemsPerPage') ?: 10;

$distance = _req('distance');
$latilongi = _req('latilongi');
$districtId = _req('districtId');
$cityId = _req('cityId');
$bigCategoryId = _req('bigCategoryId');
$categoryId = _req('categoryId');

$all_given = ($latilongi && $districtId && $distance);
$given_any = ($latilongi || $districtId || $distance);
if ($all_given ^ $given_any) {
    output_error(400, "latilongi, districtid and distance must be given togther or not with any");
}

$conds = compact(
    'distance',
    'latilongi',
    'districtId',
    'cityId',
    'bigCategoryId',
    'categoryId',
    'startIndex', 
    'itemsPerPage');
$data = Shop::jsonDatas($conds);

output_data($data);
