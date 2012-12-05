<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

if (!isset($user) || $user->type !== 'SuperAdmin')
    die('not permit');

switch ($target) {
    case '':
        $admins = $superadmin->listAdmin();
        break;

        case 'add':

        $msg = '';
        $ERROR_INFO = $config['error']['info'];       
        $username = _post('username');
        $password = _post('password');
        if ($by_post) {
            if (empty($username)) {
                $msg = $ERROR_INFO['USERNAME_EMPTY'];
            } elseif (empty($password)) {
                $msg = $ERROR_INFO['PASSWORD_EMPTY'];
            } elseif (User::find($username)) {
                $msg = $ERROR_INFO['USER_ALREADY_EXISTS'];
            } else {
                $superadmin->createAdmin(
                    compact(
                        'username', 
                        'password'
                    ));
                redirect($controller);
            }
        }
        break;
    
    default:
        throw new Exception("unkown target: $target");
        break;
}

$matter = "$view" . ($target? ".$target" : '');
$view = 'board?master';
