<?php

/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

class City extends BasicModel
{
    public static function add(Province $p, $name)
    {
        Pdb::insert(
            array('province' => $p->id, 'name' => $name), 
            self::table());
        return new self(Pdb::lastInsertId());
    }
}
