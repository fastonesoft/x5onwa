<?php
namespace QCloud_WeApp_SDK\Mvv;

class mvvStudrexam
{

  // 审核年级列表
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

  // 报名信息复核
  public static function rexam($sch_user_id, $reg_stud_uid) {
    $result = 0;
    mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($sch_user_id, $reg_stud_uid, $stud_auth, &$result) {
      $sch_id = $user_sch_group->sch_id;

      // 一、检测报名记录是否确认
      $uid = $reg_stud_uid;
      $confirmed = 1;
      xovStudReg::checkByCustom(compact('uid', 'confirmed'), '报名信息未确认，无法审核');

      // 二、检测报名记录是否审核
      $examed = 1;
      xovStudReg::checkByCustom(compact('uid', 'examed'), '报名信息未审核，无法确认');

      // 三、检测报名记录是否确认
      $rexamed = 1;
      xovStudReg::existByCustom(compact('uid', 'rexamed'), '报名信息确认通过，无需再审');

      // 三、没有确认，通过确认
      $rexam_user_id = $sch_user_id;
      $result = xonStudReg::setsByUid(compact('stud_auth', 'rexam_user_id'), $reg_stud_uid);
    });
    return $result;
  }

  // 将用户确认信息退回
  public static function reject($sch_user_id, $reg_stud_uid) {
    $result = 0;
    mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($sch_user_id, $reg_stud_uid, $stud_auth, &$result) {
      $sch_id = $user_sch_group->sch_id;

      $uid = $reg_stud_uid;
      // 三、检测报名记录是否确认
      $rexamed = 1;
      xovStudReg::existByCustom(compact('uid', 'rexamed'), '报名信息确认通过，无法退回');

      // 三、没有确认，通过确认
      $stud_auth = 0;
      $exam_user_id = null;
      $result = xonStudReg::setsByUid(compact('stud_auth', 'exam_user_id'), $reg_stud_uid);
    });
    return $result;
  }


}
