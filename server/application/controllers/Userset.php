<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Model;

class Userset extends CI_Controller {
  /**
   * 获取UserKey列表
   */
  const role_name = 'userset';
  public function index() {
    Model\xonLogin::check(self::role_name, function ($user) {
      // 查询用户列表
      $user_id = $user['unionId'];
      $data = Model\xonUserkey::getUserKeys($user_id, 0);

      // 查询提交状态
      $userset_name = Model\x5on::USER_SET_MYSELF;
      $checked = Model\xonUsersetdata::getCheckedById($user_id, $userset_name);
      $result = compact('data', 'checked');
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
    Model\xonLogin::check(self::role_name, function ($user) {
      // 获取参数
      $param = $_POST;
      $user_id = $user['unionId'];

      foreach ($param as $name => $value) {
        // 检测输入数据是否有误
        $res = Model\x5on::checkUser($name, $value, $user_id);
        if ($res !== NULL) {
          $this->json(['code' => -1, 'data' => $res['message']]);
          return;
        }

        // 根据名称获取userkey记录
        $userkey = Model\xonUserkey::getRowByName($name);
        if ($userkey !== NULL) {
          // 获取编号
          $key_id = $userkey->id;
          $check_unique = $userkey->check_unique;
          // 插入数据，并进行唯一检测
          $res = Model\xonUserkeyvalue::insert($user_id, $key_id, $value, $check_unique);
          if ( $res !== NULL ) {
            $this->json(['code' => -1, 'data' => $res['message']]);
            return;
          }
        }
      }
      // 添加：用户设置记录
      $checked = 1;
      $user_name = Model\x5on::USER_SET_MYSELF;
      $userset_id = Model\xonUserset::getIdByUserSetName($user_name);
      $result = Model\xonUsersetdata::insert($user_id, $userset_id, $checked);
      // 返回信息
      $this->json(['code' => 0, 'data' => $result]);
    }, function ($error) {
      $this->json($error);
    });
  }
}