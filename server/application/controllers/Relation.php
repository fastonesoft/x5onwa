<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mvv;
use QCloud_WeApp_SDK\Model;

class Relation extends CI_Controller {
  const role_name = 'userchilds';
  public function index() {
    Mvv\mvvLogin::check(self::role_name, function ($user) {
      // 正文内容
      $result = Model\xonRelation::selects();
      // 返回信息
      $this->json(['code' => 0, 'data' => $result]);
    }, function ($error) {
      $this->json($error);
    });
  }
}
