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
      // 有值，添加；空值，无动作
      $uid = x5on::getUid();
      isset($value) && self::insert(compact('uid', 'user_id', 'field_id', 'value'));
    } else {
      $uid = $field_value->uid;
      if (isset($value)) {
        // 有值，修改
        self::setsByUid(compact('value'), $uid);
      } else {
        // 空值，删除
        self::delByUid($uid);
      }
    }
  }

}