<?php
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */
class Admin extends Model 
{
    public static $table = 'admin';
    
    public function editOrder(Order $order, $settings)
    {
        Pdb::update($settings, Order::$table, array('id=?' => $order->id));
    }

    public function setOrderState(Order $order, $state)
    {
        $this->editOrder($order, array('state' => $state));
    }

    public function addCustomer($info) 
    {
        $cus = Customer::create(array_merge(
            $info,
            array('adopted' => 1)));
        $addr = $cus->defaultAddress();
        extract($info);
        if ($realname || $phone || $address)
            $addr->edit(array(
                'name' => $realname,
                'phone' => $phone,
                'detail' => $address));
    }

    public function adoptCustomer(Customer $cus)
    {
        Pdb::update(array('adopted' => 1), Customer::$table, array('id=?' => $cus->id));
    }

    public function countCustomer($conds = array())
    {
        extract(self::buildDbArgs($conds));
        return Pdb::count($tables, $conds);
    }

    // why not customers()
    public function listCustomer($conds = array())
    {
        extract(self::defaultConds($conds));
        $tail = "LIMIT $limit OFFSET $offset";

        extract(self::buildDbArgs($conds)); // 数据库的条件

        if (isset($adopted)) {
            $conds['adopted=?'] = $adopted ? 1 : 0;
        }
        $cus_infos = Pdb::fetchAll('c.id', $tables, $conds, null, $tail);
        return safe_array_map(function ($id) {
            return new Customer($id);
        }, $cus_infos);
    }

    public function rechargeAccount(Account $account, $money, $remark = '')
    {
        $account->recharge($money);

        // log
        AccountHistory::add(array(
            'account' => $account->id,
            'name' => '充值',
            'money' => $money,
            'type' => 'recharge',
            'remain' => $account->remain,
            'pay_type' => '转账',
            'remark' => $remark));
    }

    public function deductAccountForOrder(Account $account, Order $order, $money, $remark = '')
    {
        $account->deduct($money);

        // log
        Pdb::insert(
            array(
                'subject' => $this->id,
                'action' => 'DeductAccount',
                'target' => $order->id,
                'info' => json_encode(compact('money', 'remark')),
                'time=NOW()' => null),
            UserLog::$table);

        // accout log
        AccountHistory::add(array(
            'account' => $account->id,
            'name' => '订单扣款',
            '`order`' => $order->id,
            'money' => $money,
            '`type`' => 'consume',
            'remain' => $account->remain(),
            'pay_type' => '账户扣款'));
    }

    public function useStoneForOrder(Factory $factory, Order $order, $weight, $num, $remark = '')
    {
        $account = $factory->stAccount();

        $to_deduct = $weight;

        // 如果管理员不停地改价格
        $conds = array(
            'account = ?' => $account->id,
            '`order` = ?' => $order->id,
            'type = ?' => 'factory');
        $arr = Pdb::fetchRow('id, money', AccountHistory::$table, $conds);
        if ($arr) {
            Pdb::update(
                array('remark' => '作废'),
                AccountHistory::$table, 
                array('id = ?' => $arr['id']));
            $to_deduct = $weight - $arr['money'];
        }

        $account->deduct($to_deduct);

        // log 
        AccountHistory::add(array(
            'account' => $account->id,
            'name' => '工厂用料',
            '`order`' => $order->id,
            'money' => $weight, // 貌似这个名字叫做value 更好
            'type' => 'factory',
            'pay_type' => '工厂用料',
            'remain' => $account->remain()));
    }

    public function addFactory($para)
    {
        Pdb::insert(
            array_merge(
                $para,
                array('create_time=NOW()' => null)),
            Factory::$table);
        return new Factory(Pdb::lastInsertId());
    }

    public function listFactory($conds = array()) 
    {
        extract(self::defaultConds($conds));
        $tail = "LIMIT $limit OFFSET $offset";
        return safe_array_map(function ($id) {
            return new Factory($id);
        }, Pdb::fetchAll('id', Factory::$table, null, null, $tail));
    }

