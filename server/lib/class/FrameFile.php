<?php

/**
 * 现在看来这个也可以用来 js css 啥的
 * Usage: FrameFile::controller('index');
 */

class FrameFile
{
    public static function controller($name)
    {
        return APP_ROOT . 'controller' . DIRECTORY_SEPARATOR . $name . '.php';
    }

    public static function view($name)
    {
        return APP_ROOT . 'static' . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . $name . '.php';
    }
}
