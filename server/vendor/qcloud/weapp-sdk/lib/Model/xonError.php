<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as DB;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class xonError
{
  /**
   * 错误信息添加
   * @param $user_uid   用户编号
   * @param $group_id   用户权限组
   * @throws Exception
   */
  public static function insert ($message) {
    DB::insert('xonError', compact('message'));
  }
}
