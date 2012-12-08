<?php
!defined('IN_APP') && exit('ILLEGAL EXECUTION');

$startIndex = _req('startIndex') ?: 0;
$itemPerPage = _req('itemsPerPage') ?: 10;

$data = $shop->jsonData();

output_data($data);
