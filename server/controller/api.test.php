<?php
!defined('IN_APP') && exit('ILLEGAL EXECUTION');

$arr = array(
    'apiVersion' => '1.0',
    'data' => array(
        'test' => 'works'));
echo json_encode($arr);
