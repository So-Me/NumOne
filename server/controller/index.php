<?php
!defined('IN_APP') && exit('ILLEGAL EXECUTION');

$topNav = build_nav($config['nav']['top']);
// d($mainNav);
$sideNav = build_nav($config['nav']['side']);

render_view('master');
