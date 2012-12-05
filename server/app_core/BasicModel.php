<?php

/**
 * @author ryan
 */

class BasicModel
{
    protected $id = null;
    protected $info = null;
    
    public function __construct($para) 
    {
        if (is_array($para) && isset($para['id'])) {
            $this->id = $para['id'];
            $this->info = $para;
        } elseif (is_numeric($para)) {
            $this->id = $para;
        } else {
            d($para);
            throw new Exception("not good arg for construct");
        }
    }

    public static function create($info = array())
    {
        $self = get_called_class();
        Pdb::insert($info, $self::$table);
        return new self(Pdb::lastInsertId());
    }

    public static function count($conds = array())
    {
        $self = get_called_class();
        list($tables, $conds) = $self::buildDbArgs($conds);
        return Pdb::count($tables, $conds);
    }

    public static function read($conds = array())
    {
        $self = get_called_class();
        list($tables, $conds, $orderby, $tail) = $self::buildDbArgs($conds);
        $infos = Pdb::fetchAll('*', $tables, $conds, $orderby, $tail);
        return safe_array_map(function ($info) use($self) {
            return new $self($info);
        }, $infos);
    }

    public function info() // will this bug?
    {
        $self = get_called_class();
        $ret = Pdb::fetchRow('*', $self::$table, $this->selfCond());
        if (empty($ret))
            throw new Exception(get_called_class() . " no id: $this->id");
        $this->info = $ret;
        return $ret;
    }

    public function exists()
    {
        $self = get_called_class();
        return Pdb::exists($self::$table, $this->selfCond());
    }

    public function selfCond() 
    {
        return array('id=?' => $this->id);
    }

    // 废弃 or just another name, better name
    public function edit($key_or_array, $value = null)
    {
        $this->update($key_or_array, $value);
    }

    // function same as edit()
    public function update($key_or_array, $value = null)
    {
        if($value !== null) { // given by key => value
            $arr = array($key_or_array => $value);
        } else {
            $arr = $key_or_array;
        }
        $self = get_called_class();
        Pdb::update($arr, $self::$table, $this->selfCond()); // why we need that? that doesn't make any sense
        $this->info = $this->info(); // refresh data
    }

    public function __get($name) 
    {
        if ($name === 'id') return $this->id;
        if (empty($this->info)) {
            $this->info = $this->info();
        }
        $info = $this->info;
        if (is_bool($info)) {
            d($info);
            throw new Exception("info empty, maybe because you have no id: $this->id in " . get_called_class());
        }
        if (!array_key_exists($name, $this->info)) {
            d($this->info);
            throw new Exception("no '$name' when get in class " . get_called_class());
        }
        return $this->info[$name];
    }

    // 这个函数将何以自处？
    protected static function defaultConds($conds = array()) 
    {
        return array_merge(array(
            'limit' => 10,
            'offset' => 0,
        ), $conds);
    }
}
