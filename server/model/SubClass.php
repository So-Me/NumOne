<?php
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */
class SubClass extends BasicModel
{
    public static function add($parent, $name)
    {
        $parentClass = get_class($parent);
        $refKey = camel2under($parentClass);
        $class = get_called_class();
        Pdb::insert(
            array($refKey => $parent->id, 'name' => $name), 
            $class::table());
        return new $class(Pdb::lastInsertId());
    }

    public static function readArray()
    {
        $arr = Pdb::fetchAll('*', self::table());
        $ret = array();
        foreach ($arr as $info) {
            $ret[$info['id']] = $info['name'];
        }
        return $ret;
    }

    public static function jsonData($conds = array())
    {
        $kind = get_called_class();
        list($tables, $conds) = $kind::buildDbArgs($conds);
        $items = Pdb::fetchAll('*', $tables, $conds);
        $itemCount = count($items);
        $totalItems = $itemCount;
        return compact('kind', 'totalItems', 'itemCount', 'items');
    }

    public static function buildDbArgs($conds)
    {
        $tables = self::table();
        $retConds = array();
        foreach ($conds as $key => $value) {
            if (preg_match('/([a-z].+)Id/', $key, $matches)) {
                // for bigCategoryId
                $ref_key = camel2under($matches[1]); // camelCase to under_score
                $retConds["$ref_key = ?"] = $value;
            }
        }
        return array($tables, $retConds);
    }
}
