<?php

namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\xonUser;
use QCloud_WeApp_SDK\Model\xonUserGroupSchool;
use QCloud_WeApp_SDK\Model\xovUser;
use QCloud_WeApp_SDK\Model\xovUserSchoolGroup;

class mvvUsereset
{

  public static function user($admin_user_id, $find_name)
  {
    $result = [];
    mvvUserSchoolGroup::admin($admin_user_id, function () use ($find_name, &$result) {
      $name = $find_name;
      $result = xovUser::likes(compact('name'));
    });
    return $result;
  }

  public static function update($admin_user_id, $user_uid, $confirmed, $fixed)
  {
    $result = 0;
    mvvUserSchoolGroup::admin($admin_user_id, function () use ($user_uid, $confirmed, $fixed, &$result) {
      xonUser::checkByUid($user_uid);
      $result = xonUser::setsByUid(compact('confirmed', 'fixed'), $user_uid);
    });
    return $result;
  }

}