    public function postProduct($info)
    {
        Pdb::insert(
            array_merge(
                $info,
                array('post_time=NOW()' => null)),
            Product::$table);
        return new Product(Pdb::lastInsertId());
    }

    public function delProduct($arg) {
        $prds = is_array($arg) ? $arg : array($arg);
        foreach ($prds as $prd) {
            if ($prd instanceof Product) {
                $id = $prd->id;
            } elseif (is_numeric($prd)) {
                $id = $prd;
            } else {
                d($arg);
                throw new Exception("not good arg for del Product");
            }
            Pdb::del(
                Product::$table,
                array('id=?' => $id));
        }
    }

    public function updatePrice($type, $price)
    {
        Price::update($type, $price);
    }

    private static function buildDbArgs($conds = array()) 
    {
        extract($conds);

        $conds = array();
        $tables = array(
            User::$table . ' as u',
            Customer::$table . ' as c');
        if ($name)
            $conds['u.realname LIKE ?'] = '%' . $name . '%';
        if ($username)
            $conds['u.name LIKE ?'] = '%' . $username . '%';

        // a little bit difficult
        if ($time_start)
            $conds['o.submit_time >= ?'] = $time_start;
        if ($time_end) 
            $conds['o.submit_time <= ?'] = $time_end;
        if ($time_start || $time_end) {
            $conds['o.customer=c.id'] = null;
            $tables[] = Order::$table . ' as o';
        }

        if ($state)
            $conds['c.state=?'] = $state;

        $conds['c.user=u.id'] = null;
        return compact('conds', 'tables');
    }

    public function sendOrderToFactory(Order $order, Factory $factory = null)
    {
        $this->setOrderState($order, 'InFactory');
        if (empty($factory)) {
            $factory = $order->factory();
        }
        $price = $order->priceData('factory')->finalPrice();
        Pdb::update(
            array('undone = undone + ?' => $price),
            Factory::$table,
            $factory->selfCond());
    }

    public function confirmOrder(Order $order)
    {
        $customer_price = $order->defaultPriceData();
        $state = 'InFactory';

        $order->update(array(
                'state' => $state,
                'customer_price' => $customer_price->id,
                'confirm_time=NOW()' => null));

        // 记录日志
        UserLog::adminDealOrder($this, 'confirm', $order, '确认订单');

        return $state;
    }

    public function payFactoryForOrder($factory, $order, $money, $remark = '')
    {
        $account = $factory->account();
        $account->deduct($money);

        $order->update(array('paid_factory = paid_factory + ?' => $money));

        $factory->update(array('undone = undone - ?' => $money));

        $arr = array(
            'account' => $account->id,
            '`order`' => $order->id,
            'money' => $money,
            'remark' => $remark);
        AccountHistory::add($arr);

    }
    public function payOrder(Order $order, $deduct, $remark = '')
    {
        if (!is_numeric($deduct))
            throw new Exception("money not numeric: $deduct");
        $customer = $order->customer();
        $account = $customer->account(); // where is customer?
        $this->deductAccountForOrder($account, $order, $deduct, $remark);
        // 关于在这里引起混乱的财务问题，我们还是使用update语句吧
        // db 是该改改了
        Pdb::update(
            array("paid = paid + '$deduct'" => null), 
            Order::$table, 
            $order->selfCond());
        // $order->edit('paid', $order->paid + $deduct);
    }

    public function factoryDoneOrder(Order $order)
    {
        $state = 'FactoryDone';
        Pdb::update(
            array(
                'state' => $state,
                'factory_done_time=NOW()' => null),
            Order::$table);

        // 卖出去的数量 +1
        Pdb::update(
            array('sold_count=sold_count+1' => null),
            Product::$table,
            array('id=?' => $order->product()->id));

        UserLog::adminDealOrder($this, 'factoryDone', $order, '工厂完成');

        return $state;
    }

    public function doneOrder(Order $order)
    {
        $state = 'Done';
        Pdb::update(
            array(
                'state' => $state,
                'done_time=NOW()' => null),
            Order::$table,
            array('id = ?' => $order->id));

        UserLog::adminDealOrder($this, 'done', $order, '交易完成');

        return $state;
    }
}
