<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as DB;
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
      // 转换为js能识别的正则，去掉两头的/
      $regex = $key->regex;
      $key->regex = str_replace('/', '', $regex);
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
