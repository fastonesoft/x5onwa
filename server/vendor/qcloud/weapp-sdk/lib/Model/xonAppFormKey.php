<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class xonAppFormKey
{

  public static function insert () {

  }

  public static function update () {

  }

  public static function delete () {

  }

  public static function getDefaultKeysByFormId($form_id) {
    $res = dbs::select('xonAppFormKey', ['*', 'default_value as value'], compact('form_id'));
    foreach ($res as $key) {
      $regex = $key->regex_php;
      unset($key->regex_php);
      unset($key->default_value);
      $key->error = ! preg_match($regex, $key->value);
    }
    return $res;
  }

  public static function getKeysByFormId($sch_id, $form_id) {
    $res = dbs::select('xonAppFormKey', ['*', 'required as error, default_value as value'], compact('form_id'));
    $values = dbs::select('xonAppFormValue', ['*'], compact('sch_id', 'form_id'));

    // 验证表单数据（包括缺省值）
    foreach ($res as $key) {
      $regex = $key->regex_php;
      unset($key->regex_php);
      foreach ($values as $value) {
        if ($key->id === $value->key_id) {
          $key->value = $value->value ? $value->value : $key->value;
          $key->error = $key->required && ! preg_match($regex, $key->value);

          break;
        }
      }
    }
    return $res;
  }

}
