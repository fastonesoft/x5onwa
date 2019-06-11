<?php
namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\x5on;
use QCloud_WeApp_SDK\Model\xonForm;
use QCloud_WeApp_SDK\Model\xonFormField;
use QCloud_WeApp_SDK\Model\xonFormValue;
use QCloud_WeApp_SDK\Model\xonStudReg;
use QCloud_WeApp_SDK\Model\xovFormField;
use QCloud_WeApp_SDK\Model\xovFormUser;
use QCloud_WeApp_SDK\Model\xovFormValue;
use QCloud_WeApp_SDK\Model\xovStudReg;
use QCloud_WeApp_SDK\Model\xovStudRegUser;

class mvvSchValue
{

  public static function fields($user_id, $reg_stud_uid) {
    // 获取regstud记录
    $reg_stud = xovStudReg::getByUid($reg_stud_uid);
    $steps_id = $reg_stud->steps_id;
    $years_id = $reg_stud->years_id;
    // “报名”的分类编号
    $type_id = 1;
    $notfixed = 1;

    // 取表单数据
    $form = xonForm::checkByCustom(compact('steps_id', 'years_id', 'type_id', 'notfixed'), '没有发现要填报的表格');
    $form_id = $form->id;

    $fields = xovFormField::getsBySuff(compact('form_id'), 'order by orde');
    // 用户级表单字段
    $values = xovFormValue::getsBy(compact('user_id', 'form_id'));
    return compact('fields', 'values');
  }

  public static function add($user_id, $param) {
    $uid = $param['uid'];
    unset($param['uid']);
    // 一、添加数据
    foreach ($param as $field_id => $value) {
      xonFormValue::add($user_id, $field_id, $value);
    }
    // 二、变更状态
    $confirmed = 1;
    xonStudReg::setsByUid(compact('confirmed'), $uid);
    // 三、返回当前用户数据
    $login_user_id = $user_id;
    $studregs = xovStudRegUser::getBy(compact('login_user_id', 'uid'));
    return x5on::addQrcode($studregs, 'uid');
  }

  public static function del($user_id, $reg_stud_uid) {
    // 关于用户权限的确认，假设外面已面做了
    // 获取regstud记录
    $reg_stud = xovStudReg::getByUid($reg_stud_uid);
    $steps_id = $reg_stud->steps_id;
    $years_id = $reg_stud->years_id;
    // “报名”的分类编号
    $type_id = 1;
    $notfixed = 1;

    // 取表单数据
    $form = xonForm::checkByCustom(compact('steps_id', 'years_id', 'type_id', 'notfixed'), '没有发现要填报的表格');
    $form_id = $form->id;

    // 获取已填报的字段
    $values = xovFormValue::getsBy(compact('user_id', 'form_id'));
    foreach ($values as $value) {
      xonFormValue::delByUid($value->uid);
    }
  }

  public static function forms($user_id) {
    return xovFormUser::getsBy(compact('user_id'));
  }

  public static function values($user_id, $form_id) {
    $fields = xonFormField::getsBySuff(compact('form_id'), 'order by orde');
    // 用户级表单字段
    $values = xovFormValue::getsBy(compact('user_id', 'form_id'));
    return compact('fields', 'values');
  }

}
