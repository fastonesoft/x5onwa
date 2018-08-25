<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class xovGradeDivisionStud
{

  public static function getStudSumById ($stud_id) {
    $sub_id = 99;
    $same_group = 0;
    return dbs::select('xovGradeDivisionStud', ['*'], compact('stud_id', 'sub_id', 'same_group'));
  }

  public static function getStudSumByName ($grade_id, $stud_name) {
    $sub_id = 99;
    $same_group = 0;
    return dbs::select('xovGradeDivisionStud', ['*'], compact('grade_id', 'stud_name', 'sub_id', 'same_group'));
  }

  public static function getStudSumByValue ($cls_id, $value, $all, $section) {
    $sub_id = 99;
    if ($all === 'true') {
      $same_group = 0;
      return dbs::select('xovGradeDivisionStud', ['*'], compact('cls_id', 'sub_id', 'same_group'));
    } else {
      $end = $value + $section;
      $begin = $value - $section;
      return dbs::select('xovGradeDivisionStud', ['*'], "cls_id = $cls_id and sub_id = $sub_id and value between $begin and $end and same_group = 0");
    }
  }

  // 班级分管调动学生查询
  // 以后可以考虑将 same_group 放入到视图当中进行过滤

  public static function getStudSumNotMovedByName ($grade_id, $stud_name) {
    $sub_id = 99;
    $same_group = 0;
    return dbs::select('xovGradeDivisionStudNotMoved', ['kao_stud_id', 'uid', 'cls_id', 'cls_order', 'stud_name', 'stud_sex', 'value'], compact('grade_id', 'stud_name', 'sub_id', 'same_group'));
  }

  public static function getStudSumNotMovedByUid ($uid) {
    $sub_id = 99;
    $same_group = 0;
    return dbs::row('xovGradeDivisionStudNotMoved', ['*'], compact('uid', 'sub_id', 'same_group'));
  }

  // 显示查询

  public static function getStudSumMovingByRequestClassId ($request_cls_id) {
    $sub_id = 99;
    return dbs::select('xovGradeDivisionStudMoving', ['kao_stud_id', 'uid', 'cls_id', 'cls_order', 'stud_name', 'stud_sex', 'kao_room', 'value'], compact('request_cls_id', 'sub_id'));
  }

  public static function getStudSumMovedSuccessByRequestClassId ($request_cls_id) {
    $sub_id = 99;
    return dbs::select('xovGradeDivisionStudSuccess', ['kao_stud_id', 'uid', 'cls_id', 'cls_order', 'stud_name', 'stud_sex', 'kao_room', 'value'], compact('request_cls_id', 'sub_id'));
  }



}
