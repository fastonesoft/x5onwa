<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Model;

class Studexam extends CI_Controller {
  const role_name = 'regexam';
  public function index() {
    Model\xonLogin::check(self::role_name, function ($user) {
      try {
        // 检测审核人员是否注册学校
        $exam_user_id = $user['unionId'];
        $exam_user = Model\xovSchoolTeach::getUserSchool($exam_user_id);
        $exam_sch_id = $exam_user->sch_id;

        // 用户信息
        $param = $_POST;
        $uid = $param['uid'];

        $form_setted = Model\xonSchoolFormSet::getFormSet($uid);
        $user_id = $form_setted->user_id;
        $form_id = $form_setted->form_id;
        $form = Model\xonSchoolForm::getFormById($form_id);
        $sch_id = $form->sch_id;
        $form_name = $form->name;
        $form_setted_uid = $form_setted->uid;

        if ( $exam_sch_id !== $sch_id ) {
          throw new Exception("用户信息与我校报名要求不符");
        }

        if ( $exam_user_id === $user_id ) {
          throw new Exception("不可以审核自己的报名信息");
        }

        // 用户报名记录
        $regged_stud = Model\xovStudReg::getStudRegRow($user_id);
        $sch_name = $regged_stud->sch_name;
        $child_name = $regged_stud->child_name;
        $regged_stud_uid = $regged_stud->uid;

        // 返回原二维码
        $qrcode_data = Model\x5on::getQrcodeBase64($uid);
        // 返回刷新数据
        $user_forms = Model\xonSchoolFormKey::listKeysByFormId($user_id, $form_id);
        // 开启标志
        $result = compact('form_setted_uid', 'regged_stud_uid', 'user_forms', 'qrcode_data', 'form_name', 'sch_name', 'child_name');
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
