<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Model;

class Data extends CI_Controller {
  const role_name = 'test';
  public function index() {
    Model\xonLogin::check(self::role_name, function ($user) {
      // 正文内容
      // 返回信息
      $this->json(['code' => 0, 'data' => $user]);
    }, function ($error) {
      $this->json($error);
    });
  }
}
