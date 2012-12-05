<?php

/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

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
