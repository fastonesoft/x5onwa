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
      return $count;
    }
  }

  public static function removeStud ($kao_stud_id) {
    $res = dbs::row('xonStudMove', ['*'], compact('kao_stud_id'));
    if ( $res !== null ) {
      return dbs::delete('xonStudMove', compact('kao_stud_id'));
    }
  }

}
