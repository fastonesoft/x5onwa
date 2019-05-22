<?php
namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\xonSysValue;

class mvvSysValue
{
  public static function values($key_id) {
    return xonSysValue::getsBy(compact('key_id'));
  }

  public static function add($id, $key_id, $value, $valuex) {
    return xonSysValue::add($id, $key_id, $value, $valuex);
  }

  public static function edit($uid, $name) {
    $key = xonSysValue::getBy(compact('name'));
    if ($key !== null && $key->uid !== $uid) {
      throw new \Exception('系统键值名称已存在');
    }
    xonSysValue::setsByUid(compact('name'), $uid);
    return xonSysValue::getByUid($uid);
  }

  public static function del($uid) {
    return xonSysValue::delByUidCustom($uid);
  }

}
