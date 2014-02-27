<?php

class Account
{
    public static function checkAccess(){
        if(!Account::isAuthorizated()) throw new Exception('Please, sign in');
    }

    public static function authorize($login, $password){
        $users = new Application_Model_DbTable_Users();
        $user = $users->getUser($login, $password);
        if(isset($user)){
            session_start();
            $_SESSION['is_autorizate']= 1;
            return $user;
        }
        return false;
    }

    public static function isAuthorizated(){
        session_start();
        if($_SESSION['is_autorizate']<>1){
            return false;
        }else{
            return true;
        }
    }
}