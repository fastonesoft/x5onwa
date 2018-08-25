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

  public static function getStudSumNotMovedByName ($grade_id, $stud_name) {
    $sub_id = 99;
    $same_group = 0;
    return dbs::select('xovGradeDivisionStudNotMoved', ['kao_stud_id', 'uid', 'cls_id', 'cls_order', 'stud_name', 'stud_sex', 'value'], compact('grade_id', 'stud_name', 'sub_id', 'same_group'));
  }

  public static function getStudSumMovedByClassId ($cls_id) {
    $sub_id = 99;
    $same_group = 0;
    return dbs::select('xovGradeDivisionStudMoved', ['kao_stud_id', 'uid', 'cls_id', 'cls_order', 'stud_name', 'stud_sex', 'kao_room', 'value'], compact('cls_id', 'sub_id', 'same_group'));
  }

  public static function getStudSumNotMovedByUid ($uid) {
    $sub_id = 99;
    $same_group = 0;
    return dbs::row('xovGradeDivisionStudNotMoved', ['*'], compact('uid', 'sub_id', 'same_group'));
  }

  public static function getStudSumMovedByUserId ($user_id) {
    $sub_id = 99;
    $same_group = 0;
    return dbs::select('xovGradeDivisionStudMoved', ['*'], compact('user_id'));
  }

}
