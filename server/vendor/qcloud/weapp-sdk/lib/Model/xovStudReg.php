<?php
namespace QCloud_WeApp_SDK\Model;

class xovStudReg extends vAppinfo
{
  protected static $tableName = 'xovStudReg';
  protected static $tableTitle = '学生注册查询';











  public static function getStudRegRowByUserId ($user_id) {
    $res = dbs::row('xovStudReg', ['*'], compact('user_id'));
    if ( $res !== null ) {
      return $res;
    } else {
      throw new Exception("没有查到用户报名记录");
    }
  }

  public static function getStudRegRowByUid ($uid) {
    $res = dbs::row('xovStudReg', ['*'], compact('uid'));
    if ( $res !== null ) {
      return $res;
    } else {
      throw new Exception("没有查到编号对应的报名记录");
    }
  }

}
