<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

define('IN_APP', 1);

if (isset($_SERVER['HTTP_APPNAME']))
    define('ON_SAE', 1);
else 
    define('ON_SAE', 0);

define('DS', DIRECTORY_SEPARATOR);
define('APP_ROOT', __DIR__ . DS . '..' . DS);
define('CORE_ROOT', APP_ROOT . 'app_core' . DS);

include APP_ROOT . 'config/common.php';

require CORE_ROOT . 'function.php';
require CORE_ROOT .  "lib/Pdb.php";

$c = $config['db'];
if (!ON_SAE)
    $c['dbname'] = '';
Pdb::setConfig($c);

$histories = array();

$sqls = explode(';', file_get_contents('install.sql'));
exec_sqls($sqls);

$sqls = explode(';', file_get_contents('default_data.sql'));
exec_sqls($sqls);

// include 'default_data.php';
// insert_categories($default_categories);

// function dd($str)
// {
//     echo "<p>$str</p>\n";
// }

function exec_sqls($sqls)
{
    if (empty($sqls))
        return;
    foreach ($sqls as $sql) {
        exec_sql($sql);
    }
}

function exec_sql($sql = '')
{
    // d($sql);
    $sql = trim($sql);
    if (empty($sql))
        return;
    if (ON_SAE && preg_match('/USE|CREATE\sDATABASE/', $sql)) {
        return;
    }
    Pdb::exec($sql);
    $GLOBALS['histories'][] = $sql;
}

function insert_categories($cate)
{
    $cate = trim($cate);
    $lines = explode(PHP_EOL, $cate);
    foreach ($lines as $line) {
        if (preg_match('/^\d.\s(.+)$/', $line, $matches)) {
            Pdb::insert(
                array('name' => trim($matches[1])), 
                'big_category',
                'ON DUPLICATE KEY UPDATE name=name');
            $cur_big = Pdb::lastInsertId();
        } else if (preg_match('/^\s\d.\s(.+)$/', $line, $matches)) {
            Pdb::insert(
                array(
                    'big_category' => $cur_big, 
                    'name' => trim($matches[1])), 
                'category',
                'ON DUPLICATE KEY UPDATE name=name');
        } else {
            throw new Exception("not good line formate: $line");
        }
    }
}
?>
<p>install ok</p>
<p><a href="/test/index.php">if you need test</a><p>
<p>or just go to <a href="/">index</a></p>
