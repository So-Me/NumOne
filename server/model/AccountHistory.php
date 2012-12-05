<?php

/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */
class AccountHistory extends Model
{
    public static $table = 'account_log';

    public function info()
    {
        return Pdb::fetchRow('*', self::$table, $this->selfCond());
    }

    public function order()
    {
        return new Order($this->order);
    }

    public function add($arr)
    {
        Pdb::insert(
            array_merge(
                $arr, 
                array(
                    'time = NOW()' => null, 
                    'ms' => substr(microtime(), 2, 3))),
            self::$table);
    }
}
