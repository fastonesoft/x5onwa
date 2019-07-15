<?php
namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\x5on;
use QCloud_WeApp_SDK\Model\xonForm;
use QCloud_WeApp_SDK\Model\xonStudReg;
use QCloud_WeApp_SDK\Model\xovFormField;
use QCloud_WeApp_SDK\Model\xovFormValue;
use QCloud_WeApp_SDK\Model\xovSchStep;
use QCloud_WeApp_SDK\Model\xovStudReg;

class mvvRegRexam
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

  // 根据学生报名编号、分级，查询报名信息
  public static function fields($sch_user_id, $reg_stud_uid, $reg_steps_id) {
    $result = [];
    mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($sch_user_id, $reg_stud_uid, $reg_steps_id, &$result) {
      $sch_id = $user_sch_group->sch_id;

      // 获取regstud记录
      $reg_stud = xovStudReg::checkByUidCustom($reg_stud_uid, '没有找到二维码对应学生信息');
      // 获取其它辅助信息
      $steps_id = $reg_stud->steps_id;
      $years_id = $reg_stud->years_id;
      $user_id = $reg_stud->user_id;
      $exam_user_id = $reg_stud->exam_user_id;
      // “报名”的分类编号
      $type_id = 1;
      // 没有取消的表格
      $notfixed = 1;

      // 一、检测初审、复核是否为同一个人
      if ($exam_user_id === $sch_user_id) throw new \Exception('报名审核、确认不得为同一人！');

      // 一、检测报名年级是不是当前审核的年级
      if ($steps_id !== $reg_steps_id) throw new \Exception('非当前年级对应的二维码信息，无法审核！');
      // 二、检测是否确认
      $uid = $reg_stud_uid;
      $confirmed = 1;
      xonStudReg::checkByCustom(compact('uid', 'confirmed'), '报名信息未确认，无法审核');
      // 三、检测是否初审
      $examed = 1;
      xovStudReg::checkByCustom(compact('uid', 'examed'), '报名信息未通过审核，无法确认');
      // 四、检测是否复核
      $rexamed = 1;
      xovStudReg::existByCustom(compact('uid', 'rexamed'), '报名信息确认通过，无需再审');

      // 取表单数据
      $form = xonForm::checkByCustom(compact('steps_id', 'years_id', 'type_id', 'notfixed'), '没有发现要填报的表格');
      $form_id = $form->id;

      $fields = xovFormField::getsBySuff(compact('form_id'), 'order by orde, id');
      // 用户级表单字段
      $values = xovFormValue::getsBy(compact('user_id', 'form_id'));

      // 查询uid编号对应学生，数组形式返回
      $regstuds = xovStudReg::getsByUid($reg_stud_uid);
      foreach ($regstuds as $regstud) {
        $regstud->stud_auth = $regstud->stud_auth === 1;
      }

      // 添加二维码信息
      $regstuds = x5on::addsQrcode($regstuds, 'uid');

      $result = compact('regstuds', 'fields', 'values');
    });
    return $result;
  }

  // 报名信息复核
  public static function rexam($sch_user_id, $reg_stud_uid) {
    $result = 0;
    mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($sch_user_id, $reg_stud_uid, &$result) {
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
    mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($sch_user_id, $reg_stud_uid, &$result) {
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
