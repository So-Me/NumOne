<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

if (!is_numeric($target)) {
    throw new Exception("unkown target $target");
}
if ($by_ajax) {
    
    switch ($action) {
        case 'get_edit_div':
            $addr_id = $target;
            $address = new Address($addr_id);

            $view_name = 'address.edit';
            include smart_view('append.div');
            break;
        
        default:
            throw new Exception("unkown ajax action: $action");
            break;
    }
}

if ($by_post) {
    switch ($action) {
        case 'edit':
            $address = new Address($target);
            $name = _post('name');
            $phone = _post('phone');
            $detail = _post('detail');
            $address->edit(compact(
                'name',
                'phone',
                'detail'));
            redirect('cart');
            break;
        
        default:
            # code...
            break;
    }
}
exit;
