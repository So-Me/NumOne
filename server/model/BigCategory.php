<?php

/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

class BigCategory extends BasicModel
{
    public static $table = 'big_category';

    public static function jsonData($conds = array())
    {
        $items = Pdb::fetchAll('*', self::$table);
        $itemCount = count($items);
        $kind = self::$table;
        $totalItems = $itemCount;
        return compact('kind', 'totalItems', 'itemCount', 'items');
    }
}
