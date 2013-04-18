<?php
!defined('IN_APP') && exit('ILLEGAL EXECUTION');

if (!$by_ajax && !DEBUG) {
    exit;
}

$kind = _req('kind');
if ($kind)
    $target = $kind;
