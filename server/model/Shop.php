<?php

/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

class Shop extends BasicModel
{
    public static $table = 'shop';

    public function jsonData()
    {
        $info = $this->infoArray();
        $info['kind'] = 'Shop';
        return $info;
    }

    public function infoArray()
    {
        $info = $this->info(); // is this efficient?
        $images = $this->images();

        $info['images'] = $images;
        $info['imageCount'] = count($images);
        return $info;
    }

    public function images()
    {
        return Pdb::fetch('src', 'shop_image', array('shop = ?' => $this->id));
    }
}
