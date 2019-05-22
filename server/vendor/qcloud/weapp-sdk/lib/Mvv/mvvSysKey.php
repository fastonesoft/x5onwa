<?php
namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\xonSysKey;

class mvvSysKey
{
  public static function keys() {
    return xonSysKey::gets();
  }

  public static function add($id, $name) {
    return xonSysKey::add($id, $name);
  }

  public static function edit($uid, $name) {
    $key = xonSysKey::getBy(compact('name'));
    if ($key !== null && $key->uid !== $uid) {
      throw new \Exception('系统键值名称已存在');
    }
    xonSysKey::setsByUid(compact('name'), $uid);
    return xonSysKey::getByUid($uid);
  }

  public static function del($uid) {
    return xonSysKey::delByUidCustom($uid);
  }

}
