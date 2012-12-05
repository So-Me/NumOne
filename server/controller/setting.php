<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

if ($user_type !== 'Admin')
    die('no permission');

$msg = '';
$ERROR_INFO = $config['error']['info'];
switch ($target) {
    case '':
        $settings = Setting::get();
        $name_map = $config['setting_name_map'];

        if ($by_post) {
            $labor_expense = _post('labor_expense');
            $wear_tear = _post('wear_tear');
            $st_expense = _post('st_expense');
            $st_price = _post('st_price');
            $weight_ratio = _post('weight_ratio');

            Setting::set(compact(
                'labor_expense',
                'wear_tear',
                'st_expense',
                'st_price',
                'weight_ratio'));

            redirect('setting'); // refresh
        }
        break;

    case 'password':
        if ($by_post) {
            $password = _post('password');
            $new_password = _post('new_password');
            $re_password = _post('re_password');

            if (empty($password)) {
                $msg = $ERROR_INFO['PASSWORD_EMPTY'];
            } elseif (!$user->checkPassword($password)) {
                $msg = $ERROR_INFO['PASSWORD_INCORRECT'];
            } elseif (empty($new_password)) {
                $msg = $ERROR_INFO['NEW_PASSWORD_EMPTY'];
            } elseif ($new_password !== $re_password) {
                $msg = $ERROR_INFO['PASSWORD_NOT_SAME'];
            } else {
                $user->changePassword($new_password);

                redirect();
            }
        }
        break;
    
    default:
        throw new Exception("unkown target: $target");
        break;
}


if ($target === 'password') {
    $matter = 'password';
} else {
    $matter = $view;
}
$view = 'board?master';

$page['scripts'][] = 'jquery.validate.min';
