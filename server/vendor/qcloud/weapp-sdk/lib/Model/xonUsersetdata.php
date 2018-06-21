<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class xonUsersetdata
{
  public static function insert ($user_id, $userset_id, $checked) {
    $result = 0;
    $res = dbs::row('xonUserSetData', ['*'], compact('user_id', 'userset_id'));
    if ($res === Null) {
      $uid = bin2hex(openssl_random_pseudo_bytes(16));
      $result = dbs::insert('xonUserSetData', compact('uid', 'user_id', 'userset_id', 'checked'));
    } else {
      $uid = $res->uid;
      $result = dbs::update('xonUserSetData', compact('checked'), compact('uid'));
    }
    return $result;
  }

  public static function update ($uid, $checked) {
    dbs::update('xonUserSetData', compact('checked'), compact('uid'));
  }

  public static function delete ($uid) {
    dbs::delete('xonUserSetData', compact('uid'));
  }

  public static function getCheckedById ($user_id, $userset_name) {
    $userset_id = xonUserset::getIdByUserSetName($userset_name);
    $res = dbs::row('xonUserSetData', ['*'], compact('user_id', 'userset_id'));

    return $res !== NULL ? $res->checked : NULL;
  }
}
