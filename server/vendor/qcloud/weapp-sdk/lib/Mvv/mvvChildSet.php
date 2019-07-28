<?php
namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\xonChild;

class mvvChildSet
{

  public static function child($child_name) {
    $name = $child_name;
    return xonChild::likes(compact('name'));
  }

  public static function update($uid, $idc, $name) {
    // 检测idc是否存在
    // 存在，看看是不是自己，是自己，修改；不是自己提示出错
    // 不存在，直接修改
    $child = xonChild::getBy(compact('idc'));
    if ($child !== null) {
      if ($child->uid === $uid) {
        // 是自己
        xonChild::setsByUid(compact('name'), $uid);
      } else {
        // 不是自己，说明号码已存在，提示出错
        throw new \Exception('手机号码已存在');
      }
    } else {
      xonChild::setsByUid(compact('idc', 'name'), $uid);
    }



    return xonChild::getByUid($uid);
  }

}
