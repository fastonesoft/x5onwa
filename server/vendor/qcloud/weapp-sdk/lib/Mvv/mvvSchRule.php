<?php
namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\xonFormField;
use QCloud_WeApp_SDK\Model\xovFormField;

class mvvSchRule
{
  public static function add($sch_admin_user_id, $uid, $update, $value) {
    $result = [];
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($uid, $update, $value, &$result) {
      $sch_id = $user_sch_group->sch_id;

      if ($update === 'field') {
        $field = $value;
        xonFormField::setsByUid(compact('field'), $uid);
        $result = xovFormField::getByUid($uid);
      }
      if ($update === 'rule') {
        $rule = $value;
        xonFormField::setsByUid(compact('rule'), $uid);
        $result = xovFormField::getByUid($uid);
      }
    });
    return $result;
  }

}
