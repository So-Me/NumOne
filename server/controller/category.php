<?php
!defined('IN_APP') && exit('ILLEGAL EXECUTION');

$bigCategories = BigCategory::readArray();

foreach ($bigCategories as $id => $name) {
    $associateCategories[$id] = Category::readArray(new BigCategory($id));
}

render_view('master', array('view' => 'backend'));
