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
  public static function saveSchoolFormSetAndClear ($user_id, $form_id, $app_id, $checked) {
    // 消除用户填表数据，防止冲突
    dbs::delete('xonSchoolFormSet', compact('user_id', 'app_id'));
    // 插入新的用户数据
    $uid = x5on::getUid();
    dbs::insert('xonSchoolFormSet', compact('uid', 'user_id', 'form_id', 'app_id', 'checked'));
    return $uid;
  }

  // 返回是否已设置
  public static function checkSchoolFormSet ($user_id) {
    return dbs::row('xonSchoolFormSet', ['*'], compact('user_id'));
  }

  public static function getFormId($user_id) {
    $res = dbs::row('xonSchoolFormSet', ['*'], compact('user_id'));
    return $res === null ? null : $res->form_id;
  }

  // 根据uid编号，查询用户填报表单记录
  public static function getFormSet($uid) {
    $res = dbs::row('xonSchoolFormSet', ['*'], compact('uid'));
    if ( $res !== null ) {
      return $res;
    } else {
      throw new Exception("没有找到编号对应表单");
    }
  }

  public static function cancelFormSet($uid) {
    $res = dbs::row('xonSchoolFormSet', ['*'], compact('uid'));
    if ( $res !== null ) {
      $checked = 0;
      dbs::update('xonSchoolFormSet', compact('checked'), compact('uid'));
    } else {
      throw new Exception("没有找到编号对应表单");
    }
  }
}