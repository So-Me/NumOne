<?php

/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

class ShopImage extends BasicModel
{
    public static $table = 'shop_image';

    public static function add(Shop $shop, $src)
    {
        Pdb::insert(array('shop' => $shop->id, 'src' => $src), self::$table);
    }
}
