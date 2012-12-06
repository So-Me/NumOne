<?php

/**
 * 现在看来这个也可以用来 js css 啥的
 * Usage: FrameFile::controller('index');
 */

class AppFile
{
    public static function controller($name)
    {
        return APP_ROOT . 'controller' . DS . "$name.php";
    }

    public static function view($name)
    {
        return APP_ROOT . 'static' . DS . 'view' . DS . "$name.php";
    }

    public static function lib($name)
    {
        return CORE_ROOT . 'lib' . DS . "$name.html";
    }
}
