<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class xonGradeStud extends cAppinfo
{
  protected static $tableName = 'xonGradeStud';
  protected static $tableTitle = '年度学生';







  /**
   * todo 老的要改造的一些方法  要移到 --> mvv 里面
   */

  public static function exchange ($movestud_uid, $changestud_uids) {
    $uid = $movestud_uid;
    $movestud = dbs::row('xonGradeStud', ['*'], compact('uid'));

    // 取第一个，查询相关班级信息
    $uids = explode(',', $changestud_uids);
    $uid = $uids[0];
    $changestud = dbs::row('xonGradeStud', ['*'], compact('uid'));

    // 调动学生变换班级
    $same_group = 1;
    $uid = $movestud_uid;
    $cls_id = $changestud->cls_id;
    dbs::update('xonGradeStud', compact('cls_id', 'same_group'), compact('uid'));

    // 交换学生更改班级
    foreach ($uids as $uid) {
      $cls_id = $movestud->cls_id;
      dbs::update('xonGradeStud', compact('cls_id'), compact('uid'));
    }

    // 返回调动人数
    return count($uids) + 1;
  }

  public static function local ($uid) {
    $res = dbs::row('xonGradeStud', ['*'], compact('uid'));
    if ( $res !== null ) {
      $same_group = 1;
      return dbs::update('xonGradeStud', compact('same_group'), compact('uid'));
    }
  }

  public static function getRowByUid($uid) {
    $res = dbs::row('xonGradeStud', ['*'], compact('uid'));
    if ( $res === null ) {
      throw new Exception('没有找到编号对应年级学生！');
    }
    return $res;
  }

}
