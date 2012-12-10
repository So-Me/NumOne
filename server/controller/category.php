<?php
!defined('IN_APP') && exit('ILLEGAL EXECUTION');

$bigCategories = BigCategory::readArray();

render_view('master', array('view' => 'backend'));
