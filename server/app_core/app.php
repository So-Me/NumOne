<?php
/**
 * 这个文件定义了一系列全局函数，用来操作APP
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

function init_var()
{
    if (isset($_SERVER['REDIRECT_URL'])) {
        $req_uri = $_SERVER['REDIRECT_URL'];
    } else {
        $req_uri = reset(explode('?', $_SERVER['REQUEST_URI']));
    }
    $arr = explode('/', trim($req_uri, '/'));

    // c is controller
    // a is action
    $GLOBALS['controller'] = i($arr[0]) ?: 'index';
    $GLOBALS['action'] = _req('a') ?: _req('action') ?: 'get';
    $GLOBALS['target'] = i($arr[1]) ?: _req('target');
    $GLOBALS['argument'] = i($arr[2]);

    // we should use function here
    $GLOBALS['by_ajax'] = i($_REQUEST['is_ajax']) || (strtolower(i($_SERVER['HTTP_X_REQUESTED_WITH'])) == strtolower('XMLHttpRequest'));
    $GLOBALS['by_post'] = strtolower(i($_SERVER['REQUEST_METHOD'])) == 'post';

    $GLOBALS['page'] = array(
        'title'   => $GLOBALS['config']['site']['name'],
        'head'    => array(), // 在head里面的语句
        'scripts' => array(), // 页面底部的script
        'styles'  => array(), // head里面的css
        'append_divs' => array(), // 附加的对话框
    ); // 关于这个页面的变量
}

function init_env()
{
    ob_start();
    session_start();
    date_default_timezone_set('PRC');

    // auto require when using class (model or lib)
    spl_autoload_register(function ($classname) {
        $filename = str_replace('\\', DS, $classname) . '.php';
        $model_file = APP_ROOT . 'model' . DS . $filename;
        $lib_file = CORE_ROOT . 'lib' . DS . $filename;
        if (file_exists($model_file)) 
            require_once $model_file;
        elseif (file_exists($lib_file))
            require_once $lib_file;
    });
}

function render_view($view, $opts = array())
{
    extract($opts);
    include AppFile::view($view); // 渲染 view
}
