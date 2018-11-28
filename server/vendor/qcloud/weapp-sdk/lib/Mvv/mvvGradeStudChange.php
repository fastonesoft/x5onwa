<?php
namespace QCloud_WeApp_SDK\Mvv;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Model\x5on;
use QCloud_WeApp_SDK\Model\xonChild;
use QCloud_WeApp_SDK\Model\xonGrade;
use QCloud_WeApp_SDK\Model\xonGradeStudChange;
use QCloud_WeApp_SDK\Model\xonStudent;
use QCloud_WeApp_SDK\Model\xonStudStatus;
use QCloud_WeApp_SDK\Model\xonStudType;
use QCloud_WeApp_SDK\Model\xovClass;
use QCloud_WeApp_SDK\Model\xovGradeCurrent;
use QCloud_WeApp_SDK\Model\xovGradeStud;
use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class mvvGradeStudChange
{
  public static function add ($grade_id, $cls_id, $stud_id, $stud_status_id, $change_date, $memo) {
    $has_done = 0;
    $year_id = mvvYear::currentYearId();
    $uid = x5on::getUid();
    return xonGradeStudChange::insert(compact('uid', 'year_id', 'grade_id', 'cls_id', 'stud_id', 'stud_status_id', 'change_date', 'has_done', 'memo'));
  }

  public static function done ($change_uid) {
    $res = xonGradeStudChange::checkByUid($change_uid);
    // 添加学生进相关年级
    $uid = x5on::getUid();
    $grade_id = $res->grade_id;
    $cls_id = $res->cls_id;
    $year_id = $res->year_id;


  }

}
