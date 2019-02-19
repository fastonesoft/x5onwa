<?php

namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\x5on;
use QCloud_WeApp_SDK\Model\xonSchool;
use QCloud_WeApp_SDK\Model\xonStudReg;

class mvvStudreg
{

  // 报名注册
  public static function reg($user_id, $child_id, $sch_id, $edu_type_id)
  {
    xonStudReg::existByCustom(compact('child_id', 'edu_type_id'), '同类学校只能报一个');
    // 保存
    $uid = x5on::getUid();
    xonStudReg::insert(compact('uid', 'child_id', 'sch_id', 'user_id', 'edu_type_id'));
  }

  // 确认报名
  public static function checked($user_id, $uid)
  {
    $checked = 1;
    xonStudReg::checkBy(compact('user_id', 'uid'));
    xonStudReg::setsBy(compact('checked'), compact('user_id', 'uid'));
  }

  // 取消报名
  public static function cancel($user_id, $uid)
  {
    $checked = 1;
    xonStudReg::existByCustom(compact('user_id', 'uid', 'checked'), '已经确认，不能取消');
    xonStudReg::delete(compact('user_id', 'uid'));
  }

  // 确认重置
  public static function recheck($uid)
  {
    $checked = 0;
    xonStudReg::setsByUid(compact('checked'), $uid);
  }









  // 临时只能报一个
  public static function regCheck($user_id)
  {
    $data = dbs::row('xovStudReg', ['uid', 'sch_id', 'sch_name', 'child_id', 'child_name'], compact('user_id'));
    if ($data !== null) {
      $sch_reged = true;
      // 读取学校报名表格
      $sch_id = $data->sch_id;
      $sch_name = $data->sch_name;
      $child_id = $data->child_id;
      $child_name = $data->child_name;
      // 检测是否已经录取
      $enter = xonStudent::checkStudentEnter($child_id, $sch_id);
      if ($enter !== false) {
        return $enter;
      }

      $current_year = 1;
      $app_name = 'regstud';
      $forms = dbs::select('xovSchoolForm', ['id', 'name'], compact('sch_id', 'app_name', 'current_year'));

      $form_setted = xonSchoolFormSet::checkSchoolFormSet($user_id);
      if ($form_setted === null || $form_setted !== null && !$form_setted->checked) {
        $not_reg = false;
        $not_added = true;
        $infor_added = false;
        return compact('not_reg', 'sch_reged', 'not_added', 'infor_added', 'sch_id', 'sch_name', 'child_id', 'child_name', 'forms');
      }
      // 用户报名二维码
      $form_setted_uid = $form_setted->uid;
      $qrcode_data = x5on::getQrcodeBase64($form_setted_uid);
      //
      $form_id = $form_setted->form_id;
      $infor_added = $form_setted->checked;
      // 取得form_name
      $form_name = xonSchoolForm::getFormNameById($form_id);
      // 查询用户已提交的表格数据
      $user_forms = xonSchoolFormKey::listKeysByFormId($user_id, $form_id);
      $not_reg = false;
      $not_added = !$infor_added;
      return compact('not_reg', 'sch_reged', 'not_added', 'infor_added', 'sch_id', 'sch_name', 'child_id', 'child_name', 'forms', 'form_name', 'user_forms', 'qrcode_data');
    } else {
      $not_reg = true;
      $sch_reged = false;
      $not_added = true;
      $infor_added = false;
      $schools = xonStudReg::schools();
      $childs = xonParentChilds::mychilds($user_id);
      return compact('not_reg', 'sch_reged', 'not_added', 'infor_added', 'schools', 'childs');
    }
  }



  public static function regCancelData($user_id)
  {
    $not_reg = true;
    $sch_reged = false;
    $not_added = true;
    $infor_added = false;
    $schools = xonStudReg::schools();
    $childs = xonParentChilds::mychilds($user_id);
    return compact('not_reg', 'sch_reged', 'not_added', 'infor_added', 'schools', 'childs');
  }

  // 获取用户报名记录编号
  public static function getRegRowByUserId($user_id)
  {
    $res = dbs::row('xovStudReg', ['uid', 'sch_id', 'sch_name', 'child_id', 'child_name'], compact('user_id'));
    if ($res !== null) {
      return $res;
    } else {
      throw new Exception("未找到用户报名记录");
    }
  }

  public static function getRegRowByUid($uid)
  {
    $res = dbs::row('xovStudReg', ['uid', 'sch_id', 'sch_name', 'child_id', 'child_name'], compact('uid'));
    if ($res !== null) {
      return $res;
    } else {
      throw new Exception("未找到编号对应报名记录");
    }
  }

  public static function setStudExamUser($uid, $exam_user_id)
  {
    $res = dbs::row('xonStudReg', ['*'], compact('uid'));
    if ($res !== null) {
      if ($res->exam_user_id !== null) throw new Exception("已经通过审核，无须再审");
      // 未审核，标识一下
      dbs::update('xonStudReg', compact('exam_user_id'), compact('uid'));
    } else {
      throw new Exception("未找到编号对应报名记录");
    }
  }

  public static function checkStudExamCancel($uid)
  {
    $res = dbs::row('xonStudReg', ['*'], compact('uid'));
    if ($res !== null) {
      if ($res->exam_user_id !== null) throw new Exception("已经通过审核，无法撤消");
    } else {
      throw new Exception("未找到编号对应报名记录");
    }
  }

  public static function delStudExamUser($uid)
  {
    $res = dbs::row('xonStudReg', ['*'], compact('uid'));
    if ($res !== null) {
      if ($res->confirm_user_id !== null) throw new Exception("已经确认，不能撤消");
      $exam_user_id = null;
      dbs::update('xonStudReg', compact('exam_user_id'), compact('uid'));
    } else {
      throw new Exception("未找到编号对应报名记录");
    }
  }

  public static function setStudConfirmUser($uid, $confirm_user_id)
  {
    $res = dbs::row('xonStudReg', ['*'], compact('uid'));
    if ($res !== null) {
      if ($res->exam_user_id === null) throw new Exception("未通过审核，无法确认");
      if ($res->confirm_user_id !== null) throw new Exception("已经确认，不必重复操作");
      dbs::update('xonStudReg', compact('confirm_user_id'), compact('uid'));
    } else {
      throw new Exception("未找到编号对应报名记录");
    }
  }

  public static function checkStudConfirmCancel($uid)
  {
    $res = dbs::row('xonStudReg', ['*'], compact('uid'));
    if ($res !== null) {
      if ($res->confirm_user_id !== null) throw new Exception("已经通过审核，无法撤消");
    } else {
      throw new Exception("未找到编号对应报名记录");
    }
  }

}
