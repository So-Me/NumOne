<?php

/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */
class PriceData extends Model 
{
    public static $table = 'price_data';

    public static function create($info)
    {
        Pdb::insert($info, self::$table);
        return new self(Pdb::lastInsertId());
    }

    public function info()
    {
        return Pdb::fetchRow('*', self::$table, $this->selfCond());
    }

    public function finalPrice()
    {
        if ($this->final_price === null) {
            // caculate
            $fp = ($this->gold_weight + $this->gold_weight * $this->wear_tear / 100.0) * $this->gold_price
                + $this->labor_expense + $this->small_stone * $this->st_expense
                + $this->st_price * $this->st_weight
                + $this->model_expense + $this->risk_expense;
            $this->final_price = $fp;
        }
        return +$this->final_price;
    }
}
