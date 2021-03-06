<?php
namespace QCloud_WeApp_SDK\Model;

class xonFormField extends cAppinfo
{
  protected static $tableName = 'xonFormField';
  protected static $tableTitle = '表单字段';

  public static function add($form_id, $mode, $label, $orde)
  {
    self::existByCustom(compact('form_id', 'label'), '字段名称已存在');

    $max_id = self::max('id', compact('form_id'));
    $id = x5on::getMaxId($max_id, $form_id, 2);
    $uid = x5on::getUid();
    self::insert(compact('id', 'uid', 'form_id', 'mode', 'label', 'orde'));
    return xovFormField::getById($id);
  }

}