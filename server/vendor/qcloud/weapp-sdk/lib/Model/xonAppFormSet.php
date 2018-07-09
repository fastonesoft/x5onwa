<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class xonAppFormSet
{

  public static function insert () {

  }

  public static function update () {

  }

  public static function delete () {

  }

  public static function saveSchoolSet ($sch_id, $form_id, $set_name, $checked) {
    $res = dbs::row('xonAppFormSet', ['*'], compact('sch_id', 'set_name'));
    if ( $res === null ) {
      $uid = x5on::getUid();
      dbs::insert('xonAppFormSet', compact('uid', 'sch_id', 'form_id', 'set_name', 'checked'));
    } else {
      $uid = $res->uid;
      dbs::update('xonAppFormSet', compact('form_id', 'checked'), compact('uid'));
    }
  }

  // 返回是否已设置
  public static function checkSchoolSet ($sch_id, $set_name) {
    $res = dbs::row('xonAppFormSet', ['*'], compact('sch_id', 'set_name'));
    return $res === null ? false : $res->checked;
  }
}
