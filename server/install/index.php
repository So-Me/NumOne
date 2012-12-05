<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

define('IN_PTF', 1);

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

function dd($str)
{
    echo "<p>$str</p>\n";
}

function exec_sql($sql = '')
{
    if (ON_SAE && preg_match('/USE|CREATE\sDATABASE/', $sql)) {
        return;
    }
    Pdb::exec($sql);
    $GLOBALS['histories'][] = $sql;
}
?>
<p>install ok</p>
<p><a href="/test/index.php">if you need test</a><p>
<p>or just go to <a href="/">index</a></p>
