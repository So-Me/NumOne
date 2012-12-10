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

    public static function jsonDatas($conds)
    {
        $totalItems = self::count($conds);
        $startIndex = $conds['startIndex'];
        $itemsPerPage = $conds['itemsPerPage'];
        $tail = "LIMIT $itemsPerPage OFFSET $startIndex";
        $fields = '*';
        if ($conds['distance'] && $conds['latilongi']) {
            list($laititude, $longitude) = break_laitilongi($latilongi);
            $fields .= ",( 6371 * acos( cos( radians($laititude) ) * cos( radians( lat ) ) * cos( radians( lng ) - radians($longitude) ) + sin( radians($laititude) ) * sin( radians( lat ) ) ) ) AS distance";
        }
        list($tables, $conds, $orderby) = self::buildDbArgs($conds);
        $items = Pdb::fetchAll($fields, $tables, $conds, $orderby, $tail);
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
        if (($categoryid)) {
            $conds['shop.category = ?'] = $categoryid;
        }
        if (!($categoryid) && ($bigcategoryid)) {
            $tables[] = Category::table() . ' AS c';
            $conds['shop.category = c.id'] = null;
            $conds['c.big_category'] = $bigcategoryid;
        }

        if (($districtid)) {
            $conds['shop.district = ?'] = $districtid;
        }
        if (!($district) && ($city)) {
            $tables[] = District::table() . ' AS d';
            $conds['shop.district = d.id'] = null;
            $conds['d.city = ?'] = $city;
        }
        if ($distance && $latilongi) {
            // $conds['shop.laititude > (? - 1)'] = $laititude;
            // $conds['shop.laititude < (? + 1)'] = $laititude;
            // $conds['shop.longitude > (? - 1)'] = $longitude;
            // $conds['shop.longitude < (? + 1)'] = $longitude;
            $conds["distance < ?"] = $distance / 1000.0;
        }
        $orderby = array();
        return array($tables, $conds, $orderby);
    }

    // 将经纬度拆开
    private static function expendInfo($info)
    {
        if (isset($info['latilongi'])) {
            if (preg_match('/^([\+|-]\d+\.\d+)([\+|-]\d+\.\d+)$/', $info['latilongi'], $matches)) {
                $info['laititude'] = $matches[1];
                $info['longitude'] = $matches[2];
            } else {
                throw new Exception("latilongi not right: $latilongi");
            }
        }
        return $info;
    }
}
