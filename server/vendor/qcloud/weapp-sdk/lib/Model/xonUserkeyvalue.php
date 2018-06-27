<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class xonUserkeyvalue
{
  public static function insert ($user_id, $key_id, $value, $check_unique) {
    $userkeyvalue = dbs::row('xonUserKeyValue', ['*'], compact('user_id', 'key_id'));
    // 检测记录
    if ( $userkeyvalue === NULL ) {
      // 唯一检测
      $value_unique = dbs::row('xonUserKeyValue', ['*'], compact('value'));
      if ( $check_unique && $value_unique !== NULL ) {
        $error = true;
        $message = '提交数据无法通过唯一检测';
        return compact('error', 'message');
      } else {
        $uid = bin2hex(openssl_random_pseudo_bytes(16));
        dbs::insert('xonUserKeyValue', compact('uid', 'user_id', 'key_id', 'value'));
      }
    } else {
      $uid = $userkeyvalue->uid;
      dbs::update('xonUserKeyValue', compact('value'), compact('uid'));
    }
    return NULL;
  }

  public static function update () {

  }

  public static function delete () {

  }

}
