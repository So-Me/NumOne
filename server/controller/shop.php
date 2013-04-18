<?php
!defined('IN_APP') && exit('ILLEGAL EXECUTION');

$cities = City::readArray();
$districts = District::readArray();
$sorts = array(
	'id DESC' => '发布时间',
	'discount ASC' => '折扣');
$shops = Shop::read();

render_view('master', array('view' => 'backend'));
