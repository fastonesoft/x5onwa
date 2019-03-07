<?php
namespace QCloud_WeApp_SDK\Model;

use QCloud_WeApp_SDK\Mysql\Mysql as dbs;

class xonSchoolFormValue
{

  public static function saveKeyValue ($user_id, $form_id, $key_id, $value) {
    $value = $value === 'true' ? 1 : $value;
    $value = $value === 'false' ? 0 : $value;
    // 保存结果
    $res = dbs::row('xonSchoolFormValue', ['*'], compact('user_id', 'form_id', 'key_id'));
    if ( $res === null ) {
      $uid = x5on::getUid();
      dbs::insert('xonSchoolFormValue', compact('uid', 'user_id', 'form_id', 'key_id', 'value'));
    } else {
      $uid = $res->uid;
      dbs::update('xonSchoolFormValue', compact('value'), compact('uid'));
    }
  }

  // 检测表单是否已提交过
  public static function checkFormHasValues ($user_id, $form_id) {
    $res = dbs::select('xonSchoolFormValue', ['*'], compact('user_id', 'form_id'));
    return count($res) !== 0 ? true : false;
  }

}
