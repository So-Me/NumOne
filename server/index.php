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

// 命名的问题
// IN_APP
// AppFile(Class)
// 这样会比较好一点
// core 文件夹也是需要的 (CORE_ROOT)
// Model ==> DefaultModel
define('IN_PTF', 1);

define('APP_ROOT', __DIR__ . DIRECTORY_SEPARATOR);

require 'config/common.php';

// if not debug, mute all error reportings
if (!(defined('DEBUG') ? DEBUG : 0)) {
	ini_set('display_errors', 0);
	error_reporting(0);
}

require 'lib/function.php';
include 'lib/autoload.php';

// 变量初始化
require 'init.php';
init_var();
init_env();

require 'lib/helper.php';

require FrameFile::controller('init');

if (!file_exists(FrameFile::controller($controller))) {
    $controller = 'default'; // page 404
    include FrameFile::controller($controller);
    include smart_view($controller);
    exit;
}

// auto include if there exists css or js file same name with controller
if (file_exists(_css($controller)))
    $page['styles'][] = $controller;

// execute controller
include FrameFile::controller($controller);

// view
$arr = explode('?', $view);
if (count($arr) == 2 && $arr[1] == 'master') {
    $content = $arr[0];
    $view = 'master';
}

include smart_view($view); // 渲染 view
