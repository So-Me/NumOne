<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

if (!$has_login) 
    redirect('login?back=my');

$user_type = $user->type;
switch ($user_type) {
    case 'SuperAdmin':
        
        break;

    case 'Admin':
        $customers = $admin->listCustomer();
        break;

    case 'Customer':
        switch ($target) {
            case 'info':
                $genders = $config['gender'];
                if ($by_post) {
                    $realname = _post('realname');
                    $phone = _post('phone');
                    $gender = _post('gender');
                    $qq = _post('qq');
                    $email = _post('email');
                    $address = _post('address');

                    $user->edit(compact(
                        'realname',
                        'phone',
                        'email'));
                    $customer->edit(compact('qq', 'gender'));
                    $addr = $customer->defaultAddress();
                    $addr->edit(array('detail' => $address));

                    redirect('my/info');
                }

                
                break;
            case 'password':
                $msg = '';
                $ERROR_INFO = $config['error']['info'];
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
        break;
    
    default:
        throw new Exception('should not be here, user type: ' . $user_type);
        break;
}

if ($target === 'password') {
    $matter = 'password';
} else {
    $matter = "$view.$target";
}
$view = 'board?master';

$page['scripts'][] = 'jquery.validate.min';
