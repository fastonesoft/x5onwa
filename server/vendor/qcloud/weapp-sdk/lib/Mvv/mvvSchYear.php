<?php
namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\xonSchYear;
use QCloud_WeApp_SDK\Model\xovSchYear;

class mvvSchYear
{

  public static function years($sch_admin_user_id) {
    $result = [];
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use (&$result) {
      $sch_id = $user_sch_group->sch_id;

      $result = xovSchYear::getsBy(compact('sch_id'));
    });
    return $result;
  }

  public static function add($sch_admin_user_id, $year, $is_current) {
    $result = [];
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($year, $is_current, &$result) {
      $sch_id = $user_sch_group->sch_id;

      $result = xonSchYear::add($sch_id, $year, $is_current);
    });
    return $result;
  }

  public static function del($sch_admin_user_id, $sch_year_uid) {
    $result = [];
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($sch_year_uid) {
      $sch_id = $user_sch_group->sch_id;

      $sch_year = xonSchYear::checkByUid($sch_year_uid);
      $result = xonSchYear::delByUidCustom($sch_year_uid);
    });
    return $result;
  }

}
