<?php

/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */
class Statistics
{
    public static function saleRecord($opts)
    {
        extract($opts);

        $interval = DateInterval::createFromDateString("1 $divide");

        $date = new DateTime();
        $ret = array();
        for ($i=0; $i < 60; $i++) { 
            $date->sub($interval);
            if ($divide === 'day') {
                $ret[$i] = self::daySaleInfo($date->format('Y-m-d'));
            } elseif ($divide === 'month') {
                $ret[$i] = self::monthSaleInfo($date->format('Y-m'));
            }
        }
        return array_reverse($ret);
    }

    public static function daySaleInfo($day_string) // a day
    {
        return self::saleInfo($day_string, 'DATE(done_time)=?');
    }

    public static function monthSaleInfo($month_str)
    {
        return self::saleInfo($month_str, "DATE_FORMAT(done_time,'%Y-%m')=?");
    }

    private static function saleInfo($date_str, $format)
    {
        $arr = Pdb::fetchAll(
            'paid', 
            Order::$table, 
            array($format => $date_str));
        return array(
            'date' => $date_str,
            'count' => count($arr),
            'sum' => $arr ? array_sum($arr) : 0);
    }

}
