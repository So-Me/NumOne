<?php

/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

class BigCategory extends BasicModel
{
    public static $table = 'big_category';

    public static function jsonData($conds = array())
    {
        list($tables, $conds, $orderby, $tail) = slef::buildDbArgs($conds);
        $items = Pdb::fetchAll('*', $tables, $conds, $orderby, $tail);
        $itmeCount = count($items);
        $kind = self::$table;
        return compact('kind', 'itmeCount', 'items');
    }

    public static function buildDbArgs($conds)
    {
        $tables = array(self::$table);
        $conds = ;
        $orderby = array();
        $tail = "LIMIT $itemPerPage OFFSET $startIndex";
        return array($tables, $conds, $orderby, $tail);
    }
}
