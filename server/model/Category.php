<?php

/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

class Category extends BasicModel
{
    public static $table = 'category';

    public static function jsonData($conds)
    {
        $kind = 'Category';
        list($tables, $conds, $orderby, $tail) = self::buildDbArgs($conds);
        $items = Pdb::fetchAll('*', $tables, $conds, $orderby, $tail);
        $itemCount = count($items);
        return compact('kind', 'totalItems', 'itemCount', 'items');
    }

    public static function buildDbArgs($conds)
    {
        extract($conds);
        $tail = "";
        $tables = array(self::$table);
        $conds = array('big_category' => $conds['BigCategoryId']);
        $orderby = array();
        return array($tables, $conds, $orderby, $tail);
    }
}
