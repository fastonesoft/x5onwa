<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mvv;
use QCloud_WeApp_SDK\Model;

class Studexam extends CI_Controller {
  const role_name = 'regexam';
  public function index() {
    Mvv\mvvLogin::check(self::role_name, function ($user) {
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

        if ( ! $form_setted->checked ) {
          throw new Exception("表格未上传，无法审核");
        }

        if ( $exam_sch_id !== $sch_id ) {
          throw new Exception("用户信息与我校报名要求不符");
        }

        if ( $exam_user_id === $user_id ) {
          throw new Exception("不可以审核自己的报名信息");
        }

        // 用户报名记录
        $regged_stud = Model\xovStudReg::getStudRegRowByUserId($user_id);
        $sch_name = $regged_stud->sch_name;
        $child_id = $regged_stud->child_id;
        $child_name = $regged_stud->child_name;
        $regged_stud_uid = $regged_stud->uid;
        // 通过审核的，不拦截提示，还得显示出二维码来，
        $passed = $regged_stud->exam_user_id !== null;
        $not_passed = ! $passed;
        // 已经确认的，提示出错
        if ( $regged_stud->confirm_user_id !== null ) {
          throw new Exception("报名信息已审核确认，无须重复操作");
        }

        $entered = Model\xonStudent::checkStudentEnter($child_id, $sch_id);
        if ( $entered !== false ) {
          throw new Exception("已经存在录取信息，无须再审");
        }

        // 返回原二维码
        $qrcode_data = Model\x5on::getQrcodeBase64($uid);
        // 返回刷新数据
        $user_forms = Model\xonSchoolFormKey::listKeysByFormId($user_id, $form_id);
        // 开启标志
        $result = compact('passed', 'not_passed', 'form_setted_uid', 'regged_stud_uid', 'user_forms', 'qrcode_data', 'form_name', 'sch_name', 'child_name');
        // 正文内容
        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function pass() {
    Mvv\mvvLogin::check(self::role_name, function ($user) {
      try {
        // 检测审核人员是否注册学校
        $exam_user_id = $user['unionId'];

        // 用户信息
        $param = $_POST;
        $form_setted_uid = $param['form_setted_uid'];
        $regged_stud_uid = $param['regged_stud_uid'];
        $form_setted = Model\xonSchoolFormSet::getFormSet($form_setted_uid);

        if ( ! $form_setted->checked ) throw new Exception("表格未上传，无法审核");
        Model\xonStudReg::setStudExamUser($regged_stud_uid, $exam_user_id);

        $passed = true;
        $not_passed = false;
        $result = compact('passed', 'not_passed');
        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function cancel () {
    Mvv\mvvLogin::check(self::role_name, function ($user) {
      try {
        $param = $_POST;
        $form_setted_uid = $param['form_setted_uid'];
        $regged_stud_uid = $param['regged_stud_uid'];
        Model\xonStudReg::checkStudExamCancel($regged_stud_uid);
        Model\xonSchoolFormSet::cancelFormSet($form_setted_uid);

        $passed = true;
        $not_passed = false;
        $sch_name = null;
        $child_name = null;
        $form_name = null;
        $user_forms = [];
        $can_show = false;
        $scanned = false;
        $result = compact('passed', 'not_passed', 'sch_name', 'child_name', 'form_name', 'user_forms', 'can_show', 'scanned');
        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }
}
