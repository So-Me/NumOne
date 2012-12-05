<?php

/**
 * I am the small order
 * @author  ryan <cumt.xiaochi@gmail.com>
 */
class Stone extends Model 
{
    public static $table = 'stone'; // when came across a key word

    public static function create() 
    {
        Pdb::insert(
            array('id=id' => null),
            self::$table);
        return new self(Pdb::lastInsertId());
    }

    public static function add($info)
    {
        Pdb::insert(
            array('weight' => $info['weight']),
            self::$table);
        return new self(Pdb::lastInsertId());
    }

    public function info()
    {
        $ret = Pdb::fetchRow('*', self::$table, $this->selfCond());
        return $ret;
    }
}
