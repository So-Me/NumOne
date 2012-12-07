<?php

/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

class BigCategory extends BasicModel
{
    public static $table = 'big_category';

    public static readArray()
    {
        return Pdb::fetchAll('*', self::$table);
    }
}
