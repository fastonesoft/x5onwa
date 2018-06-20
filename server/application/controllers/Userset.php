<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use QCloud_WeApp_SDK\Model;

class Userset extends CI_Controller {

  /**
   * 获取UserKey列表
   */
  public function index() {
    Model\xonLogin::check(function ($user) {
      // 查询没有禁止的
      $fixed = 0;
      $keys = dbs::select('xonUserKey', ['*', 'required as error'], compact('fixed'));
      $user_id = $user['unionId'];
      $values = dbs::select('xonUserKeyValue', ['*'], compact('user_id'));

      $result = Model\xonUserset::merge($keys, $values);
      // 返回信息
      $this->json(['code' => 0, 'data' => $result]);
    }, function ($error) {
      $this->json($error);
    });
  }

  /**
   * 提交修改UserKey
   */
  public function update() {
    Model\xonLogin::check(function ($user) {
      // 获取参数
      $param = $_POST;
      $user_id = $user['unionId'];

      // 遍历数据
      foreach ($param as $name => $value) {
        // 查询名称
        $userkey = dbs::row('xonUserKey', ['*'], compact('name'));
        if ($userkey !== NULL) {
          // 获取编号
          $key_id = $userkey->id;
          Model\xonUserkeyvalue::insert($user_id, $key_id, $value);
        }
      }
      // 添加：用户设置记录
      $checked = 1;
      $user_name = Model\x5on::USER_SET_MYSELF;

      $userset_id = Model\xonUserset::getIdByName($user_name);
      Model\xonUsersetdata::insert($user_id, $userset_id, $checked);
      // 返回信息
      $this->json(['code' => 0, 'data' => []]);
    }, function ($error) {
      $this->json($error);
    });
  }
}