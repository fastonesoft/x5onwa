<?php
namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\x5on;
use QCloud_WeApp_SDK\Model\xonGradeStudIn;

class mvvGradeStudIn
{
  public static function done ($change_uid) {
    $res = xonGradeStudIn::checkByUid($change_uid);
    // 添加学生进相关年级
    $uid = x5on::getUid();
    $grade_id = $res->grade_id;
    $cls_id = $res->cls_id;
    $year_id = $res->year_id;


  }

}
