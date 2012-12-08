<?php

/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

class Province extends BasicModel
{
    public static function add($name)
    {
        Pdb::insert(compact('name'), self::table());
        return new self(Pdb::lastInsertId());
    }
}
