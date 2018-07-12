<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Model;

class Regexam extends CI_Controller {
  const role_name = 'regexam';
  public function index() {
    Model\xonLogin::check(self::role_name, function ($user) {
      $param = $_POST;
      $uid = $param['uid'];
      $user_id = Model\xonUser::getIdByUid($uid);
      $form_id = Model\xonSchoolFormSet::getFormId($user_id);
      $result = Model\xonSchoolFormKey::listKeysByFormId($user_id, $form_id);
      // 正文内容
      $this->json(['code' => 0, 'data' => $result]);
    }, function ($error) {
      $this->json($error);
    });
  }

  public function exam() {
    Model\xonLogin::check(self::role_name, function ($user) {
      $param = $_POST;
      $uid = $param['uid'];
      $who_exam = $user['unionId'];


      // 正文内容
      $this->json(['code' => 0, 'data' => $result]);
    }, function ($error) {
      $this->json($error);
    });
  }
}
