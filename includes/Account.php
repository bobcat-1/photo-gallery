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
            $_SESSION['owner_id'] = $user->user_id;
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

    public static function logOut(){
        session_start();
        session_destroy();
    }

    public static function isAblumOwner($album_id){
        $albums = new Application_Model_DbTable_Albums();
        if(!$albums->getAlbum($album_id)){
            throw new Exception('Not rules');
        }
    }

    public static function isPhotoOwner($photo_id){
        $photos = new Application_Model_DbTable_Photos();
        $photo = $photos->getPhoto($photo_id);
        $album_id = $photo->album_id;
        self::isAblumOwner($album_id);
    }
}