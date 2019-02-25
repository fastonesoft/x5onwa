<?php
namespace QCloud_WeApp_SDK\Model;

use \Exception;

class xonAppForm extends cAppinfo
{
  protected static $tableName = 'xonAppForm';
  protected static $tableTitle = '系统表单名称';

  

  public static function getFormsById($app_id) {
    $res = dbs::select('xonAppForm', ['id', 'name'], compact('app_id'));
    return $res;
  }

  public static function getFormNameById($form_id) {
    $id = $form_id;
    $res = dbs::row('xonAppForm', ['*'], compact('id'));
    return $res === null ? null : $res->name;
  }
}
