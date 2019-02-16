<?php
namespace QCloud_WeApp_SDK\Model;

use \Exception;

class xonUser extends cAppinfo
{
  protected static $tableName = 'xonUser';
  protected static $tableTitle = '用户列表';

  public static function add ($userinfor) {
    $id = $userinfor->unionId;
    $uid = x5on::getUid();
    $nick_name = $userinfor->nickName;
    $name = $nick_name;
    // 布尔型，直接设置数值
    $fixed = 0;
    $create_time = date('Y-m-d H:i:s');
    $last_visit_time = $create_time;

    $result = dbs::row('xonUser', ['*'], compact('id'));
    if ($result === NULL) {
      dbs::insert('xonUser', compact('id', 'uid', 'nick_name', 'name', 'fixed', 'create_time', 'last_visit_time'));
    } else {
      dbs::update('xonUser', compact('nick_name', 'last_visit_time'), compact('id'));
    }
  }



  // 动态输入检测用
    public static function checkRename ($id, $name) {
      $result = dbs::row('xonUser', ['*'], compact('id'));
      if ($result !== NULL) {
        dbs::update('xonUser', compact('name'), compact('id'));
        return NULL;
      } else {
        $error = true;
        $message = '没找到你要改的记录';
        return compact('error', 'message');
      }
    }

}
