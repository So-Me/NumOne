<?php
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */
function output_json($data)
{
    $arr = array('apiVersion' => '1.0');
    $arr['data'] = $data;
    echo json_encode($arr);
}
