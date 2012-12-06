<?php
!defined('IN_APP') && exit('ILLEGAL EXECUTION');

$categories = Category::read();

output_json($categories);
