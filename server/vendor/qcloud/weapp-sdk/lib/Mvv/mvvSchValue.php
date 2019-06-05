<?php
namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\xonForm;
use QCloud_WeApp_SDK\Model\xovFormValue;
use QCloud_WeApp_SDK\Model\xovStudReg;

class mvvSchValue
{

  public static function fields($user_id, $reg_stud_uid) {
    // 获取regstud记录
    $reg_stud = xovStudReg::getByUid($reg_stud_uid);
    $steps_id = $reg_stud->steps_id;
    $years_id = $reg_stud->years_id;
    // 招生编号
    $type_id = 1;
    $notfixed = 1;

    // 取表单数据
    $form = xonForm::checkBy(compact('steps_id', 'years_id', 'type_id', 'notfixed'));
    $form_id = $form->id;

    // 用户级表单字段
    return xovFormValue::getsBy(compact('user_id', 'form_id'));
  }

}
