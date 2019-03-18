<?php
namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\x5on;
use QCloud_WeApp_SDK\Model\xonArea;
use QCloud_WeApp_SDK\Model\xonUserGroup;
use QCloud_WeApp_SDK\Model\xovAreas;
use QCloud_WeApp_SDK\Model\xovAreas2Dist;
use QCloud_WeApp_SDK\Model\xovAreasDist;
use QCloud_WeApp_SDK\Model\xovUser;

class mvvArea
{

  public static function dist($user_uid, $area_uid) {
    $user = xovUser::checkByUid($user_uid);
    $user_id = $user->id;
    $area = xovAreas::checkByUid($area_uid);
    $area_id = $area->id;

    // 检测是否已分配
    xovAreasDist::existByIdCustom($area_id, '地区已分配管理，请删除再重试');
    xovAreasDist::existByCustom(compact('user_id'), '用户已分配管理地区，不得重复分配');
    // 分配
    xonArea::setsById(compact('user_id'), $area_id);
    // 分配组权限
    $group_id = x5on::GROUP_ADMIN_AREA;
    xonUserGroup::addArea($user_id, $group_id);
  }

  public static function del($uid) {
    $area = xovAreas::checkByUid($uid);
    // 二、删除地区管理组用户记录
    $user_id = $area->user_id;
    $group_id = x5on::GROUP_ADMIN_AREA;
    xonUserGroup::delBy(compact('user_id', 'group_id'));
    // 一、删除地区用户记录
    $user_id = null;
    xonArea::setsByUid(compact('user_id'), $uid);
  }

  public static function refresh($area_type) {
    $areas = xovAreas2Dist::getsBy(compact('area_type'));
    $members = xovAreasDist::getsBy(compact('area_type'));
    return compact('areas', 'members');
  }

}
