<?php
namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\xonRole;

class mvvRoleset
{
  public static function update($rolesets) {
    $count = 0;
    foreach ($rolesets as $uid => $value) {
      // 权限列表，设置是否显示
      $can_show = $value === 'true' ? 1 : 0;

      // 检测编号是否存在
      xonRole::checkByUid($uid);

      // 是否需要设置
      $role = xonRole::getBy(compact('uid', 'can_show'));
      if ($role === null) {
        xonRole::setsByUid(compact('can_show'), $uid);
        $count++;
      }
    }
    return $count;
  }
}
