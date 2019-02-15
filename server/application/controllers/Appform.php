<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mvv;
use QCloud_WeApp_SDK\Model;

class Appform extends CI_Controller {
  const role_name = 'schcode';
  public function index() {
    Mvv\mvvLogin::check(self::role_name, function ($user) {
      $app_id = Model\xonApp::getIdByName('schcode');
      $result = Model\xonAppForm::getFormsById($app_id);
      // 正文内容
      $this->json(['code' => 0, 'data' => $result]);
    }, function ($error) {
      $this->json($error);
    });
  }
}
