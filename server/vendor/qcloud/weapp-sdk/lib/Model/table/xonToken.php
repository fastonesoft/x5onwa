<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use \Exception;

class xonToken
{

  public static function saveToken($id, $tokenArr) {
    $res = dbs::row('xonToken', ['*'], compact('id'));

    $access_token = $tokenArr['access_token'];
    $expires_in = $tokenArr['expires_in'];
    $create_time = date('Y-m-d H:i:s');
    if ( $res === null ) {
      dbs::insert('xonToken', compact('id', 'access_token', 'expires_in', 'create_time'));
    } else {
      dbs::update('xonToken', compact('access_token', 'expires_in', 'create_time'), compact('id'));
    }
  }

  public static function getToken($id) {
    $res = dbs::row('xonToken',['*'], compact('id'));
    if ( $res === null ) {
      return null;
    } else {
      // 过期检测
      $expires_in = $res->expires_in;
      $timeDifference = time() - strtotime($res->create_time);
      if ($timeDifference > $expires_in - 600) {
        return null;
      } else {
        return $res->access_token;
      }
    }
  }
}
