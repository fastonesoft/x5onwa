<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class xonSchoolFormSet
{

  public static function insert () {

  }

  public static function update () {

  }

  public static function delete () {

  }

  // 暂时只做 用户 检测，
  // 以后再做详细设置
  public static function saveSchoolFormSet ($user_id, $form_id, $checked) {
    // 消除用户填表数据，防止冲突
    dbs::delete('xonSchoolFormSet', compact('user_id'));
    // 插入新的用户数据
    $uid = x5on::getUid();
    dbs::insert('xonSchoolFormSet', compact('uid', 'user_id', 'form_id', 'checked'));
  }

  // 返回是否已设置
  public static function checkSchoolFormSet ($user_id) {
    return dbs::row('xonSchoolFormSet', ['*'], compact('user_id'));
  }

  public static function getFormId($user_id) {
    $res = dbs::row('xonSchoolFormSet', ['*'], compact('user_id'));
    return $res === null ? null : $res->form_id;
  }
}
