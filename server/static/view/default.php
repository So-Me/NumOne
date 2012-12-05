<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
/**
 * @file    page404
 * @author  ryan <cumt.xiaochi@gmail.com>
 * @created Jun 30, 2012 11:13:21 AM
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title><?php echo $page['title']; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <?php
        echo css_node('reset'), "\n";
        echo css_node('style'), "\n";
        ?>
    </head>
    <body>
        <div class="header">
            <h1>
                <a href="<?= ROOT ?>" title="<?= $config['site']['name'] ?>">
                    <img src="<?= ROOT ?>static/img/logo.png" alt="英格" title="回首页" />
                </a>
            </h1>
        </div>
        <div class="misssing" title="<?= i($GLOBALS['view_looking_for']) ?>">
            没有页面 404
        </div>
    </body>
</html>
