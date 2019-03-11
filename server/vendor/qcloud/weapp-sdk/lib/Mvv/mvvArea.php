<?php
namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\xonArea;
use QCloud_WeApp_SDK\Model\xovAreas;
use QCloud_WeApp_SDK\Model\xovUser;

class mvvArea
{

  public static function dist($user_uid, $area_uid) {
    $user = xovUser::checkByUid($user_uid);
    $area = xovAreas::checkByUid($area_uid);
    $area_id = $area->id;

    // 检测是否已分配
    $id = $area_id;
    $user_id = null;
    xovAreas::checkByCustom(compact('id', 'user_id'), '地区已分配管理，请删除再重试');
    // 分配
    $user_id = $user->id;
    xonArea::setsById(compact('user_id'), $area_id);

    return xovAreas::getById($area_id);
  }


}
