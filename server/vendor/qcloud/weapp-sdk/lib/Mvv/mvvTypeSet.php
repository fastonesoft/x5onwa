<?php
namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\xonType;

class mvvTypeSet
{

  public static function types() {
    return xonType::gets();
  }

  public static function add($id, $name) {
    return xonType::add($id, $name);
  }

  public static function del($uid) {
    xonType::checkByUid($uid);
    return xonType::delByUidCustom($uid);
  }




}
