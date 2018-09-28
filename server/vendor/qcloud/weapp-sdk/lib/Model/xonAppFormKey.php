<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class xonAppFormKey extends cAppinfo
{
  protected static $tableName = 'xonAppFormKey';
  protected static $tableTitle = '系统表单字段';

  public static function getDefaultKeysByFormId($form_id) {
    $res = dbs::select('xonAppFormKey', ['*', 'default_value as value'], compact('form_id'));
    foreach ($res as $key) {
      $regex = $key->regex_php;
      unset($key->regex_php);
      unset($key->default_value);
      $key->error = $key->required && ! preg_match($regex, $key->value);
    }
    return $res;
  }

  public static function checkFormKeyValue($form_id, $name, $value) {
    $value = $value === 'true' ? 1 : $value;
    $value = $value === 'false' ? 0 : $value;
    $res = dbs::row('xonAppFormKey', ['*'], compact('form_id', 'name'));
    if ( $res === null ) {
      throw new Exception("没有找到表单对应的键值");
    } else {
      $regex = $res->regex_php;
      if ( ! preg_match($regex, $value) ) {
        throw new Exception("键值输入不满足正则约束");
      }
      return $res->id;
    }
  }

  public static function getKeysByFormId($sch_id, $form_id) {
    $items = dbs::select('xonAppFormKey', ['*', 'default_value as value'], compact('form_id'));
    $values = dbs::select('xonAppFormValue', ['*'], compact('sch_id', 'form_id'));

    // 验证表单数据（包括缺省值）
    foreach ($items as $key) {
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
    $checked = xonAppFormSet::checkSchoolSet($sch_id, x5on::SCHOOL_SET_CODE);
    return compact('checked', 'items');
  }

}
