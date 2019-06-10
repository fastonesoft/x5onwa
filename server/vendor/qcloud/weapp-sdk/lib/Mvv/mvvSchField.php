<?php
namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\xonFormField;
use QCloud_WeApp_SDK\Model\xonMode;
use QCloud_WeApp_SDK\Model\xovForm;
use QCloud_WeApp_SDK\Model\xovFormField;
use QCloud_WeApp_SDK\Model\xovSchStep;

class mvvSchField
{

  public static function steps($sch_admin_user_id) {
    $result = [];
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use (&$result) {
      $sch_id = $user_sch_group->sch_id;

      $graduated = 0;
      $result = xovSchStep::getsBy(compact('sch_id', 'graduated'));
    });
    return $result;
  }

  public static function forms($sch_admin_user_id, $steps_id) {
    $result = [];
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($steps_id, &$result) {
      $sch_id = $user_sch_group->sch_id;

      $result = xovForm::getsBy(compact('steps_id'));
    });
    return $result;
  }

  public static function fields($sch_admin_user_id, $form_id) {
    $result = [];
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($form_id, &$result) {
      $sch_id = $user_sch_group->sch_id;

      $result = xovFormField::getsBy(compact('form_id'));
    });
    return $result;
  }

  public static function modes($sch_admin_user_id) {
    $result = [];
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use (&$result) {
      $sch_id = $user_sch_group->sch_id;

      $result = xonMode::gets();
    });
    return $result;
  }

  public static function add($sch_admin_user_id, $form_id, $mode, $label, $orde) {
    $result = [];
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($form_id, $mode, $label, $orde, &$result) {
      $sch_id = $user_sch_group->sch_id;

      $result = xonFormField::add($form_id, $mode, $label, $orde);
    });
    return $result;
  }

  public static function del($sch_admin_user_id, $uid) {
    $result = [];
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($uid, &$result) {
      $sch_id = $user_sch_group->sch_id;

      xonFormField::checkByUid($uid);
      $result = xonFormField::delByUidCustom($uid);
    });
    return $result;
  }

  public static function edit($sch_admin_user_id, $uid, $label, $orde) {
    $result = [];
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($uid, $label, $orde, &$result) {
      $sch_id = $user_sch_group->sch_id;

      xonFormField::checkByUid($uid);
      xonFormField::setsByUid(compact('label', 'orde'), $uid);
      $result = xovFormField::getByUid($uid);
    });
    return $result;
  }
}
