<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class xovGradeDivisionStud
{

  // 管理员身份调动学生查询

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

  public static function getStudSumByValue ($cls_id, $value, $all, $section, $stud_sex_num) {
    $sub_id = 99;
    if ($all === 'true') {
      $same_group = 0;
      return dbs::select('xovGradeDivisionStud', ['*'], compact('cls_id', 'sub_id', 'same_group'), 'and', 'order by stud_sex_num, value desc');
    } else {
      $end = $value + $section;
      $begin = $value - $section;
      return dbs::select('xovGradeDivisionStud', ['*'], "cls_id = $cls_id and sub_id = $sub_id and value between $begin and $end and same_group = 0 and stud_sex_num = $stud_sex_num", 'and', 'order by stud_sex_num desc, value limit 5');
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

  public static function getStudSumMovingByUid ($uid) {
    $sub_id = 99;
    $res = dbs::row('xovGradeDivisionStudMoving', ['*'], compact('uid', 'sub_id'));
    if ( $res === null ) {
      throw new Exception('没有找到编号对应的调动学生');
    }
    return $res;
  }

  public static function getStudSumNotMovedByValue ($cls_id, $value, $section, $godown, $samesex, $stud_sex_num, $limit_num) {
    $sub_id = 99;
    $same_group = 0;
    $begin = $value;
    $end = $value;
    $orderby = 'asc';

    if ( $godown ) {
      $orderby = 'desc';
      $begin -= $section;
    } else {
      $end += $section;
    }

    if ( $samesex ) {
      $condi = "cls_id = $cls_id and sub_id = $sub_id and value between $begin and $end and same_group = 0 and stud_sex_num = $stud_sex_num";
      return dbs::select('xovGradeDivisionStudNotMoved', ['uid', 'cls_id', 'cls_order', 'stud_name', 'stud_sex', 'value'], $condi, 'and', "order by value $orderby limit $limit_num");
    } else {
      $condi = "cls_id = $cls_id and sub_id = $sub_id and value between $begin and $end and same_group = 0 and stud_sex_num = !$stud_sex_num";
      return dbs::select('xovGradeDivisionStudNotMoved', ['uid', 'cls_id', 'cls_order', 'stud_name', 'stud_sex', 'value'], $condi, 'and', "order by value $orderby limit $limit_num");
    }
  }

  // 调动中、调动结束的学生查询

  public static function getStudSumMovingByRequestClassId ($request_cls_id) {
    $sub_id = 99;
    return dbs::select('xovGradeDivisionStudMoving', ['uid', 'grade_id', 'cls_id', 'cls_order', 'stud_name', 'stud_sex', 'stud_sex_num', 'kao_room', 'value'], compact('request_cls_id', 'sub_id'));
  }

  public static function getStudSumMovedSuccessByRequestClassId ($request_cls_id) {
    $sub_id = 99;
    return dbs::select('xovGradeDivisionStudSuccess', ['uid', 'grade_id', 'cls_id', 'cls_order', 'stud_name', 'stud_sex', 'stud_sex_num', 'kao_room', 'value'], compact('request_cls_id', 'sub_id'));
  }

  public static function getStudSumMovingByGradeStudUid ($uid) {
    $sub_id = 99;
    return dbs::row('xovGradeDivisionStudMoving', ['uid', 'grade_id', 'cls_id', 'cls_order', 'stud_name', 'stud_sex', 'stud_sex_num', 'kao_room', 'value', 'request_cls_id'], compact('uid', 'sub_id'));
  }

  public static function getStudSumExchangingByUserId ($request_user_id) {
    $sub_id = 99;
    return dbs::select('xovGradeDivisionStudExchanging', ['uid', 'grade_id', 'cls_id', 'cls_order', 'stud_name', 'stud_sex', 'stud_sex_num', 'kao_room', 'value', 'exchange_grade_stud_uid'], compact('request_user_id', 'sub_id'));
  }

  public static function getStudSumExchangingByGradeStudUid ($uid) {
    $sub_id = 99;
    return dbs::row('xovGradeDivisionStudExchanging', ['uid', 'grade_id', 'cls_id', 'cls_order', 'stud_name', 'stud_sex', 'stud_sex_num', 'kao_room', 'value', 'exchange_grade_stud_uid'], compact('uid', 'sub_id'));
  }

}
