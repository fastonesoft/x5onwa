<?php
namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\xovSchoolYear;

class mvvSchYear
{

  public static function years($sch_admin_user_id) {
    $result = [];
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use (&$result) {
      $sch_id = $user_sch_group->sch_id;

      $result = xovSchoolYear::getsBy(compact('sch_id'));
    });
    return $result;
  }

}
