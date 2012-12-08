<?php

/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

class BigCategory extends BasicModel
{
    public static $table = 'big_category';

    public static function jsonData()
    {
        $items = Pdb::fetchAll('*', self::$table);
        $itmeCount = count($items);
        $kind = self::$table;
        return compact('kind', 'itmeCount', 'items');
    }
}
