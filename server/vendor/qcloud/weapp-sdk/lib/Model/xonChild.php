<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class xonChild
{

  public static function insert ($id, $idc, $name) {
    // 检测身份证
    x5on::checkIdc($idc, 12, 18);
    $res = dbs::row('xonChild', ['*'], compact('id'));
    if ( $res !== null ) throw new Exception('孩子信息不吻合');
    // 添加孩子
    $uid = x5on::getUid();
    dbs::insert('xonChild', compact('id', 'uid', 'idc', 'name'));
  }

}
