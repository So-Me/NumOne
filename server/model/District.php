<?php

/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

class District extends BasicModel
{
    public static function add(City $c, $name)
    {
        Pdb::insert(
            array('city' => $c->id, 'name' => $name), 
            self::table());
        return new self(Pdb::lastInsertId());
    }
}
