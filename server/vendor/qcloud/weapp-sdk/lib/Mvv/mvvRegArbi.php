<?php
namespace QCloud_WeApp_SDK\Mvv;

class mvvRegArbi
{

  // 学校分级
  public static function step($sch_user_id) {
    $result = [];
    mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use (&$result) {
      $sch_id = $user_sch_group->sch_id;

      // 可以招生的学校分级
      $can_recruit = 1;
      $result = xovSchStep::getsBy(compact('sch_id', 'can_recruit'));
    });
    return $result;
  }

}
