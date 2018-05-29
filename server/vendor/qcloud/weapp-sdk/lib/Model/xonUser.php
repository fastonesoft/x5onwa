<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as DB;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class xonUser
{
  /**
   * 保存、更新用户信息
   * @param $userinfor 用户帐号
   * @throws Exception
   */
    public static function store ($userinfor) {
      $uid = $userinfor->unionId;
      $name = $userinfor->nickName;
      $fixed = false;
      $create_time = date('Y-m-d H:i:s');
      $last_visit_time = $create_time;

      $res = DB::row('xonUser', ['*'], compact('uid'));
      if ($res === NULL) {
        DB::insert('xonUser', compact('uid', 'name', 'fixed', 'create_time', 'last_visit_time'));
      } else {
        DB::update(
          'xonUser',
          compact('name', 'last_visit_time'),
          compact('uid')
        );
      }
    }

  /**
   * 更新用户信息
   * @param $uid 用户编号
   * @param $fixed 用户状态
   * @throws Exception
   */
    public static function update ($uid, $fixed) {
      $res = DB::row('xonUser', ['*'], compact('uid'));
      if ($res !== NULL) {
        DB::update(
          'xonUser',
          compact('fixed'),
          compact('uid')
        );
      }
    }
}
