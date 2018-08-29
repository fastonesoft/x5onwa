<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class xonStudMove
{

  public static function addStud ($request_user_id, $grade_stud_uid, $request_cls_id) {
    $success = 0;
    $exchange_grade_stud_uid = null;

    $count = dbs::insert('xonStudMove', compact('grade_stud_uid', 'request_cls_id', 'exchange_grade_stud_uid', 'request_user_id', 'success'));
    return $count;
  }

  public static function addStudExchange ($request_user_id, $grade_stud_uid, $request_cls_id, $exchange_grade_stud_uid) {
    $success = 0;

    $count = dbs::insert('xonStudMove', compact('grade_stud_uid', 'request_cls_id', 'exchange_grade_stud_uid', 'request_user_id', 'success'));
    return $count;
  }

  public static function removeStud ($grade_stud_uid) {
    $res = dbs::row('xonStudMove', ['*'], compact('grade_stud_uid'));
    if ( $res !== null ) {
      return dbs::delete('xonStudMove', compact('grade_stud_uid'));
    }
  }

  public static function checkExchange ($exchange_grade_stud_uid) {
    $res = dbs::select('xonStudMove', ['*'], compact('exchange_grade_stud_uid'));
    if ( count($res) > 0 ) {
      throw new Exception('同一调动学生不可多次请求交换！');
    }
  }

  public static function exchangeStud ($move_grade_stud_uid, $exchange_grade_stud_uid) {
    $success = 0;
    $grade_stud_uid = $move_grade_stud_uid;
    $move = dbs::row('xonStudMove', ['*'], compact('grade_stud_uid', 'success'));
    if ( $move === null ) throw new Exception('没有找到调动学生记录！');

    $grade_stud_uid = $exchange_grade_stud_uid;
    $exchange = dbs::row('xonStudMove', ['*'], compact('grade_stud_uid', 'success'));
    if ( $exchange === null ) throw new Exception('没有找到交换学生记录！');

    if ( $exchange->exchange_grade_stud_uid !== $move->grade_stud_uid ) throw new Exception('调动、交换学生不匹配！');
    // 怎么交换？
    // 1、交换学生班级信息
    // 2、设置调动学生标志信息
    // 3、清除交换学生的调动记录
    $uid = $move_grade_stud_uid;
    $cls_id = $move->request_cls_id;
    $same_group = 1;
    dbs::update('xonGradeStud', compact('cls_id', 'same_group'), compact('uid'));

    $success = 1;
    $grade_stud_uid = $uid;
    dbs::update('xonStudMove', compact('success'), compact('grade_stud_uid'));
    // 请求班级
    $res_cls_id = $cls_id;

    $uid = $exchange_grade_stud_uid;
    $cls_id = $exchange->request_cls_id;
    dbs::update('xonGradeStud', compact('cls_id'), compact('uid'));
    $grade_stud_uid = $uid;
    dbs::delete('xonStudMove', compact('grade_stud_uid'));
    return $res_cls_id;
  }

  public static function getRowByUid ($grade_stud_uid) {
    $res = dbs::row('xonStudMove', ['*'], compact('grade_stud_uid'));
    if ( $res === null ) {
      throw new Exception('没有找到编号对应调动学生！');
    }
    return $res;
  }

}
