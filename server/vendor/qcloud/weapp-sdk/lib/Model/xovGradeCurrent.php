<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class xovGradeCurrent
{

  public static function getRows () {
    return dbs::select('xovGradeCurrent', ['id', 'name']);
  }

}
