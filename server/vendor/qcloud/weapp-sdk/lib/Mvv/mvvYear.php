<?php
namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\xonYear;

class mvvYear
{
  public static function currentYearId () {
    $current_year = 1;
    $res = xonYear::checkBy(compact('current_year'));
    return $res->id;
  }
}
