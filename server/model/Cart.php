<?php

/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */
class Cart
{
    private $orders = null;
    public static $table = 'cart';

    private function __construct($owner_id)
    {
        $this->owner_id = $owner_id;
    }

    public static function createFromCustomer(Customer $cus)
    {
        $cart = new Cart($cus->id);
        return $cart;
    }

    // just like normal info(), so cache it
    public function orders() {
        if ($this->orders != null)
            return $this->orders;
        $ids = Pdb::fetchAll('small_order', self::$table);
        return $this->orders = safe_array_map(function ($id) { return new Order($id); }, $ids); // no paging here
    }

    public function count()
    {
        $count = Pdb::count(
            self::$table,
            array('customer=?' => $this->owner_id));
        return (int) $count;
    }

    public function totalPrice()
    {
        $orders = $this->orders();
        $price_arr = array_map(function ($order) {
            return $order->estimate_price;
        }, $orders);
        return array_sum($price_arr);
    }

    public function del(Order $order)
    {
        Pdb::del(
            self::$table, 
            array(
                'customer=?' => $this->owner_id, 
                'order=?' => $order->id));
    }

    public function owner()
    {
        return new Customer($this->owner_id);
    }
}
