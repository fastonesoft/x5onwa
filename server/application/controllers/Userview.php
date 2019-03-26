<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mvv;
use QCloud_WeApp_SDK\Model;

class Userview extends CI_Controller {
  const role_name = 'userview';
  public function index() {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        // 教师分组情况
        $param = $_POST;
        $user_sch_uid = $param['user_sch_uid'];

        $result = Mvv\mvvUserSchoolGroup::groups($userinfor->unionId, $user_sch_uid);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }
}
