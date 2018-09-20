<?php
namespace QCloud_WeApp_SDK\Mvv;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Model\x5on;
use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class mvvRoledist
{

  public static function getGroupUser ($user_id, $name) {
    $group_id = x5on::GROUP_ADMIN_VALUE;
    $res = dbs::row('xonUserGroup', ['*'], compact('user_id', 'group_id'));

    if ($res !== null) {
      // 系统管理员：可以对所有人，分组
      $result = dbs::select('xovUser', ['id', 'name', 'nick_name', '0 as checked'], compact('name'));
    } else {
      // 学校管理员：注册学校，返回学校老师查询信息；没有注册，无信息返回
      $group_id = x5on::GROUP_SCHOOL_ADMIN_VALUE;
      $usergroup = dbs::row('xonUserGroup', ['*'], compact('user_id', 'group_id'));
      $school = dbs::row('xovSchoolTeach', ['*'], compact('user_id'));
      if ($usergroup !== null && $school !== null) {
        $sch_id = $school -> sch_id;
        $user_name = $name;
        $result = dbs::select('xovSchoolTeach', ['user_id as id', 'user_name as name', 'nick_name', '0 as checked'], compact('sch_id', 'user_name'));
      } else {
        // 否：不返回数据
        $result = [];
      }
    }
    return $result;
  }

}
