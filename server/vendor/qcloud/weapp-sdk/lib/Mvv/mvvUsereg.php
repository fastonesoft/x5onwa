<?php

namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\xonSchool;
use QCloud_WeApp_SDK\Model\xonUser;
use QCloud_WeApp_SDK\Model\xonUserSchool;
use QCloud_WeApp_SDK\Model\xovSchool;
use QCloud_WeApp_SDK\Model\xovUser;
use QCloud_WeApp_SDK\Model\xovUserOnly;

class mvvUsereg
{

  /**
   * @param $user_id
   * @throws \Exception
   */
  public static function school($user_id)
  {
    global $result;
    mvvUser::admins($user_id, function () {
      global $result;
      $result = xovSchool::gets();
    }, function ($sch_admin_user) {
      global $result;
      $sch_id = $sch_admin_user->sch_id;
      $result = xovSchool::getsById($sch_id);
    });
    return $result;
  }

  /**
   * @param $user_id
   * @param $name
   * @throws \Exception
   */
  public static function user($name)
  {
    return xovUserOnly::likes(compact('name'));
  }

  public static function reg($user_uid, $sch_uid)
  {
    $user = xonUser::checkByUid($user_uid);
    $school = xonSchool::checkByUid($sch_uid);
    $user_id = $user->id;
    $sch_id = $school->id;

    xonUserSchool::add($user_id, $sch_id);
    return xovUser::getsBy(compact('sch_id'));
  }

  public static function member($sch_uid)
  {
    $school = xonSchool::checkByUid($sch_uid);
    $sch_id = $school->id;

    return xovUser::getsBy(compact('sch_id'));
  }


  public static function memfind($sch_uid, $name)
  {
    $school = xonSchool::checkByUid($sch_uid);
    $sch_id = $school->id;

    return xovUser::likesBy(compact('sch_id'), compact('name'));
  }

  public static function del($user_uid)
  {
    $user = xonUser::checkByUid($user_uid);
    $user_id = $user->id;
    return xonUserSchool::delBy(compact('user_id'));
  }
}
