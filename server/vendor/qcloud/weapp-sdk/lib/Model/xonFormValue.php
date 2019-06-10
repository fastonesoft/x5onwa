<?php
namespace QCloud_WeApp_SDK\Model;

class xonFormValue extends cAppinfo
{
  protected static $tableName = 'xonFormValue';
  protected static $tableTitle = '表单数据';

  public static function add($user_id, $field_id, $value)
  {
    $field_value = xonFormValue::getBy(compact('user_id', 'field_id'));
    if ($field_value === null) {
      // 添加
      $uid = x5on::getUid();
      self::insert(compact('uid', 'user_id', 'field_id', 'value'));
    } else {
      // 修改
      $uid = $field_value->uid;
      self::setsByUid(compact('value'), $uid);
    }

  }

}