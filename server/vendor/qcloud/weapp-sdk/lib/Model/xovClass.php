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
    return dbs::select('xovClassDivisioned', ['uid', 'cls_name', 'cls_order', 'user_name', 'nick_name'], compact('grade_id'));
  }

  public static function getRows4UserDivisioned ($user_id, $grade_id) {
    return dbs::select('xovClassDivisioned', ['uid', 'cls_id', 'cls_name', 'cls_order', 'user_name', 'nick_name'], compact('user_id', 'grade_id'));
  }

  public static function checkClassIdMyDivision ($user_id, $grade_id, $cls_id) {
    $cls_ids = dbs::select('xovClassDivisioned', ['cls_id'], compact('user_id', 'grade_id'));
    $cls_idstr = json_encode($cls_ids);
    if ( ! strpos($cls_idstr, $cls_id) ) {
      throw new Exception('调动学生班级不在分管列表');
    }
  }
}
