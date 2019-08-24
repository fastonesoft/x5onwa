<?php
namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\x5on;
use QCloud_WeApp_SDK\Model\xonFormField;
use QCloud_WeApp_SDK\Model\xonFormValue;
use QCloud_WeApp_SDK\Model\xonStudent;
use QCloud_WeApp_SDK\Model\xonStudReg;
use QCloud_WeApp_SDK\Model\xovFormField;
use QCloud_WeApp_SDK\Model\xovFormUser;
use QCloud_WeApp_SDK\Model\xovFormValue;
use QCloud_WeApp_SDK\Model\xovStudReg;
use QCloud_WeApp_SDK\Model\xovUserChilds;

class mvvRegQuery
{

  // 统计招生总人数
  // 女生、男生分别多少
  // 报名未审核学生数
  public static function count($sch_user_id, $steps_id, $stud_auth) {
    $result = [];
    mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($steps_id, $stud_auth, &$result) {
      $sch_id = $user_sch_group->sch_id;
      if ($stud_auth === null) {
        $passed = 1;
        $total = xovStudReg::count(compact('steps_id', 'passed'));
        $sex_num = 0;
        $female = xovStudReg::count(compact('steps_id', 'passed', 'sex_num'));
        $sex_num = 1;
        $male = xovStudReg::count(compact('steps_id', 'passed', 'sex_num'));
        $passed = 0;
        $notexam = xovStudReg::count(compact('steps_id', 'passed'));
        $result = compact('total', 'female', 'male', 'notexam');
      } else {
        $passed = 1;
        $total = xovStudReg::count(compact('steps_id', 'stud_auth', 'passed'));
        $sex_num = 0;
        $female = xovStudReg::count(compact('steps_id', 'stud_auth', 'passed', 'sex_num'));
        $sex_num = 1;
        $male = xovStudReg::count(compact('steps_id', 'stud_auth', 'passed', 'sex_num'));
        $passed = 0;
        $notexam = xovStudReg::count(compact('steps_id', 'passed'));
        $result = compact('total', 'female', 'male', 'notexam');
      }
    });
    return $result;
  }

  // 报名学生查询
  public static function stud($sch_user_id, $steps_id, $child_name) {
    $result = [];
    mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($steps_id, $child_name, &$result) {
      $sch_id = $user_sch_group->sch_id;

      // 审核、未审核的报名学生，均可以查询出来
      $stud_regs = xovStudReg::likesBy(compact('steps_id'), compact('child_name'));
      $result = x5on::addsQrcode($stud_regs, 'uid');
    });
    return $result;
  }

  // 报名学生父母信息查询
  public static function parent($sch_user_id, $stud_reg_uid) {
    $result = [];
    mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($stud_reg_uid, &$result) {
      $sch_id = $user_sch_group->sch_id;

      // 获取regstud记录
      $reg_stud = xovStudReg::checkByUid($stud_reg_uid);
      // 获取其它辅助信息
      $user_id = $reg_stud->user_id;
      $steps_id = $reg_stud->steps_id;
      $years_id = $reg_stud->years_id;

      // “报名”的分类编号
      $type_id = 1;
      // 取表单数据
      $form = xovFormUser::getBy(compact('user_id', 'steps_id', 'years_id', 'type_id'));
      if ($form !== null) {
        $form_id = $form->form_id;
        $fields = xovFormField::getsBySuff(compact('form_id'), 'order by orde, id');
        // 用户级表单字段
        $values = xovFormValue::getsBy(compact('user_id', 'form_id'));
      } else {
        $fields = [];
        $values = [];
      }

      $result = compact('fields', 'values');
    });
    return $result;
  }

  // 重审，清除报名学生资料的所有审核信息，包括：初审、复核、指标状态
  public static function retry($sch_user_id, $stud_reg_uid) {
    $result = 0;
    mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($stud_reg_uid, &$result) {
      $sch_id = $user_sch_group->sch_id;

      // 获取regstud记录
      $reg_stud = xovStudReg::checkByUid($stud_reg_uid);

      // 检测是否已录取，已录取，不能重审
        $child_id = $reg_stud->child_id;
        $stud_sch_id = $reg_stud->sch_id;
        $steps_id = $reg_stud->steps_id;

        if ($sch_id !== $stud_sch_id) throw new \Exception('不是本校学校，不能审核');

        xonStudent::existByCustom(compact('steps_id', 'child_id'), '该学生已录取，不能重置');

      // 清除指标、初审、复核
      $stud_auth = 0;
      $exam_user_id = null;
      $rexam_user_id = null;

      $result = xonStudReg::setsByUid(compact('stud_auth', 'exam_user_id', 'rexam_user_id'), $stud_reg_uid);
    });
    return $result;
  }

}
