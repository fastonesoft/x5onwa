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
      $sch_reged = true;
      $not_reg = false;
      $not_added = false;
      $sch_name = $res->sch_name;
      $step_name = $res->step_name;
      $child_name = $res->child_name;
      $enter_code = $res->id;
      $enter_kao = substr($enter_code, -4);
      return compact('entered', 'sch_reged', 'not_reg', 'not_added', 'sch_name', 'step_name', 'child_name', 'enter_code', 'enter_kao');
    } else {
      return false;
    }
  }

}
