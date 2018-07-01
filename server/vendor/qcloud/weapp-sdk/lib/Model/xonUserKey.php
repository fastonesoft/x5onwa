<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class xonUserKey
{
  public static function insert () {

  }

  public static function update () {

  }

  public static function delete () {

  }

  public static function getRowByName ($name) {
    return dbs::row('xonUserKey', ['*'], compact('name'));
  }

  public static function getUserKeys ($user_id, $fixed) {
    $keys = dbs::select('xonUserKey', ['*', 'required as error'], compact('fixed'));
    $values = dbs::select('xonUserKeyValue', ['*'], compact('user_id'));

    foreach ($keys as $key) {
      $regex = $key->regex_php;
      unset($key->regex_php);
      foreach ($values as $value) {
        if ($key->id === $value->key_id) {
          $key->value = $value->value;
          $key->error = $key->required && ! preg_match($regex, $value->value);
          break;
        }
      }
    }
    return $keys;
  }
}
