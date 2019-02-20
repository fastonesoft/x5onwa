<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mvv;
use QCloud_WeApp_SDK\Model;

class Student extends CI_Controller {
  const role_name = 'student';

  public function index() {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        $param = $_POST;
        $uid = $param['uid'];

        // 根据孩子编号，获取学生相关信息，包括二维码
        $qrcode_data = Model\x5on::getQrcodeBase64($uid);

        // 一、基本信息
        $child = Model\xonChild::checkByUid($uid);
        $child_id = $child->id;

        // 二、注册信息
        $students = Model\xovStudent::getsBy(compact('child_id'));

        // 三、年度信息
        $gradestuds = Model\xovGradeStud::getsBy(compact('child_id'));

        $this->json(['code' => 0, 'data' => compact('qrcode_data', 'child', 'students', 'gradestuds')]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }
}