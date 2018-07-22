<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Model;

class Parentchilds extends CI_Controller
{
  const role_name = 'userchilds';
  public function index() {
    Model\xonLogin::check(self::role_name, function ($user) {
      // 查询用户列表
      $user_id = $user['unionId'];
      $result = Model\xonParentChilds::mychilds($user_id);
      // 返回信息
      $this->json(['code' => 0, 'data' => $result]);
    }, function ($error) {
      $this->json($error);
    });
  }
}