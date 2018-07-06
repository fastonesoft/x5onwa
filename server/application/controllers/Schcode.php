<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Auth\LoginService as LoginService;
use QCloud_WeApp_SDK\Constants as Constants;
use QCloud_WeApp_SDK\Mysql\Mysql as DB;
use QCloud_WeApp_SDK\Model;

class Schcode extends CI_Controller {
  const role_name = 'schcode';
  public function index() {
    Model\xonLogin::check(self::role_name, function ($user) {
      try {
        $param = $_POST;
        $sch_id = $param['sch_id'];
        $form_id = $param['form_id'];

        // 检测是否已经创建编码
        $result = Model\xonSchoolSet::checkSet($sch_id, Model\x5on::SCHOOL_SET_CODE);

        // 正文内容
        $this->json(['code' => 0, 'data' => $result]);
      }
      catch (Exception $e) {
        // 出错拦截
        $this->json(['code' => 1, 'data' =>  $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });

  }
}