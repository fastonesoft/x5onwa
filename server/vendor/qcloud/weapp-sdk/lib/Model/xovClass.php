<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class xovClass
{
  public static function getRows4Sameset ($grade_id) {
    return dbs::select('xovClass', ['id', 'cls_name'], compact('grade_id'), 'and', 'order by num');
  }

  public static function getRows4Rename ($grade_id) {
    return dbs::select('xovClass', ['uid', 'num as value', 'cls_order'], compact('grade_id'));
  }

  public static function getRows4Tuning ($grade_id) {
    return dbs::select('xovClass', ['id', 'cls_name'], compact('grade_id'), 'and', 'order by num');
  }

  public static function getRows4Division ($grade_id) {
    return dbs::select('xovClassNotDivision', ['id', 'cls_name', 'cls_order'], compact('grade_id'));
  }

  public static function getRows4Divisioned ($grade_id) {
    return dbs::select('xovClassDivisioned', ['uid', 'cls_name', 'cls_order', 'user_name'], compact('grade_id'));
  }
}
