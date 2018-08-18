<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class xonGradeDivision
{
  public static function getSchoolTeach ($sch_id, $user_name) {
    return dbs::select('xovSchoolTeach', ['*'], compact('sch_id', 'user_name'));
  }

}
