<?php
!defined('IN_APP') && exit('ILLEGAL EXECUTION');

$startIndex = _req('startIndex') ?: 0;
$itemsPerPage = _req('itemsPerPage') ?: 10;

$conds = compact('startIndex', 'itemsPerPage');
$data = Shop::jsonDatas($conds);

output_data($data);
