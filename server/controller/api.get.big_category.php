<?php
!defined('IN_APP') && exit('ILLEGAL EXECUTION');

$big_categories = BigCategory::readArray();

output_json($big_categories);
