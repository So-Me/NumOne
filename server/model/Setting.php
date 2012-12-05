<?php

/**
 *
 * @author  ryan <cumt.xiaochi@gmail.com>
 */
class Setting
{
    public static $table = 'setting';

    public static function set($ka, $value = null)
    {
        if ($value !== null && is_string($ka)) {
            $arr = array();
            $arr[$ka] = $value;
        } elseif (is_array($ka)){
            $arr = $ka;
        } else {
            throw new Exception('no array');
        }
        d($arr);
        foreach ($arr as $key => $value) {
            Pdb::update(compact('value'), self::$table, array('`key`=?' => $key));
        }
    }

    public static function get($ka = null)
    {
        if (is_string($ka)) {
            $keys = array($ka);
        } elseif (is_array($ka)) {
            $keys = $ka;
        } elseif (empty($ka)) {
            // return all key-values
            $ret = array();
            $arr = Pdb::fetchAll('*', self::$table);
            foreach ($arr as $entry) {
                $ret[$entry['key']] = $entry['value'];
            }
            return $ret;
        }
        $ret = array();
        foreach ($keys as $key){
            $value = Pdb::fetchRow(
                '`value`', 
                self::$table, 
                array('`key`=?' => $key));
            if ($value === false)
                throw new Exception("there is no key: $key");
            $ret[$key] = $value;
        }
        return count($ret) === 1 ? reset($ret) : $ret;
    }
}
