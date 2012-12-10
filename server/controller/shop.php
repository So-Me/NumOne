<?php
!defined('IN_APP') && exit('ILLEGAL EXECUTION');

$cities = City::readArray();
$shops = Shop::read();

render_view('master', array('view' => 'backend'));
