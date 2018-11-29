<?php
namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\x5on;
use QCloud_WeApp_SDK\Model\xonGradeStudIn;

class mvvGradeStudIn
{
  public static function add ($to_grade_id, $to_cls_id, $stud_id, $stud_status_id, $change_date, $from_grade_id, $from_cls_id, $memo) {
    $has_done = 0;
    $year_id = mvvYear::currentYearId();
    $uid = x5on::getUid();
    return xonGradeStudIn::insert(compact('uid', 'year_id', 'to_grade_id', 'to_cls_id', 'stud_id', 'stud_status_id', 'change_date', 'has_done', 'from_grade_id', 'from_cls_id', 'memo'));
  }

  public static function done ($change_uid) {
    $res = xonGradeStudIn::checkByUid($change_uid);
    // 添加学生进相关年级
    $uid = x5on::getUid();
    $grade_id = $res->grade_id;
    $cls_id = $res->cls_id;
    $year_id = $res->year_id;


  }

}
