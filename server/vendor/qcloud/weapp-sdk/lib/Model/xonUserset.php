<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class xonUserset
{
  public static function getIdByUserSetName ($name) {
    $userset = dbs::row('xonUserSet', ['*'], compact('name'));
    return $userset !== NULL ? $userset->id : NULL;
  }

  public static function insert () {

  }

  public static function update () {

  }

  public static function delete () {

  }
}
