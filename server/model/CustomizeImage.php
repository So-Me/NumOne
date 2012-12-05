<?php
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */
class CustomizeImage extends Model 
{
    public static $table = 'customize_image';

    public static function add($info)
    {
        $order_id = $info['order'];
        $images = $info['images'];
        foreach ($images as $i) {
            Pdb::insert(
                array(
                    'image' => $i,
                    '`order`' => $order_id),
                self::$table);
        }
    }
}
