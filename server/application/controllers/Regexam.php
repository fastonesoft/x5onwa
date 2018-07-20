<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Model;

class Regexam extends CI_Controller {
  const role_name = 'regexam';
  public function index() {
    Model\xonLogin::check(self::role_name, function ($user) {
      try {
        // 检测审核人员是否注册学校
        $exam_user_id = $user['unionId'];
        $exam_user = Model\xovSchoolTeach::getUserSchool($exam_user_id);
        $exam_sch_id =$exam_user->sch_id;

        // 用户信息
        $param = $_POST;
        $uid = $param['uid'];

        $form_setted = Model\xonSchoolFormSet::getFormSet($uid);
        $user_id = $form_setted->user_id;
        $form_id = $form_setted->form_id;
        $form = Model\xonSchoolForm::getFormById($form_id);
        $sch_id = $form->sch_id;

        if ( $exam_sch_id !== $sch_id ) {
          throw new Exception("用户信息与我校报名要求不符");
        }


        $studreg = Model\xonStudReg::getRegRow($user_id);
        $qrcode_data = Model\x5on::getQrcodeBase64($studreg->uid);
        // 返回刷新数据
        $user_forms = Model\xonSchoolFormKey::listKeysByFormId($user_id, $form_id);
        $result = compact('user_forms', 'qrcode_data');



        $result = Model\xonSchoolFormKey::listKeysByFormId($user_id, $form_id);
        // 正文内容
        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
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
