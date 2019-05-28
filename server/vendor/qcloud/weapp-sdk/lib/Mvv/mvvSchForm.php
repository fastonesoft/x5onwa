<?php
namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\x5on;
use QCloud_WeApp_SDK\Model\xonForm;
use QCloud_WeApp_SDK\Model\xonType;
use QCloud_WeApp_SDK\Model\xonSchYear;
use QCloud_WeApp_SDK\Model\xovSchStep;

class mvvSchForm
{

  public static function types($sch_admin_user_id) {
    $result = null;
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use (&$result) {
      $sch_id = $user_sch_group->sch_id;

      $types = xonType::gets();
      $years = xonSchYear::getsBy(compact('sch_id'));
      $graduated = 0;
      $steps = xovSchStep::getsBy(compact('sch_id', 'graduated'));

      $result = compact('types', 'years', 'steps');
    });
    return $result;
  }

  public static function forms($sch_admin_user_id, $type_id, $steps_id, $years_id) {
    $result = [];
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($type_id, $steps_id, $years_id, &$result) {
      $sch_id = $user_sch_group->sch_id;

      $result = xonForm::getsBy(compact('type_id', 'steps_id', 'years_id'));
    });
    return $result;
  }

  public static function add($sch_admin_user_id, $title, $notfixed_string, $type_id, $steps_id, $years_id) {
    $result = [];
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($title, $notfixed_string, $type_id, $steps_id, $years_id, &$result) {
      $sch_id = $user_sch_group->sch_id;

      $notfixed = x5on::getBool($notfixed_string);
      $result = xonForm::add($title, $notfixed, $type_id, $steps_id, $years_id);
    });
    return $result;
  }

  public static function del($sch_admin_user_id, $uid) {
    $result = 0;
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($uid, &$result) {
      $sch_id = $user_sch_group->sch_id;

      xonForm::checkByUid($uid);
      $result = xonForm::delByUidCustom($uid);
    });
    return $result;
  }

  public static function edit($sch_admin_user_id, $uid, $title, $notfixed_string) {
    $result = 0;
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($uid, $title, $notfixed_string, &$result) {
      $sch_id = $user_sch_group->sch_id;

      xonForm::checkByUid($uid);
      $notfixed = x5on::getBool($notfixed_string);
      xonForm::setsByUid(compact('title', 'notfixed'), $uid);
      $result = xonForm::getByUid($uid);
    });
    return $result;
  }

  public static function fields($sch_admin_user_id, $uid) {
    $result = 0;
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($uid, $title, $notfixed_string, &$result) {
      $sch_id = $user_sch_group->sch_id;

      xonForm::checkByUid($uid);
      $notfixed = x5on::getBool($notfixed_string);
      xonForm::setsByUid(compact('title', 'notfixed'), $uid);
      $result = xonForm::getByUid($uid);
    });
    return $result;
  }

}
