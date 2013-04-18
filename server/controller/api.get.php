<?php
!defined('IN_APP') && exit('ILLEGAL EXECUTION');

if (!file_exists(AppFile::controller("api.get.$kind"))) {
    $availables = array(
        'BigCategory',
        'Category',
        'Province',
        'City',
        'District',
        'ShopList',
        'Shop');
    output_error(
        400, 
        array('message' => "Not right kind: $kind.", 'availables' => $availables));
}
