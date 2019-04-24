<?php
namespace QCloud_WeApp_SDK\Model;

class xonUserSchool extends cAppinfo
{
  protected static $tableName = 'xonUserSchool';
  protected static $tableTitle = '用户学校';

  public static function add($user_id, $sch_id) {
    // 检测当前学校是否已分配
    self::existByCustom(compact('sch_id', 'user_id'), '用户学校已分配，不必重复设置');

    // 清除原来的学校当前记录
    $current_year = 0;
    self::setsBy(compact('current_year'), compact('user_id'));

    // 设置添加的学校为当前记录
    $current_year = 1;
    $id = x5on::getUid();
    $uid = x5on::getUid();
    self::insert(compact('id', 'uid', 'sch_id', 'user_id', 'current_year'));
    return $id;
  }
}