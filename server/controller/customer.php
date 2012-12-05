<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

switch ($action) {
    case 'accept':
        // check if 
        if (!$has_login)
            redirect('login');
        if ($user->type !== 'Admin')
            exit('no permission');
        $admin-adoptCustomer(new Customer($target));
        break;
    
    default:
        # code...
        break;
}
