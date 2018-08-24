<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class xovGradeStud
{

  public static function getRowsByGradeId ($grade_id) {
    return dbs::select('xovGradeStud', ['*'], compact('grade_id'));
  }

  public static function getRowsByClsId ($cls_id) {
    return dbs::select('xovGradeStud', ['uid', 'stud_name', 'stud_sex', 'same_group'], compact('cls_id'));
  }


  public static function updateSameGroup ($param) {
    // 计数
    $result = 0;
    foreach ($param as $uid => $value) {
      // 同班设置
      $same_group = $value === 'true' ? 1 : 0;
      $res = dbs::row('xonGradeStud', ['*'], compact('uid', 'same_group'));
      if ( $res === null ) {
        $result++;
        dbs::update('xonGradeStud', compact('same_group'), compact('uid'));
      }
    }
    return $result;
  }

}
