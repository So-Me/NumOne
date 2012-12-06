<?php
!defined('IN_APP') && exit('ILLEGAL EXECUTION');

$id = _req('id');

$shop = new Shop($id);

$info = $shop->infoArray();

output_json($info);
