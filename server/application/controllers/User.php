<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Model;

class User extends CI_Controller {
  public function index() {
    Model\Login::check(function ($user) {
      // 返回信息
      $this->json(['code' => 0, 'data' => $user]);
    }, function ($error) {
      $this->json($error);
    });
  }
}
