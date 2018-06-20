<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class xonUsersetdata
{
  public static function insert ($user_id, $userset_id, $checked) {
    $res = dbs::row('xonUserSetData', ['*'], compact('user_id', 'userset_id'));
    if ($res === Null) {
      $uid = bin2hex(openssl_random_pseudo_bytes(16));
      dbs::insert('xonUserSetData', compact('uid', 'user_id', 'userset_id', 'checked'));
    } else {
      dbs::update('xonUserSetData', compact('checked'), compact('user_id', 'userset_id'));
    }
  }

  public static function update ($uid, $checked) {
    dbs::update('xonUserSetData', compact('checked'), compact('uid'));
  }

  public static function delete ($uid) {
    dbs::delete('xonUserSetData', compact('uid'));
  }
}
