<?php

/**
 *
 * @author  ryan <cumt.xiaochi@gmail.com>
 */
class BigOrder extends Model 
{
    public static $table = 'big_order';

    public static function read($conds)
    {
        list($tables, $conds, $orders, $tail) = self::buildDbArgs($conds);
        $arr = Pdb::fetchAll('b.id as bid, o.id as oid', $tables, $conds, $orders, $tail);
        $temp_arr = array();
        if (empty($arr))
            return array();
        foreach ($arr as $pair) {
            $big = $pair['bid'];
            if (isset($temp_arr[$big])) {
                $temp_arr[$big][] = new Order($pair['oid']);
            } else {
                $temp_arr[$big] = array(new Order($pair['oid']));
            }
        }
        $ret = array();
        foreach ($temp_arr as $big_id => $small_arr) {
            $ret[] = array(
                'big' => new self($big_id),
                'small' => $small_arr);
        }
        return $ret;
    }

    public static function addByCustomer(Customer $cus, $orders)
    {
        Pdb::insert(
            array(
                'id=id' => null,
                'sn' => self::makeOrderSn(),
                'customer' => $cus->id,
                'address' => $cus->defaultAddress()->id,
                'create_time = NOW()' => null), 
            self::$table);
        $id = Pdb::lastInsertId();
        foreach ($orders as $order) {
            $order->edit('big_order', $id);
            $order->submit();
        }

        // there should be UserLog::add(para);
        Pdb::insert(
            array(
                'subject' => $cus->id,
                'action' => 'SubmitBigOrder', // big order
                'target' => $id,
                'time = NOW()' => null,
                'info' => $cus->user()->realname . ' 提交订单'),
            UserLog::$table);
        return new self($id);
    }

    public static function createFromCart(Cart $cart)
    {
        return self::addByCustomer($cart->owner(), $cart->orders());
    }

    public static function addCustomized(Customer $cus, $orders)
    {
        return self::addByCustomer($cus, $orders);
    }

    public function customer() 
    {
        return new Customer($this->customer);
    }

    public function address()
    {
        return new Address($this->address);
    }

    public function orders()
    {
        return safe_array_map(function ($id) {
            return new Order($id);
        }, Pdb::fetchAll('id', Order::$table, array('big_order = ?' => $this->id)));
    }

    public static function makeOrderSn()
    {
        $year_str = chr(ord('A') + date('Y') - 2012);
        $date_part = $year_str . strtoupper(dechex(date('m'))) . date('d');
        $time_part = substr(time(), -5);
        $microtime_part = substr(microtime(), 2, 3);
        $order_sn = $date_part . $time_part . $microtime_part;
        return $order_sn;
    }

    public static function buildDbArgs($conds)
    {
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
                'state' => null,
                'limit' => 10,
                'offset' => 0),
            $conds));
        $tables = array(self::$table . ' as b', Order::$table . ' as o');
        $conds = array('o.big_order = b.id' => null);

        if ($name || $product_no || $type) {
            $tables[] = Product::$table . ' as p';
            $conds['o.product = p.id'] = null;
        }

        if ($name)
            $conds['p.name LIKE ?'] = '%' . $name . '%';
        if ($product_no) {
            $conds['p.no=?'] = $product_no;
        }
        if ($order_no) {
            $conds['b.sn = ?'] = $order_no;
        }
        if ($time_start)
            $conds['o.submit_time >= ?'] = $time_start;
        if ($time_end)
            $conds['o.submit_time <= ?'] = $time_end;
        if ($type) {
            $conds['p.type=?'] = $type;
        }
        // we can del this?
        if ($state) {
            $conds['o.state=?'] = $state;
        } else {
            $conds['o.state <> ?'] = 'InCart'; // for all
        }
        if ($username) {
            $user = User::createByName($username);
            $customer = $user->instance();
            $conds['b.customer=?'] = $customer->id;
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
                $conds['b.customer=?'] = $customer;
            }
        }
        
        $orderby = array('b.id DESC');
        $tail = "LIMIT $limit OFFSET $offset";
        return array($tables, $conds, $orderby, $tail);
    }
}
