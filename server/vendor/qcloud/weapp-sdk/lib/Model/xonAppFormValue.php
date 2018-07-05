<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class xonAppFormValue
{

  public static function insert () {

  }

  public static function update () {

  }

  public static function delete () {

  }

  public static function saveKeyValue ($sch_id, $form_id, $key_id, $value) {
    // 保存结果
    $res = dbs::row('xonAppFormValue', ['*'], compact('sch_id', 'form_id', 'key_id'));
    if ( $res === null ) {
      $uid = x5on::getUid();
      dbs::insert('xonAppFormValue', compact('uid', 'sch_id', 'form_id', 'key_id', 'value'));
    } else {
      $uid = $res->uid;
      dbs::update('xonAppFormValue', compact('value'), compact('uid'));
    }
  }

}
