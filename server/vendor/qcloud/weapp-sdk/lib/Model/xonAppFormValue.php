<?php
namespace QCloud_WeApp_SDK\Model;

use \Exception;

class xonAppFormValue extends cAppinfo
{
  protected static $tableName = 'xonAppFormValue';
  protected static $tableTitle = '系统表单值';

  public static function saveKeyValue ($sch_id, $form_id, $key_id, $value) {
    $value = $value === 'true' ? 1 : $value;
    $value = $value === 'false' ? 0 : $value;
    // 保存结果
    $res = dbs::row('xonAppFormValue', ['*'], compact('sch_id', 'form_id', 'key_id'));
    if ( $res === null ) {
      $uid = x5on::getUid();
      dbs::insert('xonAppFormValue', compact('uid', 'sch_id', 'form_id', 'key_id', 'value'));
    } else {
      $uid = $res->uid;
      dbs::update('xonAppFormValue', compact('value'), compact('uid'));
    }
  }

}
