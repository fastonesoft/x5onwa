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
    $res = x5on::checkIdc($idc, 12, 18);
    // 没有问题
    if ( $res === NULL ) {
      $child = dbs::row('xonChild', ['*'], compact('id'));
      if ($child === NULL) {
        // 添加孩子
        $uid = bin2hex(openssl_random_pseudo_bytes(16));
        dbs::insert('xonChild', compact('id', 'uid', 'idc', 'name'));
      } else {
        // 存在孩子，检测是否信息吻合
        if ( $child->name !== $name ) {
          $error = true;
          $message = '孩子信息不吻合';
          return compact('error', 'message');
        }
      }
      return NULL;
    } else {
      // 出错
      return $res;
    }
  }

  public static function update () {

  }

  public static function delete () {

  }
}
