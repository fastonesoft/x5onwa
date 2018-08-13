<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class xovClass
{

  public static function getRows ($grade_id) {
    return dbs::select('xovClass', ['id', 'cls_name'], compact('grade_id'));
  }

}
