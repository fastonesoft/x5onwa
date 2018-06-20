<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class xonUserset
{
  /**
   * @param $keys      UserKeys列表
   * @param $values    UserValues列表
   * @return mixed     UserKeys列表
   */
  public static function merge ($keys, $values) {
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

  public static function getIdByName ($name) {
    $userset = dbs::row('xonUserSet', ['*'], compact('name'));
    $res = $userset !== NULL ? $userset->id : NULL;
    return $res;
  }

  public static function insert () {

  }

  public static function update () {

  }

  public static function delete () {

  }
}
