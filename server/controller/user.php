<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

if ($user_type !== 'Admin')
    die('no permission');

$customer_states = $config['customer_state'];

switch ($target) {
    case '':

        $name = _get('name');
        $username = _get('username');
        $time_start = _get('time_start');
        $time_end = _get('time_end');
        $state = _get('state');

        $conds = compact(
            'name',
            'username',
            'time_start',
            'time_end',
            'state');

        $limit = 50;
        $total = $admin->countCustomer($conds);
        $paging = new Paginate($limit, $total);
        $paging->setCurPage(_get('p') ?: 1);

        $conds = array_merge(
            $conds,
            array(
                'limit' => $limit,
                'offset' => $paging->offset()));

        $customers = $admin->listCustomer($conds);

        break;

    case 'add':
        list(
            $username,
            $password,
            $realname,
            $phone,
            $qq,
            $email,
            $address,
            $remark
        ) = _post(
            'username',
            'password',
            'realname',
            'phone',
            'qq',
            'email',
            'address',
            'remark');
        if ($by_post) {
            $admin->addCustomer(compact(
                'username',
                'password',
                'realname',
                'phone',
                'qq',
                'email',
                'address',
                'remark'));
            redirect('user');
        }
        break;

    case 'adopt':
        break;
        
    default:
        if (!is_numeric($target)) {
            throw new Exception("unknown: $target, is it a customer?");
        }
        $cus_id = $target;
        switch ($action) {
            case '':
                // do nothing
                break;

            case 'get_edit_div':
                if (!$by_ajax) {
                    throw new Exception("$action must be get by ajax");
                }
                $cus = new Customer($cus_id);
                $user_ = $cus->user();

                $div_name = 'user-edit';
                $view_name = 'user.edit';
                include smart_view('append.div');
                exit;

            case 'get_recharge_div':
                $cus = new Customer($cus_id);
                $user_ = $cus->user();
                $account = $cus->account();

                $view_name = 'user.account.recharge';
                include smart_view('append.div');
                exit;

            case 'recharge':
                $cus = new Customer($cus_id);
                $account = $cus->account();
                $money = _get('money');
                $remark = _get('remark');
                $admin->rechargeAccount($account, $money, $remark);
                redirect('user/' . $cus->id . '/account');
                break;

            case 'edit':
                if ($by_post) {
                    $cus = new Customer($cus_id);

                    $username = _post('username');
                    $password = _post('password');
                    $realname = _post('realname');
                    $phone = _post('phone');
                    $qq = _post('qq');
                    $email = _post('email');
                    $address = _post('address');
                    $remark = _post('remark');
                    $state = _post('state');

                    $user_ = $cus->user();
                    if ($password) {
                        $user_->changePassword($password);
                    }
                    if ($username || $realname || $phone || $email) {
                        $user_->edit(array(
                            'name' => $username,
                            'realname' => $realname,
                            'phone' => $phone,
                            'email' => $email));
                    }
                    if ($qq || $remark || $state) {
                        $cus->edit(compact('qq', 'remark', 'state'));
                    }
                    if ($address) {
                        $addr = $cus->defaultAddress();
                        $addr->edit(array('detail' => $address));
                    }
                    redirect('user');
                }
                break;
            
            default:
                throw new Exception("unkonw action: $action");
                break;
        }
        break;
}

// account
if ($argument === 'account') {
    $cus = new Customer($cus_id);
    $user_ = $cus->user();
    $account = $cus->account();

    $time_start = _get('time_start');
    $time_end = _get('time_end');
    $type = _get('type');
    $sort = _get('sort');

    $sorts = $config['account_sort'];

    $conds = compact(
        'time_start',
        'time_end',
        'type',
        'sort');

    $per_page = 50;
    $total = $account->countHistory($conds);
    $paging = new Paginate($per_page, $total);
    $paging->setCurPage(_get('p') ?: 1);
    $types = $config['account_type'];

    $history = $account->history(array_merge(
        $conds,
        array(
            'limit' => $per_page,
            'offset' => $paging->offset())));

    $matter = $view . '.account';

} else {
    $matter = $view . ($target? ".$target" : '');
}

$view = 'board?master';

$page['scripts'][] = 'jquery.validate.min';
