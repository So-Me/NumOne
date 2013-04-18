<?php

/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

class User extends BasicModel
{
    public static $table = 'user';

    public function find($username)
    {
        return Pdb::exists(self::$table, array('name=?' => $username));
    }

    public static function check($username, $password)
    {
        return Pdb::exists(self::$table, array(
            'name=?' => $username,
            'password=?' => md5($password)));
    }

    public function checkPassword($password)
    {
        return md5($password) === $this->password;
    }

    public function edit($key_or_array, $value = null)
    {
        if($value !== null) { // given by key => value
            $arr = array($key_or_array => $value);
        } else {
            $arr = $key_or_array;
        }
        Pdb::update($arr, self::$table, $this->selfCond());
    }

    public function getByName($username)
    {
        $cond = array('name=?' => $username);
        return new self(Pdb::fetchRow('*', self::$table, $cond));
    }

    public function changePassword($new_password)
    {
        Pdb::update(
            array('password' => md5($new_password)),
            self::$table,
            $this->selfCond());
    }

    public function login()
    {
        $_SESSION['se_user_id'] = $this->id;

        // log it
        UserLog::userLogin($this->id);
    }

    public function logout()
    {
        $_SESSION['se_user_id'] = 0;
    }

    public static function loggingUser()
    {
        if (isset($_SESSION['se_user_id']) && $_SESSION['se_user_id']) {
            return new self($_SESSION['se_user_id']);
        } else {
            return false;
        }
    }
}
