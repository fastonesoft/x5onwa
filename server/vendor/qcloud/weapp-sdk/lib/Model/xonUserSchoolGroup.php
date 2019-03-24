<?php
namespace QCloud_WeApp_SDK\Model;

class xonUserSchoolGroup extends cAppinfo
{
  protected static $tableName = 'xonUserSchoolGroup';
  protected static $tableTitle = '用户学校分组';

  public static function add($user_sch_id, $group_id)
  {
    if ($group_id > x5on::GROUP_ADMIN_SCHOOL) throw new \Exception('学校用户权限分组有上限');
    self::existByCustom(compact('user_sch_id', 'group_id'), '用户学校分组已存在，不必重复添加');

    $uid = x5on::getUid();
    self::insert(compact('uid', 'user_sch_id', 'group_id'));
    return $uid;
  }

}