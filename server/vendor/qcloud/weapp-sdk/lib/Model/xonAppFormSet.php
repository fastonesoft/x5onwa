<?php
namespace QCloud_WeApp_SDK\Model;

use \Exception;

class xonAppFormSet extends cAppinfo
{
  protected static $tableName = 'xonAppFormSet';
  protected static $tableTitle = '系统表单设置';

  public static function saveSchoolSet ($sch_id, $form_id, $set_name, $checked) {
    $res = dbs::row('xonAppFormSet', ['*'], compact('sch_id', 'set_name'));
    if ( $res === null ) {
      $uid = x5on::getUid();
      dbs::insert('xonAppFormSet', compact('uid', 'sch_id', 'form_id', 'set_name', 'checked'));
    } else {
      $uid = $res->uid;
      dbs::update('xonAppFormSet', compact('form_id', 'checked'), compact('uid'));
    }
  }

  // 返回是否已设置
  public static function checkSchoolSet ($sch_id, $set_name) {
    $res = dbs::row('xonAppFormSet', ['*'], compact('sch_id', 'set_name'));
    return $res === null ? false : $res->checked;
  }
}
