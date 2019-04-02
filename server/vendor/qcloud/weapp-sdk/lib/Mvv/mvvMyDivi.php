<?php
namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\x5on;
use QCloud_WeApp_SDK\Model\xonClassDivi;
use QCloud_WeApp_SDK\Model\xovClass;
use QCloud_WeApp_SDK\Model\xovClass2Divi;
use QCloud_WeApp_SDK\Model\xovClassDivi;
use QCloud_WeApp_SDK\Model\xovGradeCurrent;
use QCloud_WeApp_SDK\Model\xovUser;
use QCloud_WeApp_SDK\Model\xovUserSchool;

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

  // 刷新教师、分管静静
  private static function refresh($grade_id) {
    $classes = xovClass2Divi::getsBy(compact('grade_id'));
    $classed = xovClassDivi::getsBy(compact('grade_id'));
    return compact('classes', 'classed');
  }

  public static function clsdiv($sch_admin_user_id, $grade_id)
  {
    $result = [];
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($grade_id, &$result) {
      $sch_id = $user_sch_group->sch_id;
      $result = self::refresh($grade_id);
    });
    return $result;
  }

  public static function teachs($sch_admin_user_id, $like_name)
  {
    $result = [];
    $user_name = x5on::getLike($like_name);
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($user_name, &$result) {
      $sch_id = $user_sch_group->sch_id;
      $result = xovUserSchool::likesBy(compact('sch_id'), compact('user_name'));
    });
    return $result;
  }

  // 教师分管班级分配
  private static function doDist($user_id, $cls_uids) {
    foreach ($cls_uids as $cls_uid) {
      $cls_id = xovClass::checkUid2Id($cls_uid);
      xonClassDivi::existBy(compact('cls_id', 'user_id'));
      xonClassDivi::add($cls_id, $user_id);
    }
  }

  public static function dist($sch_admin_user_id, $grade_id, $user_uid, $cls_uid_jsons)
  {
    $result = [];
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($grade_id, $user_uid, $cls_uid_jsons, &$result) {
      $sch_id = $user_sch_group->sch_id;
      $user_sch = xovUserSchool::checkByUid($user_uid);
      $user_id = $user_sch->user_id;
      $cls_uids = json_decode($cls_uid_jsons);
      self::doDist($user_id, $cls_uids);
      $result = self::refresh($grade_id);
    });
    return $result;
  }

  public static function remove($sch_admin_user_id, $class_div_uid)
  {
    $result = [];
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($class_div_uid, &$result) {
      $sch_id = $user_sch_group->sch_id;
      xonClassDivi::existByUid($class_div_uid);

      $result = xonClassDivi::delByUid($class_div_uid);
    });
    return $result;
  }

}
