<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class xonChild extends cAppinfo
{
  protected static $tableName = 'xonChild';
  protected static $tableTitle = '孩子表';

  public static function addChild ($idc, $name) {
    $id = $idc;
    // 检测身份证
    x5on::checkIdc($idc, 12, 18);
    $res = self::getById($id);
    if ( $res !== null ) throw new Exception('孩子信息不吻合');
    // 添加孩子
    $uid = x5on::getUid();
    self::insert(compact('id', 'uid', 'idc', 'name'));
  }
}
