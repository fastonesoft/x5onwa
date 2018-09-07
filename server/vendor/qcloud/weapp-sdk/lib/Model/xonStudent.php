<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class xonStudent
{
  public static function checkStudentEnter ($child_id, $sch_id) {
    $res = dbs::row('xovStudent', ['*'], compact('child_id', 'sch_id'));
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

}
