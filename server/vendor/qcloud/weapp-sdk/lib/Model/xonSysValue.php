<?php
namespace QCloud_WeApp_SDK\Model;

class xonSysValue extends cAppinfo
{
  protected static $tableName = 'xonSysValue';
  protected static $tableTitle = '键值列表';

  public static function add($key_id, $code, $value, $valuex)
  {
    self::existByCustom(compact('key_id', 'code'), '键值列表序号已存在');
    self::existByCustom(compact('key_id', 'value'), '键值列表值已存在');

    $id = $key_id . $code;
    self::existByIdCustom($id, '键值列表编号已存在');

    $uid = x5on::getUid();
    self::insert(compact('id', 'uid', 'key_id', 'code', 'value', 'valuex'));
    return xonSysValue::getById($id);
  }

}