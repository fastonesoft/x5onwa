<?php
namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\xonSub;

class mvvSubSet
{

  public static function subs() {
    return xonSub::gets();
  }

  public static function add($id, $name, $short) {
    return xonSub::add($id, $name, $short);
  }

  public static function del($uid) {
    xonSub::checkByUid($uid);
    return xonSub::delByUidCustom($uid);
  }

}
