<?php
namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\xonForm;
use QCloud_WeApp_SDK\Model\xonStudAuth;
use QCloud_WeApp_SDK\Model\xovAreas;
use QCloud_WeApp_SDK\Model\xovFormField;
use QCloud_WeApp_SDK\Model\xovFormValue;
use QCloud_WeApp_SDK\Model\xovSchStep;
use QCloud_WeApp_SDK\Model\xovStudReg;

class mvvStudexam
{

  // 学校分级、学生类别
  public static function step_auth($sch_user_id) {
    $result = [];
    mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use (&$result) {
      $sch_id = $user_sch_group->sch_id;

      // 可以招生的学校分级
      $can_recruit = 1;
      $steps = xovSchStep::getsBy(compact('sch_id', 'can_recruit'));

      // 学生类别
      $auths = xonStudAuth::gets();
      $result = compact('steps', 'auths');
    });
    return $result;
  }


  public static function fields($sch_user_id, $reg_stud_uid) {
    $result = [];
    mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($reg_stud_uid, &$result) {
      $sch_id = $user_sch_group->sch_id;

      // 获取regstud记录
      $reg_stud = xovStudReg::getByUid($reg_stud_uid);
      $steps_id = $reg_stud->steps_id;
      $years_id = $reg_stud->years_id;
      $user_id = $reg_stud->user_id;
      // “报名”的分类编号
      $type_id = 1;
      // 没有取消的表格
      $notfixed = 1;

      // 取表单数据
      $form = xonForm::checkByCustom(compact('steps_id', 'years_id', 'type_id', 'notfixed'), '没有发现要填报的表格');
      $form_id = $form->id;

      $fields = xovFormField::getsBySuff(compact('form_id'), 'order by orde');
      // 用户级表单字段
      $values = xovFormValue::getsBy(compact('user_id', 'form_id'));
      $result = compact('fields', 'values');
    });
    return $result;
  }


}
