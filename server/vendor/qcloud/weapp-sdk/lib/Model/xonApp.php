<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class xonApp extends cAppinfo
{
  protected static $tableName = 'xonApp';
  protected static $tableTitle = '应用名称';

  public static function getIdByName($name) {
    $res = dbs::row('xonApp', ['*'], compact('name'));
    return $res !== null ? $res->id : null;
  }
}