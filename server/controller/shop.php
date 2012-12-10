<?php
!defined('IN_APP') && exit('ILLEGAL EXECUTION');

$shops = Shop::read();

render_view('master', array('view' => 'backend'));
