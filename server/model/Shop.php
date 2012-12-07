<?php

/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

class Shop extends BasicModel
{
    public static $table = 'shop';

    public function infoArray()
    {
        $info = $this->info(); // is this efficient?
        $info['images'] = $this->images();
        return $info;
    }

    public function images()
    {
        return Pdb::fetch('src', 'shop_image', array('shop = ?' => $this->id));
    }
}
