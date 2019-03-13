<?php
namespace QCloud_WeApp_SDK\Mvv;

class mvvSchools
{

  public static function dist($user_uid, $area_uid) {
    $user = xovUser::checkByUid($user_uid);
    $user_id = $user->id;
    $area = xovAreas::checkByUid($area_uid);
    $area_id = $area->id;

    // 检测是否已分配
    xovAreasDisted::existByIdCustom($area_id, '地区已分配管理，请删除再重试');
    xovAreasDisted::existByCustom(compact('user_id'), '用户已分配管理地区，不得重复分配');
    // 分配
    xonArea::setsById(compact('user_id'), $area_id);
    // 分配组权限
    $group_id = x5on::GROUP_ADMIN_AREA;
    $user_group = xonUserGroup::getBy(compact('user_id', 'group_id'));
    if ($user_group === null) {
      xonUserGroup::addArea($user_id, $group_id);
    }
    return xovAreas::getsById($area_id);
  }

  public static function del($uid) {
    $area = xovAreas::checkByUid($uid);
    // 二、删除地区管理组用户记录
    $user_id = $area->user_id;
    $group_id = x5on::GROUP_ADMIN_AREA;
    xonUserGroup::delBy(compact('user_id', 'group_id'));
    // 一、删除地区用户记录
    $user_id = null;
    return xonArea::setsByUid(compact('user_id'), $uid);
  }


}
