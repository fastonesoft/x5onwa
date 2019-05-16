<?php
namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\x5on;
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

  public static function add($sch_admin_user_id, $year, $current_year) {
    $result = [];
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($year, $current_year, &$result) {
      $sch_id = $user_sch_group->sch_id;

      $result = xonSchYear::add($sch_id, $year, $current_year);
    });
    return $result;
  }

  public static function edit($sch_admin_user_id, $sch_year_uid, $current_year_string) {
    $result = [];
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($sch_year_uid, $current_year_string, &$result) {
      $sch_id = $user_sch_group->sch_id;

      // 检查是否存在
      xonSchYear::checkByUid($sch_year_uid);

      $current_year = x5on::getBool($current_year_string);
      if ($current_year) {
        // 若设置为当前，先清除原先的
        $current_year = 0;
        xonSchYear::setsBy(compact('current_year'), compact('sch_id'));
        $current_year = 1;
      }

      xonSchYear::setsByUid(compact('current_year'), $sch_year_uid);
      $result = xovSchYear::getByUid($sch_year_uid);
    });
    return $result;
  }

  public static function del($sch_admin_user_id, $sch_year_uid) {
    $result = [];
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($sch_year_uid, &$result) {
      $sch_id = $user_sch_group->sch_id;

      xonSchYear::checkByUid($sch_year_uid);
      $result = xonSchYear::delByUidCustom($sch_year_uid);
    });
    return $result;
  }

}
