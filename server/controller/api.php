<?php
!defined('IN_APP') && exit('ILLEGAL EXECUTION');

if (!$by_ajax && !DEBUG) {
    exit;
}

$kind = _req('kind');
$target = $kind;
