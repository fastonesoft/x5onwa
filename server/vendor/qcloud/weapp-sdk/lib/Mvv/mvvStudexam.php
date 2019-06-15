<?php
namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\x5on;
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


  public static function fields($sch_user_id, $reg_stud_uid, $reg_steps_id) {
    $result = [];
    mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($reg_stud_uid, $reg_steps_id, &$result) {
      $sch_id = $user_sch_group->sch_id;

      // 获取regstud记录
      $reg_stud = xovStudReg::getByUid($reg_stud_uid);
      // 获取其它辅助信息
      $steps_id = $reg_stud->steps_id;
      $years_id = $reg_stud->years_id;
      $user_id = $reg_stud->user_id;
      // “报名”的分类编号
      $type_id = 1;
      // 没有取消的表格
      $notfixed = 1;

      // 检测报名年级是不是当前审核的年级
      if ($steps_id !== $reg_steps_id) throw new \Exception('非当前年级对应的二维码信息，无法审核！');

      // 取表单数据
      $form = xonForm::checkByCustom(compact('steps_id', 'years_id', 'type_id', 'notfixed'), '没有发现要填报的表格');
      $form_id = $form->id;

      $fields = xovFormField::getsBySuff(compact('form_id'), 'order by orde');
      // 用户级表单字段
      $values = xovFormValue::getsBy(compact('user_id', 'form_id'));

      // 查询uid编号对应学生，数组形式返回
      $regstuds = xovStudReg::getsByUid($reg_stud_uid);
      // 添加二维码信息
      $regstuds = x5on::addsQrcode($regstuds, 'uid');

      $result = compact('regstuds', 'fields', 'values');
    });
    return $result;
  }


}
