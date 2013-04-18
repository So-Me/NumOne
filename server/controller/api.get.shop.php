<?php
!defined('IN_APP') && exit('ILLEGAL EXECUTION');

$id = _req('id');

$shop = new Shop($id);

$data = $shop->jsonData();

output_data($data);
