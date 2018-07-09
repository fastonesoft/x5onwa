<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Model;

class Schoolformkey extends CI_Controller {
  const role_name = 'regstud';
  public function index() {
    Model\xonLogin::check(self::role_name, function ($user) {
      try {
        $param = $_POST;
        $form_id = $param['form_id'];
        $user_id = $user['unionId'];
        $result = Model\xonSchoolFormKey::getKeysByFormId($user_id, $form_id);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

}
