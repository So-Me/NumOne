<?php

/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */
class Account extends Model 
{
    public static $table = 'account';

    public function info()
    {
        return Pdb::fetchRow('*', self::$table, $this->selfCond());
    }

    public function remain()
    {
        return Pdb::fetchRow('remain', self::$table, $this->selfCond());
    }

    public static function create()
    {
        Pdb::insert(
            array(
                'remain' => 0,
                'done' => 0,
                'undone' => 0,),
            Account::$table);
        return new self(Pdb::lastInsertId());
    }

    public function recharge($money)
    {
        Pdb::update(
            array("remain = remain+'$money'" => null),
            self::$table);
    }

    // 这里注意！可能导致数据不一致，解决方案是只使用log db(innoDB)来获得余额
    public function deduct($money, $num = 0)
    {
        if (!is_numeric($money) || !is_numeric($num)) {
            throw new Exception("money must be numeric: $money");
        }
        Pdb::update(
            array("remain = remain - ?" => $money),
            self::$table,
            $this->selfCond());
    }

    public function countHistory($conds = array())
    {
        extract($this->buildHistoryArg($conds));
        return Pdb::count(AccountHistory::$table, $conds);
    }

    public function history($conds = array())
    {
        extract($conds);
        $tail = "LIMIT $limit OFFSET $offset";
        extract($this->buildHistoryArg($conds));
        if (!isset($sort) || empty($sort)) {
            $sort = 'DESC';
        }
        $order = array("time $sort, ms DESC");
        $ids = Pdb::fetchAll('id', AccountHistory::$table, $conds, $order);
        return safe_array_map(function ($id) {
            return new AccountHistory($id);
        }, $ids);
    }

    private function buildHistoryArg($conds)
    {
        extract(array_merge(
            array(
                'time_start' => '',
                'time_end' => '',
                'type' => ''),
            $conds));
        $conds = array('account=?' => $this->id);
        if (($time_start)) {
            $conds['time >= ?'] = $time_start;
        }
        if (($time_end))
            $conds['time <= ?'] = $time_end;
        if (($type))
            $conds['type=?'] = $type;
        return compact('conds');
    }
}
