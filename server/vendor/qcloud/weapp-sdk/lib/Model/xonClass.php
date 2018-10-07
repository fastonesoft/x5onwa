<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class xonClass extends vAppinfo
{
  protected static $tableName = 'xonClass';
  protected static $tableTitle = '班级';

  public static function update ($param) {
    $result = 0;
    foreach ($param as $uid => $num) {
      $res = dbs::row('xonClass', ['*'], compact('uid'));
      if ( $res !== null ) {
        $result++;
        dbs::update('xonClass', compact('num'), compact('uid'));
      }
    }
    return $result;
  }

  public static function getGradeIdByClassId($id) {
    $res = dbs::row('xonClass', ['*'], compact('cls_id'));
    if ( $res === null ) {
      throw new Exception('没有找到对应班级编号！');
    }
    return $res->grade_id;
  }

}
