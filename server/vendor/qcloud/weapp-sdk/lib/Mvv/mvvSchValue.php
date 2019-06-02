<?php
namespace QCloud_WeApp_SDK\Mvv;

class mvvSchValue
{

  public static function fields($user_id, $form_id) {
    // 用户级表单字段
    return xovFormValue::getsBy(compact('user_id', 'form_id'));
  }

}
