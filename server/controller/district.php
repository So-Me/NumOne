<?php
!defined('IN_APP') && exit('ILLEGAL EXECUTION');

$provinces = Province::readArray();

render_view('master', array('view' => 'backend'));
