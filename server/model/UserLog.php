<?php

/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */
class UserLog
{
    public static $table = 'user_log';

    public function add($args)
    {
        Pdb::insert(
            array_merge($args, array('time = NOW()')),
            self::$table);
    }

    public static function history()
    {
        return safe_array_map(function ($info) {
            $info['user'] = new User($info['user']);
            return $info;
        }, Pdb::fetchAll('*', self::$table));
    }

    public static function userLogin($user_id)
    {
        Pdb::insert(
            array(
                'subject' => $user_id,
                'action' => 'Login',
                'info' => i($_SERVER['REMOTE_ADDR']), // ip
                'time=NOW()' => null
            ),
            self::$table);
    }

    public static function adminDealOrder(Admin $admin, $action, Order $order, $remark = '')
    {
        Pdb::insert(
            array(
                'subject' => $admin->id,
                'action' => $action . 'Order',
                'target' => $order->id,
                'info' => $remark,
                'time=NOW()' => null),
            self::$table);
    }
}
