<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class xonRelation
{
  public static function insert () {

  }

  public static function update () {

  }

  public static function delete () {

  }

  public static function selects () {
    return dbs::select('xonRelation', ['id', 'name']);
  }
}
