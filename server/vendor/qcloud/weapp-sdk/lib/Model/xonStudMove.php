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
    $exchange_grade_stud_id = null;
    var_dump($grade_stud_uid);
    // 先插入调动列表
    $count = dbs::insert('xonStudMove', compact('grade_stud_uid', 'request_cls_id', 'exchange_grade_stud_id', 'request_user_id', 'success'));
    return $count;
  }

  public static function removeStud ($grade_stud_uid) {
    $res = dbs::row('xonStudMove', ['*'], compact('grade_stud_uid'));
    if ( $res !== null ) {
      return dbs::delete('xonStudMove', compact('grade_stud_uid'));
    }
  }

  public static function exchangeStud ($move_kao_stud_id, $exchange_kao_stud_id) {
    $kao_stud_id = $move_kao_stud_id;
    $move = dbs::row('xonStudMove', ['*'], compact('kao_stud_id'));
    $kao_stud_id = $exchange_kao_stud_id;
    $exchange = dbs::row('xonStudMove', ['*'], compact('kao_stud_id'));

    if ( $move === null || $exchange === null ) throw new Exception('学生识别码有误！');
    if ( $exchange->exchange_kao_stud_id !== $move->kao_stud_id ) throw new Exception('不是相互匹配的交换学生码');
    // 怎么交换？
    // 1、交换学生班级信息
    // 2、设置调动学生标志信息
    // 3、清除交换学生的调动记录

  }

}
