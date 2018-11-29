<?php
namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\xonChild;

class mvvChild
{
  public static function add ($idc, $name) {
    $id = $idc;
    // 检测身份证
    x5on::checkIdc($idc, 7, 18);
    $res = xonChild::getById($id);
    if ( $res === null ) {
      // 添加孩子
      $uid = x5on::getUid();
      xonChild::insert(compact('id', 'uid', 'idc', 'name'));
    }
  }
}
