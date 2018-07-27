<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Model;

class Studconfirm extends CI_Controller {
  const role_name = 'regconfirm';
  public function index() {
    Model\xonLogin::check(self::role_name, function ($user) {
      try {
        // 检测审核人员是否注册学校
        $confirm_user_id = $user['unionId'];
        $confirm_user = Model\xovSchoolTeach::getUserSchool($confirm_user_id);
        $confirm_sch_id = $confirm_user->sch_id;

        // 二维码信息
        $param = $_POST;
        $uid = $param['uid'];

        // 用户提交的表单信息
        $form_setted = Model\xonSchoolFormSet::getFormSet($uid);
        $user_id = $form_setted->user_id;
        $form_id = $form_setted->form_id;
        $form = Model\xonSchoolForm::getFormById($form_id);
        $sch_id = $form->sch_id;
        $form_name = $form->name;
        $form_setted_uid = $form_setted->uid;

        if ( $confirm_sch_id !== $sch_id ) {
          throw new Exception("用户信息与我校报名要求不符");
        }

        // 用户报名记录
        $regged_stud = Model\xovStudReg::getStudRegRowByUserId($user_id);
        $sch_name = $regged_stud->sch_name;
        $child_id = $regged_stud->child_id;
        $child_name = $regged_stud->child_name;
        $regged_stud_uid = $regged_stud->uid;

        $entered = Model\xonStudent::checkStudentEnter($child_id, $sch_id);
        if ( $entered !== false ) {
          throw new Exception("已经存在录取信息，无须再审");
        }


        // 通过没有通过审核的，拦截
        $exam_user_id = $regged_stud->exam_user_id;
        $passed = $exam_user_id !== null;
        $not_confirmed = $regged_stud->confirm_user_id === null;
        $not_passed = ! $passed;
        if ( $not_passed ) {
          throw new Exception("还没有通过审核，无法确认");
        }

        // 不可以为自己审核、确认
        if ( $confirm_user_id === $user_id ) {
          throw new Exception("不可以为自己审核、确认");
        }

        // 审核、确认用户检测，不得是同一个人
        if ( $exam_user_id === $confirm_user_id ) {
          throw new Exception("不可以既审核，又确认");
        }

        // 已经确认的，提示出错
        if ( $regged_stud->confirm_user_id !== null ) {
          throw new Exception("报名信息已审核确认，无须重复操作");
        }

        // 返回刷新数据
        $user_forms = Model\xonSchoolFormKey::listKeysByFormId($user_id, $form_id);
        // 开启标志
        $result = compact('passed', 'not_confirmed', 'form_setted_uid', 'regged_stud_uid', 'user_forms', 'form_name', 'sch_name', 'child_name');
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
    Model\xonLogin::check(self::role_name, function ($user) {
      try {
        // 检测审核人员是否注册学校
        $confirm_user_id = $user['unionId'];

        // 用户信息
        $param = $_POST;
        $form_setted_uid = $param['form_setted_uid'];
        $regged_stud_uid = $param['regged_stud_uid'];
        $form_setted = Model\xonSchoolFormSet::getFormSet($form_setted_uid);

        if ( ! $form_setted->checked ) throw new Exception("表格未上传，无法审核");
        Model\xonStudReg::setStudConfirmUser($regged_stud_uid, $confirm_user_id);


        $passed = false;
        $not_confirmed = true;
        $sch_name = null;
        $child_name = null;
        $form_name = null;
        $user_forms = [];

        $result = compact('passed', 'not_confirmed', 'sch_name', 'child_name', 'form_name', 'user_forms');
        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function cancel () {
    Model\xonLogin::check(self::role_name, function ($user) {
      try {
        $param = $_POST;
        $regged_stud_uid = $param['regged_stud_uid'];
        Model\xonStudReg::checkStudConfirmCancel($regged_stud_uid);
        // 删除审核用户
        Model\xonStudReg::delStudExamUser($regged_stud_uid);

        $passed = false;
        $not_confirmed = true;
        $sch_name = null;
        $child_name = null;
        $form_name = null;
        $user_forms = [];
        $result = compact('passed', 'not_confirmed', 'sch_name', 'child_name', 'form_name', 'user_forms');
        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }
}
