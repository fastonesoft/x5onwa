<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class xonSys
{

  public static function insert () {

  }

  public static function update () {

  }

  public static function delete () {

  }

  public static function getRowById($id) {
    return dbs::row('xonSys', ['*'], compact('id'));
  }
}
