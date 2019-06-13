<?php
namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\xonStudAuth;
use QCloud_WeApp_SDK\Model\xovAreas;
use QCloud_WeApp_SDK\Model\xovSchStep;

class mvvStudexam
{

  // 学校分级、学生类别
  public static function step_auth($sch_user_id) {
    $result = [];
    mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use (&$result) {
      $sch_id = $user_sch_group->sch_id;

      // 可以招生的学校分级
      $can_recruit = 1;
      $steps = xovSchStep::getsBy(compact('sch_id', 'can_recruit'));

      // 学生类别
      $auths = xonStudAuth::gets();
      $result = compact('steps', 'auths');
    });
    return $result;
  }


}
