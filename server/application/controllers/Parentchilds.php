<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Model;

class Parentchilds extends CI_Controller {
  public function index() {
    Model\xonLogin::check(function ($user) {
      $user_id = $user['unionId'];
      // 正文内容
      $result = Model\xonParentChilds::mychilds($user_id);
      // 返回信息
      $this->json(['code' => 0, 'data' => $result]);
    }, function ($error) {
      $this->json($error);
    });
  }
}
