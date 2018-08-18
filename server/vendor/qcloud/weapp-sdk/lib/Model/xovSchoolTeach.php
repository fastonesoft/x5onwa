<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class xovSchoolTeach
{

  public static function getUserSchool ($user_id) {
    $res = dbs::row('xovSchoolTeach', ['*'], compact('user_id'));
    if ( $res !== null ) {
      return $res;
    } else {
      throw new Exception("未注册学校");
    }
  }

  public static function getUserSchoolId ($user_id) {
    $res = dbs::row('xovSchoolTeach', ['*'], compact('user_id'));
    if ( $res !== null ) {
      return $res->sch_id;
    } else {
      throw new Exception("未注册学校");
    }
  }

}
