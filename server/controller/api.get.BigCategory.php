<?php
!defined('IN_APP') && exit('ILLEGAL EXECUTION');

$data = BigCategory::jsonData();

output_jsons($data);
