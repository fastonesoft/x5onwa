<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class xonStudMove
{

  public static function addStud ($request_user_id, $grade_stud_uid, $request_cls_id) {
    $res = xovGradeDivisionStud::getStudSumNotMovedByUid($grade_stud_uid);

    if ( $res !== null ) {
      $success = 0;
      $exchange_kao_stud_id = null;
      $kao_stud_id = $res->kao_stud_id;

      // 先插入调动列表
      $count = dbs::insert('xonStudMove', compact('kao_stud_id', 'request_cls_id', 'exchange_kao_stud_id', 'request_user_id', 'success'));
      // 再设置调动状态
      $same_group = 1;
      $uid = $grade_stud_uid;
      dbs::update('xonGradeStud', compact('same_group'), compact('uid'));
      return $count;
    }
  }

}
