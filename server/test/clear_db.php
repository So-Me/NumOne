<?php

// 这里面经过了一次修改，但是没有测试，请后来者测试一下

// clear user
Pdb::del(User::$table, array("name LIKE ?" => '%test%'));

// clear customer
clear_1m_db(User::$table, Customer::$table);

// clear factory
Pdb::del(Factory::$table, array("name LIKE ?" => '%test%'));

// clear product
Pdb::del(Product::$table, array('name LIKE ?' => '%test%'));

// clear cart and order
clear_relation_db(Customer::$table, Order::$table, Cart::$table);

// clear big order and small order
clear_1m_db(Customer::$table, BigOrder::$table);
clear_1m_db(Customer::$table, BigOrder::$table); 

// clear address
clear_relation_db(Customer::$table, Address::$table);

// clear user log
clear_1m_db(Customer::$table, UserLog::$table, 'subject');

// clear account
clear_11_db(Customer::$table, Account::$table);

// clear account log
clear_1m_db(Account::$table, AccountHistory::$table);

// clear price_data
$pds = Pdb::fetchAll('id', PriceData::$table);
if ($pds) {
    $tbl = Order::$table;
    foreach ($pds as $id) {
        $cond1 = array('factory_price = ?' => $id);
        $cond2 = array('customer_price = ?' => $id);
        if (!Pdb::exists($tbl, $cond1) && !Pdb::exists($tbl, $cond2)) {
            Pdb::del(PriceData::$table, array('id = ?' => $id));
        }
    }
}

// clear stone
clear_11_db(Order::$table, Stone::$table);

if (_get('exit')) {
    echo '<script src="static/hide.js"></script>';
    echo '<div class="conclusion pass">All Clear!</div>';
    exit;
}
