<?php
namespace QCloud_WeApp_SDK\Model;

class xonUserGroupSchool extends cAppinfo
{
  protected static $tableName = 'xonUserGroupSchool';
  protected static $tableTitle = '用户分组学校';

  public static function add($sch_id, $user_id, $group_id)
  {
    if ($group_id > x5on::GROUP_ADMIN_SCHOOL) throw new \Exception('学校用户权限分组有上限');
    self::existByCustom(compact('sch_id', 'user_id', 'group_id'), '用户学校分组已存在，不必重复添加');

    // 一、清除原先的记录checked值
    $checked = 0;
    self::setsBy(compact('checked'), compact('user_id'));

    // 二、将当前添加的作为最新的
    $checked = 1;
    $uid = x5on::getUid();
    return self::insert(compact('uid', 'sch_id', 'user_id', 'group_id', 'checked'));
  }

}