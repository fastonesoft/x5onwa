<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class xonApp
{

  public static function insert () {

  }

  public static function update () {

  }

  public static function delete () {

  }

  public static function getIdByName($name) {
    $res = dbs::row('xonApp', ['*'], compact('name'));
    return $res !== null ? $res->id : null;
  }
}
