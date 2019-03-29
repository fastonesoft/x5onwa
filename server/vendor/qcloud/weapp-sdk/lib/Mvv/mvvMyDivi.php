<?php
namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\xovClass;
use QCloud_WeApp_SDK\Model\xovGradeCurrent;

class mvvMyDivi
{

  public static function grades($sch_admin_user_id)
  {
    $result = [];
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use (&$result) {
      $sch_id = $user_sch_group->sch_id;
      $result = xovGradeCurrent::getsBy(compact('sch_id'));
    });
    return $result;
  }

  public static function classes($sch_admin_user_id, $grade_id)
  {
    $result = [];
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($grade_id, &$result) {
      $sch_id = $user_sch_group->sch_id;
      $result = xovClass::getsBy(compact('grade_id'));
    });
    return $result;
  }


}
