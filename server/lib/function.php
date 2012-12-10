<?php
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

function output_data($data, $opts = array())
{
    output_json(array('data' => $data));
}

function output_error($code, $a = null)
{
    
    if (is_string($a)) {
        $msg = $a;
        $arr = array('message' => $a);
    } elseif (is_array($a)) {
        $msg = isset($a['message']) ? $a['message'] : 'error';
        $arr = $a;
    } else {
        throw new Exception("bad arg: $a");
    }

    header("HTTP/1.1 $code $msg");
    $error = array_merge($arr, array('code' => $code));
    output_json(array('error' => $error));
}

function output_json($arr)
{
    $arr['apiVersion'] = '1.0';
    header('Content-Type:application/json');
    echo json_encode($arr);
    exit;
}

function break_latilongi($latilongi)
{
    if (preg_match('/^([\+|-]?\d+\.\d+),?([\+|-]?\d+\.\d+)$/', $latilongi, $matches)) {
        return array($matches[1], $matches[2]);
    } else {
        throw new Exception("latilongi not right: $latilongi");
    }
}

// (CamelCase or camelCase) to under_score
// support only one Upper Case
function camel2under($str)
{
    if (preg_match('/.+[A-Z].+/', $str)) {
        $str = preg_replace('/^(.+)([A-Z].+)$/', '$1_$2', $str); // with underscore
    }
    return strtolower($str);
}
