<?php
namespace QCloud_WeApp_SDK\Model;

class xonForm extends cAppinfo
{
  protected static $tableName = 'xonForm';
  protected static $tableTitle = '表单列表';

  public static function add($title, $notfixed, $type_id, $steps_id, $years_id)
  {
    $max_id = self::max('id', compact('steps_id'));
    $id = x5on::getMaxId($max_id, $steps_id, 4);
    $uid = x5on::getUid();
    self::insert(compact('id', 'uid', 'title', 'notfixed', 'type_id', 'steps_id', 'years_id'));
    return self::getById($id);
  }

}