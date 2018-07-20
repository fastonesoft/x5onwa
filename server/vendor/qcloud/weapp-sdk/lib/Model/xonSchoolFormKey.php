<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class xonSchoolFormKey
{

  public static function insert () {

  }

  public static function update () {

  }

  public static function delete () {

  }


  public static function getDefaultKeysByFormId($form_id) {
    $res = dbs::select('xonSchoolFormKey', ['*', 'default_value as value, required as error'], compact('form_id'));
    foreach ($res as $key) {
      $regex = $key->regex_php;
      unset($key->regex_php);
      unset($key->default_value);
      if ($key->view_type === 'picker') {
        $key->value = explode('#', $key->value);
      }
    }
    return $res;
  }

  public static function getKeysByFormId($user_id, $form_id) {
    $items = dbs::select('xonSchoolFormKey', ['*', 'default_value as value, required as error'], compact('form_id'));
    $values = dbs::select('xonSchoolFormValue', ['*'], compact('user_id', 'form_id'));

    // 验证表单数据（包括缺省值）
    foreach ($items as $key) {
      $regex = $key->regex_php;
      unset($key->regex_php);
      if ($key->view_type === 'picker') {
        $key->default_value = explode('#', $key->default_value);
      }
      foreach ($values as $value) {
        if ($key->id === $value->key_id) {
          $key->value = $value->value ? $value->value : $key->value;
          $key->error = $key->required && ! preg_match($regex, $key->value);
          break;
        }
      }
    }
    return $items;
  }

  public static function listKeysByFormId($user_id, $form_id) {
    $items = dbs::select('xonSchoolFormKey', ['*', 'required as error'], compact('form_id'));
    $values = dbs::select('xonSchoolFormValue', ['*'], compact('user_id', 'form_id'));
    if ( count($values) === 0 ) {
      return $values;
    }
    // 验证表单数据（包括缺省值）
    foreach ($items as $key) {
      $regex = $key->regex_php;
      unset($key->regex_php);
      unset($key->regex_js);
      foreach ($values as $value) {
        if ($key->id === $value->key_id) {
          $key->value = $value->value ? $value->value : $key->value;
          $key->error = $key->required && ! preg_match($regex, $key->value);
          break;
        }
      }
      if ($key->view_type === 'picker') {
        $key->default_value = explode('#', $key->default_value);
        $key->value = $key->default_value[$key->value];
      }
    }
    return $items;
  }


  public static function checkKeyValue($form_id, $name, $value) {
    $value = $value === 'true' ? 1 : $value;
    $value = $value === 'false' ? 0 : $value;
    $res = dbs::row('xonSchoolFormKey', ['*'], compact('form_id', 'name'));
    if ( $res === null ) {
      throw new Exception("没有找到表单对应的键值");
    } else {
      $regex = $res->regex_php;
      if ( ! preg_match($regex, $value) ) {
        throw new Exception("键值输入不满足正则约束");
      }

      if ( strpos($res->name, 'idcard') ) {
        // 检测身份证30+
        $idc_result = x5on::checkIdc($value, 30, 0);
        if ( $idc_result !== null ) {
          throw new Exception($idc_result['message']);
        }
      }
      return $res->id;
    }
  }

}
