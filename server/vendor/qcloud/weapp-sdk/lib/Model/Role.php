<?php
namespace QCloud_WeApp_SDK\Model;

use QCloud_WeApp_SDK\Mysql\Mysql as DB;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class User
{
    public static function storeUserInfo ($userinfo, $skey, $session_key) {

    }

    public static function findUserBySKey ($skey) {
        return DB::row('cSessionInfo', ['*'], compact('skey'));
    }
}
