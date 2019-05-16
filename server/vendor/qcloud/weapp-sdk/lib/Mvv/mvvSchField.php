<?php
namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\xovForm;
use QCloud_WeApp_SDK\Model\xovSchStep;

class mvvSchField
{

  public static function steps($sch_admin_user_id) {
    $result = [];
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use (&$result) {
      $sch_id = $user_sch_group->sch_id;

      $graduated = 0;
      $result = xovSchStep::getsBy(compact('sch_id', 'graduated'));
    });
    return $result;
  }

  public static function forms($sch_admin_user_id, $steps_id) {
    $result = [];
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($steps_id, &$result) {
      $sch_id = $user_sch_group->sch_id;

      $result = xovForm::getsBy(compact('steps_id'));
    });
    return $result;
  }


}
