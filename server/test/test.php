<?php

require 'lib.php'; // functions for test

require_once APP_ROOT . 'lib/function.php';
require_once APP_ROOT . 'lib/autoload.php';
include_once APP_ROOT . 'config/common.php';

Pdb::setConfig($config['db']);

// clear side effects for all

// unset all session
if (1) {
    foreach ($_SESSION as $key => $value) {
        unset($_SESSION[$key]);
    }
}

// clear db entries that was insert by test
include 'clear_db.php';

$all_pass = true;

// case 1 autoload
begin_test();
$id = 101;
$model = new BasicModel($id);
test($model->id, $id, array(
    'name' => 'autoload'));
