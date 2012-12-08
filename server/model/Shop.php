<?php

/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

class Shop extends BasicModel
{
    public static function add($info)
    {
        if (isset($info['images'])) {
            $images = $info['images'];
            unset($info['images']);
        }
        Pdb::insert($info, self::table());
        $shop = new self(Pdb::lastInsertId());
        if (isset($images)) {
            foreach ($images as $img_src) {
                ShopImage::add($shop, $img_src);
            }
        }
        return $shop;
    }

    public static function jsonDatas($conds)
    {
        $totalItems = self::count($conds);
        $startIndex = $conds['startIndex'];
        $itemsPerPage = $conds['itemsPerPage'];
        $tail = "LIMIT $itemsPerPage OFFSET $startIndex";
        list($tables, $conds, $orderby) = self::buildDbArgs($conds);
        $items = Pdb::fetchAll('*', $tables, $conds, $orderby, $tail);
        $itemCount = count($items);
        return compact('startIndex', 'totalItems', 'startIndex', 'itemsPerPage', 'itemCount', 'items');
    }

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

    public static function buildDbArgs($conds)
    {
        extract($conds);
        $tables = array(self::table()); // as 也可以去掉哦
        $conds = array();
        if (isset($categoryid)) {
            $conds['shop.category = ?'] = $categoryid;
        }
        if (!isset($categoryid) && isset($bigcategoryid)) {
            $tables[] = Category::table() . ' AS c';
            $conds['shop.category = c.id'] = null;
            $conds['c.big_category'] = $bigcategoryid;
        }

        if (isset($districtid)) {
            $conds['shop.district = ?'] = $districtid;
        }
        if (!isset($district) && isset($city)) {
            $tables[] = District::table() . ' AS d';
            $conds['shop.district = d.id'] = null;
            $conds['d.city = ?'] = $city;
        }
        $orderby = array();
        return array($tables, $conds, $orderby);
    }
}
