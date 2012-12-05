<?php
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

class BasicController 
{
    public function init()
    {
        // db config
        $db_config = $GLOBALS['config']['db'];
        Pdb::setConfig($db_config);

        // login
        $user = User::loggingUser(); // but the var here should be long such as $logging_user
        if ($user === false) {
            $has_login = false;
        } else {
            $has_login = true;
            $GLOBALS['user'] = $user;
        }
        $GLOBALS['has_login'] = $has_login;

        // login check
        if (in_array($controller, $config['controllers_need_login']) && !$has_login)
            redirect("login?back=$controller/$target");
    }
}
