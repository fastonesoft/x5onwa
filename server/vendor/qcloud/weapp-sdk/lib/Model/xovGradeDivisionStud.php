<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class xovGradeDivisionStud
{

  public static function getStudSumById ($stud_id) {
    $sub_id = 99;
    $same_group = 0;
    return dbs::select('xovGradeDivisionStud', ['*'], compact('stud_id', 'sub_id', 'same_group'));
  }

  public static function getStudSumByName ($stud_name) {
    $sub_id = 99;
    $same_group = 0;
    return dbs::select('xovGradeDivisionStud', ['*'], compact('stud_name', 'sub_id', 'same_group'));
  }

  public static function getStudSumByValue ($cls_id, $value, $section) {
    $sub_id = 99;
    $end = $value + $section;
    $begin = $value - $section;
    return dbs::select('xovGradeDivisionStud', ['*'], "cls_id = $cls_id and sub_id = $sub_id and value between $begin and $end and same_group = 0");
  }

}
