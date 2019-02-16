<?php
namespace QCloud_WeApp_SDK\Mvv;

class mvvUser
{

  public static function fixed ($id, $fixed) {
    $result = dbs::row('xonUser', ['*'], compact('id'));
    if ($result !== NULL) {
      dbs::update('xonUser', compact('fixed'), compact('id'));
    }
  }


}
