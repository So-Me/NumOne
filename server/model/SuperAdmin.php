<?php

/**
 *
 * @author  ryan <cumt.xiaochi@gmail.com>
 */
class SuperAdmin extends Model 
{
    public static $table = 'super_admin';
    
    public function createAdmin($opts)
    {
        Pdb::insert(
            array(
                'name' => $opts['username'],
                'password' => md5($opts['password']),
                'type' => 'Admin',
                'create_time=NOW()' => null
            ),
            User::$table
        );
        return new Admin(Pdb::lastInsertId());
    }

    public function listAdmin($conds = array())
    {
        extract(self::defaultConds($conds));
        $conds = array('type=?' => 'Admin');
        $tail = "LIMIT $limit OFFSET $offset";
        return safe_array_map(function ($info) {
            return new Admin($info);
        }, Pdb::fetchAll('*', User::$table, $conds, array(), $tail));
    }
}
