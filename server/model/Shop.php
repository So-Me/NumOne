<?php

/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

class Shop extends BasicModel
{
    public static function add($info)
    {
        $info = self::expendInfo($info);
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

    public static function count($conds = array())
    {
        extract(self::defaultConds($conds));
        list($tables, $conds) = self::buildDbArgs($conds);
        if ($distance && $latilongi) {
            list($latitude, $longitude) = break_latilongi($latilongi);
            $distanceExp = "((6371 * acos(cos(radians($latitude)) * cos(radians(shop.latitude)) * cos(radians(shop.longitude) - radians($longitude)) + sin(radians($latitude)) * sin(radians(shop.latitude)))) * 1000)";
            $conds["$distanceExp < ?"] = $distance;
        }
        return Pdb::count($tables, $conds);
    }

    public static function jsonDatas($conds)
    {
        extract(self::defaultConds($conds));
        $totalItems = self::count($conds);
        $startIndex = $conds['startIndex'];
        $itemsPerPage = $conds['itemsPerPage'];
        $tail = "LIMIT $itemsPerPage OFFSET $startIndex";
        list($tables, $conds) = self::buildDbArgs($conds);
        $fields = '*';
        $orderby = array();
        if ($distance && strlen($latilongi) > 0) {
            list($latitude, $longitude) = break_latilongi($latilongi);
            $distanceExp = "((6371 * acos(cos(radians($latitude)) * cos(radians(shop.latitude)) * cos(radians(shop.longitude) - radians($longitude)) + sin(radians($latitude)) * sin(radians(shop.latitude)))) * 1000)";
            $fields .= ", $distanceExp AS distance";
            $conds["distance < ?"] = $distance;
            $orderby[] = 'distance ASC';
        }

        $items = Pdb::fetchAll($fields, $tables, $conds, $orderby, $tail);
        $itemCount = count($items);
        if ($itemCount !== $totalItems) {
            d(Pdb::log());
            throw new Exception("itemCount: $itemCount, totalItems: $totalItems are not equal");
        }
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
        return Pdb::fetchAll('src', 'shop_image', array('shop = ?' => $this->id));
    }

    public static function buildDbArgs($conds)
    {
        $conds = self::defaultConds($conds);
        extract($conds);
        $tables = array(self::table()); // as 也可以去掉哦
        $conds = array();
        if (isset($categoryId) && $categoryId) {
            $conds['shop.category = ?'] = $categoryid;
        }
        if (!($categoryId) && ($bigCategoryId)) {
            $tables[] = Category::table() . ' AS c';
            $conds['shop.category = c.id'] = null;
            $conds['c.big_category'] = $bigCategoryId;
        }

        if (isset($districtId) && $districtId) {
            $conds['shop.district = ?'] = $districtId;
        }
        if (!($districtId) && ($cityId)) {
            $tables[] = District::table() . ' AS d';
            $conds['shop.district = d.Id'] = null;
            $conds['d.city = ?'] = $cityId;
        }
        return array($tables, $conds, $orderby = array(), '');
    }

    public static function defaultConds($conds = array())
    {
        return array_merge(
            array(
                'distance' => '',
                'latilongi' => '',
                'districtId' => '',
                'cityId' => '',
                'bigCategoryId' => '',
                'categoryId' => ''),
            $conds);
    }

    // 将经纬度拆开
    private static function expendInfo($info)
    {
        if (isset($info['latilongi'])) {
            list($info['latitude'], $info['longitude']) = break_latilongi($info['latilongi']);
        }
        return $info;
    }
}
