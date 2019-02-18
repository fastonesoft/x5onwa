<?php
namespace QCloud_WeApp_SDK\Model;

class xonUser extends cAppinfo
{
  protected static $tableName = 'xonUser';
  protected static $tableTitle = '用户列表';

  public static function add ($userinfor, $name, $mobil) {
    $id = $userinfor->unionId;
    $uid = x5on::getUid();
    $nick_name = $userinfor->nickName;
    $fixed = 0;
    $checked = 1;

    self::existsByCustom(compact('mobil'), '手机号码已存在');

    $result = self::getById($id);
    if ($result === NULL) {
      self::insert(compact('id', 'uid', 'nick_name', 'name', 'mobil', 'fixed', 'checked'));
    } else {
      self::setsById(compact('nick_name', 'name', 'mobil', 'checked'), $id);
    }
  }
}
