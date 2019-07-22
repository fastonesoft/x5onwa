<?php
namespace QCloud_WeApp_SDK\Mvv;

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
      $result = xovStudReg::likesBy(compact('steps_id'), compact('child_name'));
    });
    return $result;
  }

  // 报名学生父母信息查询
  public static function parent($sch_user_id, $child_uid) {
    $result = [];
    mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($child_uid, &$result) {
      $sch_id = $user_sch_group->sch_id;

      // 获取regstud记录
      $reg_stud = xovStudReg::getBy(compact('child_uid'));
      if ($reg_stud !== null) {
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
      } else {
        $fields = [];
        $values = [];
      }
      // 根据学生编号查询出父母的相关注册信息
      $userchilds = xovUserChilds::getsBy(compact('child_uid'));
      $result = compact('userchilds', 'fields', 'values');
    });
    return $result;
  }

  // 仲裁报名学生数据，后期审核专用
  public static function fields($sch_user_id, $child_uid) {
    $result = [];
    mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($child_uid, &$result) {
      $sch_id = $user_sch_group->sch_id;

      // 获取regstud记录
      $reg_stud = xovStudReg::getBy(compact('child_uid'));
      if ($reg_stud !== null) {
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
      } else {
        $fields = [];
        $values = [];
      }
      $result = compact('fields', 'values');
    });
    return $result;
  }

  // 重审，清除报名学生资料的所有审核信息，包括：初审、复核、指标状态
  public static function retrial($sch_user_id, $child_uid) {
    $result = 0;
    mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($child_uid, &$result) {
      $sch_id = $user_sch_group->sch_id;

      // 获取regstud记录
      $reg_stud = xovStudReg::checkBy(compact('child_uid'));

      // 清除指标、初审、复核
      $stud_auth = 0;
      $exam_user_id = null;
      $rexam_user_id = null;

      $result = xonStudReg::setsByUid();
    });
    return $result;
  }

}
