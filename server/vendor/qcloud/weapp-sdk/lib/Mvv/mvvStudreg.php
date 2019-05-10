<?php

namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\x5on;
use QCloud_WeApp_SDK\Model\xonChild;
use QCloud_WeApp_SDK\Model\xonSchStep;
use QCloud_WeApp_SDK\Model\xonStudReg;
use QCloud_WeApp_SDK\Model\xovChild;
use QCloud_WeApp_SDK\Model\xovSchStep;
use QCloud_WeApp_SDK\Model\xovStudent;
use QCloud_WeApp_SDK\Model\xovStudRegUser;
use QCloud_WeApp_SDK\Model\xovUserChilds;

class mvvStudreg
{
  // 报名注册
  public static function reg($user_id, $child_uid, $steps_uid)
  {
    // 注册学校相关信息
    $steps = xovSchStep::checkByUidCustom($steps_uid, '没有找到编号对应学校年级');
    $sch_id = $steps->sch_id;
    $steps_id = $steps->id;
    $edu_type_id = $steps->edu_type_id;

    $user_child = xovUserChilds::checkByUidCustom($child_uid, '没有找到编号对应孩子信息');
    $child_id = $user_child->child_id;

    $stud_reg = xonStudReg::add($user_id, $child_id, $sch_id, $edu_type_id, $steps_id);
    return x5on::addQrcode($stud_reg, 'uid');
  }

  public static function enroll($my_user_id, $uid) {
    // 根据孩子编号，检测是否是我的孩子
    $stud_reg = xovStudRegUser::checkBy(compact('my_user_id', 'uid'));
    $child_id = $stud_reg->child_id;

    // 根据孩子编号，获取学生相关信息，包括二维码
    $qrcode_data = x5on::getQrcodeBase64($uid);

    // 录取信息
    $students = xovStudent::getsBy(compact('child_id'));
  }

  // 取消报名
  public static function cancel($user_id, $uid)
  {
    $confirmed = 1;
    xonStudReg::checkByCustom(compact('user_id', 'uid'), '不是本人报名，不能取消');
    xonStudReg::existByCustom(compact('user_id', 'uid', 'confirmed'), '已经确认，不能取消');
    xonStudReg::delBy(compact('user_id', 'uid'));
  }

  // 确认重置
  public static function recheck($uid)
  {
    $confirmed = 0;
    xonStudReg::setsByUid(compact('confirmed'), $uid);
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
