<?php
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

function output_data($data, $opts = array())
{
    output_json(array('data' => $data));
}

function output_error($code, $msg = 'error')
{
    $error = array(
        'code' => $code,
        'message' => $msg);
    output_json(array('error' => $error));
}

function output_json($arr)
{
    $arr['apiVersion'] = '1.0';
    header('Content-Type:application/json');
    echo json_encode($arr);
    exit;
}
