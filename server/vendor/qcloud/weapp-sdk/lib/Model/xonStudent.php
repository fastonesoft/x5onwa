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

  public static function add ($child_id, $step_id, $come_date) {
    // 流水号宽度
    $sn_width = 4;
    // 读取最大编号
    $max = self::max('id', compact('step_id'));
    if ($max === null) {
      $sn = 0;
    } else {
      $sn = (int)substr($max, - $sn_width);
    }
    $sn++;
    $id = $step_id . substr('0000' . $sn, -$sn_width);
    $uid = x5on::getUid();
    // 添加
    return self::insert(compact('id', 'uid', 'child_id', 'step_id', 'come_date'));
  }

}
