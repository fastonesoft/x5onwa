<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Model;

class Mytuning extends CI_Controller {
  const role_name = 'mytuning';

  /**
   * 当前年级列表
   */
  public function index() {
    Model\xonLogin::check(self::role_name, function ($user) {
      try {
        $grades = Model\xovGradeCurrent::getRows();
        $result = compact('grades');

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  /**
   * 当前年级班级
   */
  public function classes() {
    Model\xonLogin::check(self::role_name, function ($user) {
      try {
        $param = $_POST;
        $grade_id = $param['grade_id'];
        $result = Model\xovClass::getRows4Tuning($grade_id);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  /**
   * 调动学生查询
   */
  public function studmoves() {
    Model\xonLogin::check(self::role_name, function ($user) {
      try {
        $param = $_POST;
        $grade_id = $param['grade_id'];
        $stud_name = $param['stud_name'];
        $result = Model\xovGradeDivisionStud::getStudSumByName($grade_id, $stud_name);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  /**
   * 查询本班用于交换的学生
   */
  public function studchanges() {
    Model\xonLogin::check(self::role_name, function ($user) {
      try {
        $param = $_POST;

        $all = $param['all'];
        $value = $param['value'];
        $cls_id = $param['cls_id'];

        /**
         * TODO: section , to add load section
         */
        $result = Model\xovGradeDivisionStud::getStudSumByValue($cls_id, $value, $all, 10);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  /**
   * 微调学生交换
   */
  public function exchange() {
    Model\xonLogin::check(self::role_name, function ($user) {
      try {
        $param = $_POST;

        $movestud_uid = $param['movestud_uid'];
        $changestud_uids = $param['changestud_uids'];
        $result = Model\xonGradeStud::exchange($movestud_uid, $changestud_uids);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function local() {
    Model\xonLogin::check(self::role_name, function ($user) {
      try {
        $param = $_POST;
        $grade_stud_uid = $param['grade_stud_uid'];
        $result = Model\xonGradeStud::local($grade_stud_uid);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }
}
