<?php
namespace QCloud_WeApp_SDK\Model;

use QCloud_WeApp_SDK\Mvv\mvvYear;

class xonGradeStudIn extends cAppinfo
{
  protected static $tableName = 'xonGradeStudChange';
  protected static $tableTitle = '年度学生调动';

  public static function add ($to_grade_id, $to_cls_id, $stud_id, $stud_status_id, $change_date, $from_grade_id, $from_cls_id, $memo) {
    $has_done = 0;
    $year_id = mvvYear::currentYearId();
    $uid = x5on::getUid();
    return self::insert(compact('uid', 'year_id', 'to_grade_id', 'to_cls_id', 'stud_id', 'stud_status_id', 'change_date', 'has_done', 'from_grade_id', 'from_cls_id', 'memo'));
  }

}