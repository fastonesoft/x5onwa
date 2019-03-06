<?php
namespace QCloud_WeApp_SDK\Model;

use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
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

  public static function getGodownByGradeId($grade_id) {
    $res = self::getRowByGradeId($grade_id);
    if ( $res === null ) {
      throw new Exception('当前年级没有分班设置');
    }
    return $res->godown;
  }

  public static function getSamesexByGradeId($grade_id) {
    $res = self::getRowByGradeId($grade_id);
    if ( $res === null ) {
      throw new Exception('当前年级没有分班设置');
    }
    return $res->samesex;
  }

  public static function getFinishedByGradeId($grade_id) {
    $res = self::getRowByGradeId($grade_id);
    if ( $res === null ) {
      throw new Exception('当前年级没有分班设置');
    }
    return $res->finished;
  }

  public static function getLimitnumByGradeId($grade_id) {
    $res = self::getRowByGradeId($grade_id);
    if ( $res === null ) {
      throw new Exception('当前年级没有分班设置');
    }
    return $res->limit_num;
  }

  public static function update ($grade_id, $section, $limit_num, $samesex, $godown, $finished) {
    $res = dbs::row('xonDivisionSet', ['*'], compact('grade_id'));
    if ( $res !== null ) {
      return dbs::update('xonDivisionSet', compact('section', 'limit_num', 'samesex', 'godown', 'finished'), compact('grade_id'));
    }
  }

}
