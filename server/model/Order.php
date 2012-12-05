<?php

/**
 * I am the small order
 * @author  ryan <cumt.xiaochi@gmail.com>
 */
class Order extends Model 
{
    public static $table = 'small_order'; // when came across a key word, what we could do?

    public function info()
    {
        $ret = Pdb::fetchRow('*', self::$table, $this->selfCond());
        return $ret;
    }

    public function customer()
    {
        $customer = $this->bigOrder()->customer();
        return $customer;
    }

    public function bigOrder()
    {
        return new bigOrder($this->big_order);
    }

    public function product()
    {
        return new Product($this->product);
    }

    public function factory()
    {
        // can be not set yet
        // what todo ?
        return new Factory($this->factory);
    }

    public function changeFactory(Factory $fac)
    {
        $arr = array(
            'factory' => $fac->id);
        
        $factory_id = $this->factory;
        if (empty($factory_id)) {
            $price = $this->defaultPriceData();
            $arr['factory_price'] = $price->id;
        }

        $this->update($arr);
    }

    public function priceData($name)
    {
        $name = strtolower($name . '_price');
        $id = $this->__get($name);
        if (empty($id)) {
            $price = $this->defaultPriceData();
            if ($name === 'customer_price') {
                $fpd = $this->priceData('factory');
                $st_weight = $fpd->st_weight + $this->factory_st_weight;
                $price->update('st_weight', $st_weight);
            }
            $this->update($name, $price->id);
            return $price;
        }
        return new PriceData($id);
    }

    public function stone() 
    {
        $stone_id = $this->stone;
        if (empty($stone_id)) {
            $stone = Stone::create();
            $stone_id = $stone->id;
            $this->edit('stone', $stone_id);
            $this->stone = $stone_id;
            return $stone;
        }
        return new Stone($this->stone);
    }

    public function stoneExists()
    {
        $stone_id = $this->stone;
        return !empty($stone_id);
    }

    public function changePrice($type, $info) 
    {
        $pd = $this->priceData($type);
        $pd->update($info);
    }

    public static function create(Customer $cus, Product $prd, $opts)
    {
        $material = $opts['material'];
        Pdb::insert(
            array_merge(
                $opts,
                array(
                    'product' => $prd->id,
                    'state' => 'InCart',
                    'estimate_price' => $prd->estimatePrice(compact('material')),
                    'add_cart_time=NOW()' => null)),
            self::$table);
        return new self(Pdb::lastInsertId());
    }

    public static function read($conds = array())
    {
        list($tables, $conds, $orderby, $tail) = self::buildDbArgs($conds);
        $ids = Pdb::fetchAll('o.id', $tables, $conds, $orderby, $tail);
        return safe_array_map(function ($id) {
            return new Order($id);
        }, $ids);
    }

    public function edit($key_or_array, $value = null)
    {
        if($value !== null) { // given by key => value
            $arr = array($key_or_array => $value);
        } else {
            $arr = $key_or_array;
        }
        Pdb::update($arr, self::$table, $this->selfCond());
    }

    public function addCustomized($info)
    {
        Pdb::insert(
            array_merge($info, array('is_customized' => 1)),
            self::$table);
        return new self(Pdb::lastInsertId());
    }

    public function defaultPriceData()
    {
        $product = $this->product();
        $info = array(
            'small_stone' => $product->small_stone,
            'gold_price' => Price::current($this->material),
            'labor_expense' => Setting::get('labor_expense'),
            'wear_tear' => Setting::get('wear_tear'),
            'st_price' => Setting::get('st_price'),
            'st_expense' => Setting::get('st_expense'),
            'st_weight' => $product->st_weight,
            'model_expense' => 0,
            'risk_expense' => Setting::get('risk_expense'));
        return PriceData::create($info);
    }

    public function submit()
    {
        $this->info = $this->info(); // why here?
        
        $material = $this->info['material'];
        Pdb::update(
            array(
                'state' => 'ToBeConfirmed',
                'submit_time=NOW()' => null,
                'factory_price' => 0, // 暂时不给，等到选择工厂的时候给
                'customer_price' => 0, // 暂时不给，等到confirm的时候，再给
                'real_price' => 0,
                'weight_ratio' => $material === 'PT950' ? Setting::get('weight_ratio') : 1),
            self::$table,
            $this->selfCond());

        Pdb::insert(
            array(
                'action' => 'SubmitOrder', // big order
                'target' => $this->id,
                'time = NOW()' => null,
                'info' => '提交订单'),
            UserLog::$table);
    }

    public function price() // we need that? may be not, del it !!!
    {
        // called from where?
        $customer_price = $this->priceData('customer');
        return $customer_price->finalPrice();
    }

    public function log()
    {
        $ret = Pdb::fetchAll(
            array(
                'info as remark',
                'time'),
            UserLog::$table,
            array(
                'action LIKE ?' => '%Order',
                'target=?' => $this->id));
        return  (empty($ret))? array() : $ret;
    }

    public static function buildDbArgs($conds = array()) // we need that function?
    {
        $conds = self::defaultConds($conds);
        extract(array_merge(
            array(
                'username' => '',
                'factory' => '',
                'factory_id' => null,
                'customer' => null,
                'name' => '',
                'product_no' => '',
                'order_no' => '',
                'time_start' => '',
                'time_end' => '',
                'type' => null,
                'state' => null),
            $conds));
        $tables = array(self::$table . ' as o', BigOrder::$table . ' as b');
        $conds = array('b.id = o.big_order' => null);
        if ($name)
            $conds['p.name LIKE ?'] = '%' . $name . '%';
        if ($product_no) {
            $conds['p.no=?'] = $product_no;
        }
        if ($order_no) {
            $conds['bn.sn=?'] = $order_no;
        }
        if ($time_start)
            $conds['o.submit_time >= ?'] = $time_start;
        if ($time_end)
            $conds['o.submit_time <= ?'] = $time_end;
        if ($type) {
            $conds['p.type=?'] = $type;
        }
        if ($state) {
            $conds['o.state=?'] = $state;
        } else {
            $conds['o.state <> ?'] = 'InCart'; // for all
        }
        if ($username) {
            $user = User::createByName($username);
            $customer = $user->instance();
            $conds['o.customer=?'] = $customer->id;
        }
        if ($factory) {
            $factory = Factory::createByName($factory);
            if (empty($factory))
                throw new Exception("cannot find factory: $factory");
            $conds['o.factory=?'] = $factory->id;
        }
        if ($factory_id) {
            $conds['o.factory = ?'] = $factory_id;
        }
        if ($customer) {
            if (is_numeric($customer)) {
                $conds['o.customer=?'] = $customer;
            }
        }
        if ($name || $product_no || $type) {
            $tables[] = Product::$table . ' as p';
        }
        $orderby = array('b.id');
        $tail = "LIMIT $limit OFFSET $offset";
        return array($tables, $conds, $orderby, $tail);
    }
}
