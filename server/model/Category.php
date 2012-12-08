<?php

/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

class Category extends BasicModel
{
    public static $table = 'category';

    public static jsonData($conds)
    {
        $kind = 'Category';
        $startIndex = $conds['startIndex'];
        $itemsPerPage = $conds['itemsPerPage'];
        list($tables, $conds, $orderby, $tail) = slef::buildDbArgs($conds);
        $items = Pdb::fetchAll('*', $tables, $conds, $orderby, $tail);
        $itemCount = count($items);
        return compact('kind', 'totalItems', 'startIndex', 'itemPerPage', 'itemCount', 'items');
    }

    public static function buildDbArgs($conds)
    {
        extract($conds);
        $tail = "LIMIT $itemPerPage OFFSET $startIndex";
        $tables = array(self::$table);
        $conds = array('big_category' => $conds['BigCategory']);
        $orderby = array();
        return array($tables, $conds, $orderby, $tail);
    }
}
