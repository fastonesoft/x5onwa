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

  public static function add($sch_admin_user_id, $year, $is_current) {
    $result = [];
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($year, $is_current, &$result) {
      $sch_id = $user_sch_group->sch_id;

      $result = xonSchYear::add($sch_id, $year, $is_current);
    });
    return $result;
  }

  public static function edit($sch_admin_user_id, $sch_year_uid, $is_current_string) {
    $result = [];
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($sch_year_uid, $is_current_string, &$result) {
      $sch_id = $user_sch_group->sch_id;

      // 检查是否存在
      xonSchYear::checkByUid($sch_year_uid);

      $is_current = x5on::getBool($is_current_string);
      if ($is_current) {
        // 若设置为当前，先清除原先的
        $is_current = 0;
        xonSchYear::setsBy(compact('is_current'), compact('sch_id'));
        $is_current = 1;
      }

      xonSchYear::setsByUid(compact('is_current'), $sch_year_uid);
      $result = xovSchYear::getByUid($sch_year_uid);
    });
    return $result;
  }

  public static function del($sch_admin_user_id, $sch_year_uid) {
    $result = [];
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($sch_year_uid) {
      $sch_id = $user_sch_group->sch_id;

      xonSchYear::checkByUid($sch_year_uid);
      $result = xonSchYear::delByUidCustom($sch_year_uid);
    });
    return $result;
  }

}
