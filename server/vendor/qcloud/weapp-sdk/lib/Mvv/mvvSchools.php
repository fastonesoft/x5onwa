<?php
namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\x5on;
use QCloud_WeApp_SDK\Model\xonSchools;
use QCloud_WeApp_SDK\Model\xonUserGroup;
use QCloud_WeApp_SDK\Model\xovSchools;
use QCloud_WeApp_SDK\Model\xovSchoolsDist;
use QCloud_WeApp_SDK\Model\xovUser;

class mvvSchools
{

  public static function dist($user_uid, $schs_uid) {
    $user = xovUser::checkByUid($user_uid);
    $user_id = $user->id;
    $schs = xovSchools::checkByUid($schs_uid);
    $schs_id = $schs->id;

    // 检测是否已分配
    xovSchoolsDist::existByIdCustom($schs_id, '集团已分配管理员，请删除再重试');
    xovSchoolsDist::existByCustom(compact('user_id'), '用户是集团管理角色，不得重复分配');
    // 分配
    xonSchools::setsById(compact('user_id'), $schs_id);
    // 分配组权限
    $group_id = x5on::GROUP_ADMIN_SCHOOLS;
    $user_group = xonUserGroup::getBy(compact('user_id', 'group_id'));
    if ($user_group === null) {
      xonUserGroup::addSchs($user_id, $group_id);
    }
    return xovSchools::getsById($schs_id);
  }

  public static function del($uid) {
    $schs = xovSchools::checkByUid($uid);
    // 二、删除地区管理组用户记录
    $user_id = $schs->user_id;
    $group_id = x5on::GROUP_ADMIN_SCHOOLS;
    xonUserGroup::delBy(compact('user_id', 'group_id'));
    // 一、删除地区用户记录
    $user_id = null;
    return xonSchools::setsByUid(compact('user_id'), $uid);
  }


}
