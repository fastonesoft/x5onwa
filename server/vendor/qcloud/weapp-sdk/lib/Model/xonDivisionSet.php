<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class xonDivisionSet
{

  public static function getRowByGradeId($grade_id) {
    return dbs::row('xonDivisionSet', ['*'], compact('grade_id'));
  }

  public static function getSectionByGradeId($grade_id) {
    $res = self::getRowByGradeId($grade_id);
    if ( $res === null ) {
      throw new Exception('当前年级没有分班设置');
    }
    return $res->section;
  }

  public static function getFinishedByGradeId($grade_id) {
    $res = self::getRowByGradeId($grade_id);
    if ( $res === null ) {
      throw new Exception('当前年级没有分班设置');
    }
    return $res->finished;
  }

}
