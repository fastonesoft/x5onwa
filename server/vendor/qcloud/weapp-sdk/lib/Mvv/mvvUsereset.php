<?php

namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\xonUser;
use QCloud_WeApp_SDK\Model\xonUserGroupSchool;
use QCloud_WeApp_SDK\Model\xovUser;
use QCloud_WeApp_SDK\Model\xovUserSchoolGroup;

class mvvUsereset
{

  public static function user($user_id, $find_name)
  {
    global $result;
    mvvUser::admins($user_id, function ($name) {
      global $result;
      $result = xovUser::likes(compact('name'));
    }, function ($sch_admin_user, $name) {
      global $result;
      $sch_id = $sch_admin_user->sch_id;
      $result = xovUser::likesBy(compact('sch_id'), compact('name'));
    }, $find_name);
    return $result;
  }

  public static function update($user_uid, $confirmed, $fixed)
  {
    xonUser::checkByUid($user_uid);
    return xonUser::setsByUid(compact('confirmed', 'fixed'), $user_uid);
  }


}
