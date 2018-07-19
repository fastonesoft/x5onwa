<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class xonSchoolForm
{

  public static function insert () {

  }

  public static function update () {

  }

  public static function delete () {

  }

  public static function getFormNameById ($id) {
    $res = dbs::row('xonSchoolForm', ['*'], compact('id'));
    if ( $res !== null ) {
      return $res->name;
    }
    throw new Exception("没有找到编码对应的表单名称");
  }

  public static function getFormById($id) {
    $res = dbs::row('xonSchoolForm', ['*'], compact('id'));
    if ( $res !== null ) {
      return $res;
    } else {
      throw new Exception("没有找到编码对应的表单");
    }
  }

}
