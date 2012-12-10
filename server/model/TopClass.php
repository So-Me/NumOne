<?php

/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

class TopClass extends BasicModel
{
    public static function add($name)
    {
        $className = get_called_class();
        Pdb::insert(compact('name'), $className::table());
        return new $className(Pdb::lastInsertId());
    }

    public static function jsonData($conds = array())
    {
        $kind = get_called_class();
        $items = Pdb::fetchAll('*', $kind::$table);
        $itemCount = count($items);
        $totalItems = $itemCount;
        return compact('kind', 'totalItems', 'itemCount', 'items');
    }
}
