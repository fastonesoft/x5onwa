<?php

namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\x5on;
use QCloud_WeApp_SDK\Model\xonChild;
use QCloud_WeApp_SDK\Model\xonSchStep;
use QCloud_WeApp_SDK\Model\xonStudReg;
use QCloud_WeApp_SDK\Model\xovAreas;
use QCloud_WeApp_SDK\Model\xovChild;
use QCloud_WeApp_SDK\Model\xovSchStep;
use QCloud_WeApp_SDK\Model\xovStudent;
use QCloud_WeApp_SDK\Model\xovStudReg;
use QCloud_WeApp_SDK\Model\xovStudRegUser;
use QCloud_WeApp_SDK\Model\xovUserChilds;

class mvvRegStud
{
  public static function child_area_reged($user_id) {
    $childs = xovUserChilds::getsBy(compact('user_id'));
    // 地级市开头的形式
    $area_type = 3;
    $areas = xovAreas::getsBy(compact('area_type'));
    // 用户孩子的报名信息
    $login_user_id = $user_id;
    $studregs = xovStudRegUser::getsBy(compact('login_user_id'));
    $studregs = x5on::addsQrcode($studregs, 'uid');
    return compact('childs', 'areas', 'studregs');
  }

  public static function step($area_id) {
    $can_recruit = 1;
    return xovSchStep::getsBy(compact('area_id', 'can_recruit'));
  }

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

    return xonStudReg::add($user_id, $child_id, $sch_id, $edu_type_id, $steps_id);
  }

  public static function ref($login_user_id, $uid) {
    // uid => reg_stud_uid
    $stud_reg = xovStudRegUser::checkByCustom(compact('login_user_id', 'uid'), '没有找到对应学生的报名记录');
    return x5on::addQrcode($stud_reg, 'uid');
  }

  // 取消报名
  public static function del($login_user_id, $uid)
  {
    xovStudRegUser::checkByCustom(compact('login_user_id', 'uid'), '不是本人报名，不能删除');
    $candel = 1;
    xovStudRegUser::checkByCustom(compact('login_user_id', 'uid', 'candel'), '已经审核，不能删除');
    // 一、删除报名数据
    mvvSchValue::del($login_user_id, $uid);

    // 二、删除报名记录
    return xonStudReg::delByUid($uid);
  }

}
