<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as DB;
use QCloud_WeApp_SDK\Constants;
use QCloud_WeApp_SDK\Helper;

use \Exception;

class xonUser
{
  /**
   * 保存、更新用户信息
   *
   * @param $userinfor 用户帐号
   * @throws Exception
   */
    public static function store ($userinfor) {
      $id = $userinfor->unionId;
      $uid = bin2hex(openssl_random_pseudo_bytes(16));
      $nick_name = $userinfor->nickName;
      $name = $nick_name;
      // 布尔型，直接设置数值
      $fixed = 0;
      $create_time = date('Y-m-d H:i:s');
      $last_visit_time = $create_time;

      $result = DB::row('xonUser', ['*'], compact('id'));
      if ($result === NULL) {
        DB::insert('xonUser', compact('id', 'uid', 'nick_name', 'name', 'fixed', 'create_time', 'last_visit_time'));
      } else {
        DB::update('xonUser', compact('nick_name', 'last_visit_time'), compact('id'));
      }
    }

    public static function fixed ($id, $fixed) {
      $result = DB::row('xonUser', ['*'], compact('id'));
      if ($result !== NULL) {
        DB::update('xonUser', compact('fixed'), compact('id'));
      }
    }

    // 动态输入检测用
    public static function checkRename ($id, $name) {
      $result = DB::row('xonUser', ['*'], compact('id'));
      if ($result !== NULL) {
        DB::update('xonUser', compact('name'), compact('id'));
        return NULL;
      } else {
        $error = true;
        $message = '没找到你要改的记录';
        return compact('error', 'message');
      }
    }
}
