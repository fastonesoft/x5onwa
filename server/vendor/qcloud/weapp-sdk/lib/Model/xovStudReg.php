<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class xovStudReg
{

  public static function getStudRegRow ($user_id) {
    $res = dbs::row('xovStudReg', ['*'], compact('user_id'));
    if ( $res !== null ) {
      return $res;
    } else {
      throw new Exception("没有查到用户报名记录");
    }
  }

}
