<?php
namespace QCloud_WeApp_SDK\Model;

class xonSchool extends cAppinfo
{
  protected static $tableName = 'xonSchool';
  protected static $tableTitle = '学校列表';

  public static function add($code, $name, $schs_id, $edu_type_id) {
    $id = $schs_id . $code;
    self::existByCustom(compact('schs_id', 'code'), '学校编号不得重复');
    self::existByIdCustom($id, '学校编号不得重复');

    $uid = x5on::getUid();
    self::insert(compact('id', 'uid', 'code', 'name', 'schs_id', 'edu_type_id'));
    return xovSchool::getByUid($uid);
  }
}