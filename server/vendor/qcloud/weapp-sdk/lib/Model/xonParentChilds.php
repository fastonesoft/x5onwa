<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class xonParentChilds
{
  public static function insert () {

  }

  public static function update () {

  }

  public static function delete () {

  }

  public static function mychilds ($user_id) {
    return $res = dbs::select('xovParentChilds', ['uid', 'idc', 'child_name', 'relation_name'], compact('user_id'));
  }
}
