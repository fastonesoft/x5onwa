<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class xonClass
{

  public static function update ($param) {
    $result = 0;
    foreach ($param as $uid => $num) {
      $res = dbs::row('xonClass', ['*'], compact('uid'));
      if ( $res !== null ) {
        $result++;
        dbs::update('xonClass', compact('num'), compact('uid'));
      }
    }
    return $result;
  }

}
