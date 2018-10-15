<?php
namespace QCloud_WeApp_SDK\Mvv;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Model\x5on;
use QCloud_WeApp_SDK\Model\xovClass;
use QCloud_WeApp_SDK\Model\xovGradeCurrent;
use QCloud_WeApp_SDK\Model\xovGradeStud;
use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class mvvGradeStud
{
  public static function grades () {
    return xovGradeCurrent::gets();
  }

  public static function classes ($grade_id) {
    return xovClass::getsBy(compact('grade_id'));
  }

  public static function studcls ($grade_id, $cls_id) {
    if ($grade_id && $cls_id) {
      return xovGradeStud::getsBy(compact('grade_id', 'cls_id'));
    } else {
      return [];
    }
  }

  public static function query ($grade_id, $cls_id, $stud_name) {
    if ($grade_id && $cls_id) {
      return xovGradeStud::likesBy(compact('grade_id', 'cls_id'), compact('stud_name'));
    } elseif ($grade_id) {
      return xovGradeStud::likesBy(compact('grade_id'), compact('stud_name'));
    } else {
      $current_year = 1;
      return xovGradeStud::likesBy(compact('current_year'), compact('stud_name'));
    }
  }

}
