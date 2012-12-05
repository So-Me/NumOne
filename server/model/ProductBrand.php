<?php

/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */
class ProductBrand extends Model 
{
    public static $table = 'product_brand';

    public static function read($conds = array())
    {
        $arr = Pdb::fetchAll('*', self::$table);
        if (empty($arr))
            return array();
        foreach ($arr as $info) {
            $ret[$info['id']] = $info['name'];
        }
        return $ret;
    }
}
