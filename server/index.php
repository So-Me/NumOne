<?php
/**
 * @file    index
 * @author  ryan <cumt.xiaochi@gmail.com>
 * @created Jun 30, 2012 10:38:22 AM
 * app logic
 * 此框架由王霄池纯粹手写而成，当然参照了不少鸡爷的框架，也参照了 LazyPHP
 */

// 打开错误提示, SAE 可以 ini_set 将不起作用
ini_set('display_errors', 1);
error_reporting(E_ALL);

define('IN_APP', 1);

define('DS', DIRECTORY_SEPARATOR);
define('APP_ROOT', __DIR__ . DS);
define('CORE_ROOT', __DIR__ . DS . 'app_core' . DS);

include APP_ROOT . 'config/common.php';

// if not debug, mute all error reportings
if (!(defined('DEBUG') ? DEBUG : 0)) {
	ini_set('display_errors', 0);
	error_reporting(0);
}

require CORE_ROOT . 'function.php';

// app 执行
require CORE_ROOT . 'app.php';
init_var();
init_env();

require CORE_ROOT . 'BasicModel.php';

// all user excute this controller: init
$init_controller_file = AppFile::controller('init');
if (file_exists($init_controller_file))
    include $init_controller_file;

$controller_file = AppFile::controller($controller);

if (!file_exists($controller_file)) {
    $controller = 'default'; // page 404
    $controller_file = AppFile::controller($controller);
}

// execute controller
include $controller_file;
$controller_action_file = AppFile::controller("$controller.$action");
if (file_exists($controller_action_file))
    include $controller_action_file;
