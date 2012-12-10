<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

define('IN_APP', 1);
define('ON_TEST', 1);

// DS for both win and linux is not used!!!
define('DS', DIRECTORY_SEPARATOR);

define('APP_ROOT', __DIR__ . '/../');
define('CORE_ROOT', APP_ROOT . 'app_core/');
define('TEST_ROOT', __DIR__ . '/');

require TEST_ROOT . 'lib.php'; // functions for test

include_once APP_ROOT . 'config/common.php';

require_once CORE_ROOT . 'function.php';
require_once CORE_ROOT . 'app.php';

init_env();

include TEST_ROOT . 'static/index.html';
