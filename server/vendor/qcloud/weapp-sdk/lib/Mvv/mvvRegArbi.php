<?php
namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\x5on;
use QCloud_WeApp_SDK\Model\xonFormValue;
use QCloud_WeApp_SDK\Model\xovFormField;
use QCloud_WeApp_SDK\Model\xovFormUser;
use QCloud_WeApp_SDK\Model\xovFormValue;
use QCloud_WeApp_SDK\Model\xovSchStep;
use QCloud_WeApp_SDK\Model\xovStudReg;

class mvvRegArbi
{

  // 学校分级
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

  // 仲裁结果提交
  public static function arbiup($sch_user_id, $param) {
    $result = 0;
    mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($param, &$result) {
      $sch_id = $user_sch_group->sch_id;

      // 处理字段数据
      $uid = $param['uid'];
      unset($param['uid']);
      // 查询注册用户信息
      $reg_stud = xonStudReg::checkByUid($uid);
      $user_id = $reg_stud->user_id;

      // 获取字段->获取表单->获取所有字段
      reset($param);
      $first_field_id = key($param);
      $form_field = xonFormField::checkById($first_field_id);
      $form_id = $form_field->form_id;
      $fields = xonFormField::getsBy(compact('form_id'));

      // 获取所有字段及其值，提交修改
      foreach ($fields as $field) {
        $field_id = $field->id;
        $value = isset($param[$field_id]) ? $param[$field_id] : null;
        xonFormValue::add($user_id, $field_id, $value);
      }
    });
    return 1;
  }


}
