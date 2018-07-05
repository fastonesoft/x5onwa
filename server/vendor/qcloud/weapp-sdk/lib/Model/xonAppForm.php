<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class xonAppForm
{

  public static function insert () {

  }

  public static function update () {

  }

  public static function delete () {

  }

  public static function getFormsById($app_id) {
    $res = dbs::select('xonAppForm', ['id', 'name'], compact('app_id'));
    return $res;
  }
}
