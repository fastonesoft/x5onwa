<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Model;

class Userchild extends CI_Controller {
  public function index() {
    Model\xonLogin::check(function ($user) {
      // 返回信息
      $this->json(['code' => 0, 'data' => $user]);
    }, function ($error) {
      $this->json($error);
    });
  }
}
