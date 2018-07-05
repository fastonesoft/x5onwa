<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Model;

class Appformkey extends CI_Controller {
  const role_name = 'schcode';
  public function index() {
    Model\xonLogin::check(self::role_name, function ($user) {
      $param = $_POST;
      $form_id = $param['form_id'];
      $result = Model\xonAppFormKey::getDefaultKeysByFormId($form_id);
      // 正文内容
      $this->json(['code' => 0, 'data' => $result]);
    }, function ($error) {
      $this->json($error);
    });
  }

  public function update() {
    Model\xonLogin::check(self::role_name, function ($user) {
      $param = $_POST;
      $sch_id = $param['sch_id'];
      $form_id = $param['form_id'];
      $result = Model\xonAppFormKey::getKeysByFormId($sch_id, $form_id);
      // 正文内容
      $this->json(['code' => 0, 'data' => $result]);
    }, function ($error) {
      $this->json($error);
    });
  }
}
