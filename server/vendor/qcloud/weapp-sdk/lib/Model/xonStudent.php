<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class xonStudent extends cAppinfo
{
  protected static $tableName = 'xonStudent';
  protected static $tableTitle = '录取学生';

  public static function checkStudentEnter ($child_id, $sch_id) {
    $res = self::getBy(compact('child_id', 'sch_id'));
    if ($res !== null) {
      $entered = true;
      $sch_name = $res->sch_name;
      $step_name = $res->step_name;
      $stud_name = $res->stud_name;
      $stud_id = $res->id;
      $enter_id = substr($stud_id, -4);
      return compact('entered', 'sch_name', 'step_name', 'stud_name', 'stud_id', 'enter_id');
    } else {
      return false;
    }
  }

  public static function addStudent ($child_id, $step_id, $come_date) {
    // 补足参数：id uid
    $max = self::max('child_id', compact('step_id'));

    if ($max !== null) {
      $countLength = 4;

      $id = $max;
      $len = strlen($id);
      $prev = substr($id, 0, $len-$countLength);
      $value = substr($id, $len-$countLength, $countLength);
      $uid = x5on::getUid();

      return compact('prev', 'value');
    } else {
      return null;
    }


  }

}
