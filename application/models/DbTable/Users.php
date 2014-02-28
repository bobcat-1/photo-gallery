<?php

class Application_Model_DbTable_Users extends Zend_Db_Table_Abstract
{
    protected $_name = 'users';

    public function getUser($login, $password)
    {
        $user = $this->fetchRow(array(
            'login = ' . '"'.$login.'"',
            'password =' . '"'.$password.'"'
        ));
        return $user;
    }

    public function getUserById($user_id){
        $user = $this->fetchRow('user_id = ' . $user_id);
        return $user;
    }
}