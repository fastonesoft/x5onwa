<?php

namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\cSessionInfo;
use QCloud_WeApp_SDK\Model\x5on;
use QCloud_WeApp_SDK\Model\xonUser;

class mvvUser
{

  public static function findUserBySKey($skey)
  {
    return cSessionInfo::getBy(compact('skey'));
  }

  public static function findUserByOpenId($open_id)
  {
    return cSessionInfo::getBy(compact('open_id'));
  }

  public static function fixed($id, $fixed)
  {
    $res = xonUser::getById($id);
    if ($res !== NULL) {
      xonUser::setsById(compact('fixed'), $id);
    }
  }


}
