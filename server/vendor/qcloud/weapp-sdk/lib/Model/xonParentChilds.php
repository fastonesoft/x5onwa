<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class xonParentChilds
{
  public static function insert () {

  }

  public static function update () {

  }

  public static function delete () {

  }

  public static function mychilds ($user_id) {
    return $res = dbs::select('xovParentChilds', ['uid', 'idc', 'child_id', 'child_name', 'relation_name'], compact('user_id'));
  }

  public static function myrelation($user_id, $child_id, $relation_id) {
    $user_child = dbs::row('xovParentChilds', ['uid', 'idc', 'child_name', 'relation_name'], compact('user_id', 'child_id'));
    $child_relation = dbs::row('xovParentChilds', ['uid', 'idc', 'child_name', 'relation_name'], compact('child_id', 'relation_id'));

    // 即没有登记：用户孩子记录，又没有：学生关系记录
    // 基本确定，可以添加用户孩子的关系
    if ( $user_child !== NULL ) {
      $error = true;
      $message = '无需重复添加孩子记录';
      return compact('error', 'message');
    }
    if ( $child_relation !== NULL ) {
      $error = true;
      $message = '同一孩子不能注册多个相同关系';
      return compact('error', 'message');
    }

    // 注册学生关系
    $pay_day = 0;
    $pay_time = date('Y-m-d H:i:s');
    $uid = bin2hex(openssl_random_pseudo_bytes(16));
    dbs::insert('xonParentChilds', compact('uid', 'user_id', 'child_id', 'relation_id', 'pay_time', 'pay_day'));
    return NULL;
  }

}
