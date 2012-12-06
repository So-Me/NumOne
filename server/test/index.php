<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

define('IN_APP', 1);
define('ON_TEST', 1);

define('DS', DIRECTORY_SEPARATOR);

define('APP_ROOT', __DIR__ . '/../');
define('CORE_ROOT', APP_ROOT . 'app_core/');
define('TEST_ROOT', __DIR__ . '/');

require TEST_ROOT . 'lib.php'; // functions for test

include_once APP_ROOT . 'config/common.php';

require_once CORE_ROOT . 'function.php';
require_once CORE_ROOT . 'app.php';

init_env();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="zh-CN">
<head>
    <meta charset="UTF-8" />
    <title>Test for Cheng</title>
    <link rel="stylesheet" type="text/css" href="static/style.css" />
</head>
<body>
    <h1><a href="?">Test for Cheng</a></h1>
    <a href="/">exit</a>
    <a class="clear btn" href="?exit=1">clear all side effects in db</a>
    <div class="conclusion pass" id="pre-pass-box">ALL PASS</div>
    <div class="conclusion fail" id="pre-fail-box">SOME FAIL!</div>
    <ul><?php include 'test.php'; ?></ul>
    <div class="conclusion <?= $all_pass? 'pass' : 'fail' ?>"><?= $all_pass? 'ALL PASS' : 'SOME FAIL!' ?></div>
    <?php if ($all_pass): ?>
        <script src="static/hide_fail.js"></script>
    <?php endif ?>
    
</body>
</html>



