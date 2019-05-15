<?php
namespace QCloud_WeApp_SDK\Mvv;

use function PHPSTORM_META\type;
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

  public static function add($sch_admin_user_id, $title, $type_id, $steps_id, $years_id) {
    $result = [];
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($title, $type_id, $steps_id, $years_id, &$result) {
      $sch_id = $user_sch_group->sch_id;

      $result = xonForm::add($title, $type_id, $steps_id, $years_id));
    });
    return $result;
  }


}
