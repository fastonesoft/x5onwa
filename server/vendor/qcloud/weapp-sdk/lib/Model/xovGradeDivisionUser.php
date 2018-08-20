<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class xovGradeDivisionUser
{

  public static function getRowsByUserId ($user_id, $grade_id) {
    return dbs::select('xovGradeDivisionUser', ['uid', 'grade_id', 'cls_id', 'cls_name'], compact('user_id', 'grade_id'));
  }

}
