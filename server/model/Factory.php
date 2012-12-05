<?php

/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */
class Factory extends Model 
{
    public static $table = 'factory';

    public static function createByName($name)
    {
        $id = Pdb::fetchRow('id', self::$table, array('name = ?' => $name));
        if ($id) {
            return new self($id);
        } else {
            return false;
        }
    }

    public function info()
    {
        return Pdb::fetchRow('*', self::$table, $this->selfCond());
    }

    public static function names()
    {
        $arr = Pdb::fetchAll('id, name', self::$table);
        $ret = array();
        foreach ($arr as $entry) {
            $ret[$entry['id']] = $entry['name'];
        }
        return $ret;
    }

    public function account()
    {
        $account_id = $this->account;
        if (empty($account_id)) {
            $account = Account::create();
            $this->edit('account', $account->id);
            return $account;
        }
        return new Account($this->account);
    }

    public function stAccount()
    {
        $account_id = $this->st_account;
        if (empty($account_id)) {
            $account = Account::create();
            $this->edit('st_account', $account->id);
            return $account;
        }

        return new Account($this->st_account);
    }

    public function accountRecords($conds)
    {
        $order_id = $conds['order'];
        return Pdb::fetchAll(
            '*',
            AccountHistory::$table,
            array(
                'account = ?' => $this->account()->id,
                '`order` = ?' => $order_id));
    }
}
