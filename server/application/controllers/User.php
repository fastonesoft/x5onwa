<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Model;

class User extends CI_Controller {
  const role_name = 'userset';
  public function index() {
    Model\xonLogin::check(self::role_name, function ($user) {
      // 正文内容
      $this->json(['code' => 0, 'data' => $user]);
    }, function ($error) {
      $this->json($error);
    });
  }
}
