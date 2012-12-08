<?php
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */
function output_json($data, $opts = array())
{

    $arr = array('apiVersion' => '1.0');
    $arr['data'] = array_merge($opts, $data);
    header('Content-Type:application/json');
    echo json_encode($arr);
}

function output_jsons($data, $opts = array())
{
    $opts['items'] = $data;
    if (!isset($opts['itemCount']))
        $opts['itemCount'] = count($data);
    output_json($opts);
}
