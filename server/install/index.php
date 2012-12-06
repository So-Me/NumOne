<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

define('IN_APP', 1);
exit('?');

$root = __DIR__ . '/..';

if (isset($_SERVER['HTTP_APPNAME']))
    define('ON_SAE', 1);
else 
    define('ON_SAE', 0);

require "$root/lib/function.php";
require "$root/config/common.php";
require "$root/lib/class/Pdb.php";

$c = $config['db'];
if (!ON_SAE)
    $c['dbname'] = '';
Pdb::setConfig($c);

$histories = array();

$sqls = explode(';', file_get_contents('install.sql'));
foreach ($sqls as $sql) {
    exec_sql($sql);
}

$sqls = explode(';', file_get_contents('default_data.sql'));
foreach ($sqls as $sql) {
    exec_sql($sql);
}

include 'default_data.php';
insert_categories($default_categories);

function dd($str)
{
    echo "<p>$str</p>\n";
}

function exec_sql($sql = '')
{
    if (empty(trim($sql)))
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
            Pdb::insert(array('name' => $matches[0]), 'big_category');
            $cur_big = Pdb::lastInsertId();
        } else if (preg_match('/^\s\d.\s(.+)$', $line, $matches)) {
            Pdb::insert(array('big_category' => $cur_big, 'name' => $matches[0]), 'big_category');
        } else {
            throw new Exception("not good line formate: $line");
        }
    }
}
?>
<p>install ok</p>
<p><a href="/test/index.php">if you need test</a><p>
<p>or just go to <a href="/">index</a></p>
