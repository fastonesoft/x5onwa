<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class xonGradeStud
{

  public static function exchange ($movestud_uid, $changestud_uid) {
    $uid = $movestud_uid;
    $movestud = dbs::row('xonGradeStud', ['*'], compact('uid'));
    $uid = $changestud_uid;
    $changestud = dbs::row('xonGradeStud', ['*'], compact('uid'));

    // 调动学生变换班级
    $same_group = 1;
    $uid = $movestud_uid;
    $cls_id = $changestud->cls_id;
    dbs::update('xonGradeStud', compact('cls_id', 'same_group'), compact('uid'));

    // 交换学生更改班级
    $uid = $changestud_uid;
    $cls_id = $movestud->cls_id;
    dbs::update('xonGradeStud', compact('cls_id'), compact('uid'));
  }

}
