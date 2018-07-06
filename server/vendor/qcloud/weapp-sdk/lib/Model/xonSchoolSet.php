<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class xonSchoolSet
{

  public static function insert () {

  }

  public static function update () {

  }

  public static function delete () {

  }

  public static function saveSchoolSet ($sch_id, $form_id, $set_name, $checked) {
    $res = dbs::row('xonSchoolSet', ['*'], compact('sch_id', 'set_name'));
    if ( $res === null ) {
      $uid = x5on::getUid();
      dbs::insert('xonSchoolSet', compact('uid', 'sch_id', 'form_id', 'set_name', 'checked'));
    } else {
      $uid = $res->uid;
      dbs::update('xonSchoolSet', compact('form_id', 'checked'), compact('uid'));
    }
  }

  // 要能返回，设置了些什么
  public static function checkSchoolSet ($sch_id, $set_name) {
    $res = dbs::row('xonSchoolSet', ['*'], compact('sch_id', 'set_name'));
    if ( $res === null ) {
      $checked = false;
      $formvalues = [];
      return compact('checked', 'formvalues');
    } else {
      $checked = $res->checked;
    }

  }
}
