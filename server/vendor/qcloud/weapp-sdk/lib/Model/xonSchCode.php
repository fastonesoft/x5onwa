<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as DB;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class xonSchCode
{
  /**
   * 分段号码生成
   * @param     $user_uid   用户编号
   * @param     $group_id   用户权限组
   * @throws Exception
   */
  public static function paracode ($howmany, $total, $bit, $ord, $prev, $sch_id) {
    DB::insert('xonCode', compact('message'));
  }
}
