<?php
namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\xonSchool;

class mvvUserDist
{

  // 学校管理员管辖学校列表
  public static function schos($user_id) {
    $result = [];
    mvvUserGroupSchool::schAdmin($user_id, function ($user_sch_group) use (&$result) {
      $sch_id = $user_sch_group->sch_id;
      $result = xonSchool::getsById($sch_id);
    });
    return $result;
  }

  public static function dist($sch_uid, $user_uid, $group_uid) {

  }

}
