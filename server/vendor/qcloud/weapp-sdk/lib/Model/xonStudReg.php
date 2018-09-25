<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class xonStudReg
{
  public static $tableName = 'xonStudReg';

  public static function className () {
    return self::$tableName;
  }

  public static function getRows () {
    return dbs::select(self::$tableName, ['*']);
  }

  public static function getRowsByWhere ($where) {
    return dbs::select(self::$tableName, ['*'], $where);
  }

  public static function getRowById ($id) {
    return dbs::row(self::$tableName, ['*'], compact('id'));
  }

  public static function getRowByUid ($uid) {
    return dbs::row(self::$tableName, ['*'], compact('uid'));
  }

}

class xonAppForm11 extends xonStudReg {



}
