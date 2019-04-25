<?php
namespace QCloud_WeApp_SDK\Model;

class xonClass extends cAppinfo
{
  protected static $tableName = 'xonClass';
  protected static $tableTitle = '班级';

  public static function add($grade_id, $num) {
    $id = $grade_id . x5on::setw($num, 2);
    self::existByIdCustom($id, '当前班级设置已存在');

    $uid = x5on::getUid();
    self::insert(compact('id', 'uid', 'grade_id', 'num'));
    return xovClass::getByUid($uid);
  }


//  public static function update ($param) {
//    $result = 0;
//    foreach ($param as $uid => $num) {
//      $res = dbs::row('xonClass', ['*'], compact('uid'));
//      if ( $res !== null ) {
//        $result++;
//        dbs::update('xonClass', compact('num'), compact('uid'));
//      }
//    }
//    return $result;
//  }
//
//  public static function getGradeIdByClassId($id) {
//    $res = dbs::row('xonClass', ['*'], compact('cls_id'));
//    if ( $res === null ) {
//      throw new Exception('没有找到对应班级编号！');
//    }
//    return $res->grade_id;
//  }

}
