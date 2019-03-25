<?php

namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\x5on;
use QCloud_WeApp_SDK\Model\xonUser;
use QCloud_WeApp_SDK\Model\xovUserOnly;

class mvvUser
{

  public static function update($user_id, $name, $mobil)
  {
    // 检测手机号，是否存在；存在：看看用户名是不是自已，不是自己提示出错
    $user = xonUser::getBy(compact('mobil'));
    if ($user !== null) {
      if ($user->id !== $user_id) {
        throw new \Exception('手机号码已存在');
      }
    }
    // 手机号码不存在，但是自己登记的，可以更新用户记录
    $confirmed = 1;
    xonUser::setsById(compact('name', 'mobil', 'confirmed'), $user_id);
  }

  // 冻结用户帐号
  public static function fixed($user_id, $fixed)
  {
    xonUser::checkById($user_id);
    xonUser::setsById(compact('fixed'), $user_id);
  }

  // 普通用户查询
  public static function userOnly($like_name) {
    $user_name = x5on::getLike($like_name);
    return xovUserOnly::likes(compact('user_name'));
  }


}
