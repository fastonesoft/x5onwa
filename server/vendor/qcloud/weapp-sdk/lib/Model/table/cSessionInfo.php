<?php
namespace QCloud_WeApp_SDK\Model;

class cSessionInfo extends cAppinfo
{
  protected static $tableName = 'cSessionInfo';
  protected static $tableTitle = '会话管理用户信息';

  public static function add($userinfo, $skey, $session_key)
  {
    $uuid = x5on::getUid();
    $create_time = date('Y-m-d H:i:s');
    $last_visit_time = $create_time;
    $open_id = $userinfo->openId;
    $user_info = json_encode($userinfo);

    $res = self::getBy(compact('open_id'));
    if ($res === NULL) {
      self::insert(compact('uuid', 'skey', 'create_time', 'last_visit_time', 'open_id', 'session_key', 'user_info'));
    } else {
      self::setsBy(compact('skey', 'last_visit_time', 'session_key', 'user_info'), compact('open_id'));
    }
  }

}