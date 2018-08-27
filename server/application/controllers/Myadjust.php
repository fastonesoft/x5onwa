<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Model;

class Myadjust extends CI_Controller {
  const role_name = 'myadjust';

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

  public function classes() {
    Model\xonLogin::check(self::role_name, function ($user) {
      try {
        $param = $_POST;
        $user_id = $user['unionId'];
        $grade_id = $param['grade_id'];

        $classes = Model\xovClass::getRows4UserDivisioned($user_id, $grade_id);
        $result = compact('classes');

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function student() {
    Model\xonLogin::check(self::role_name, function ($user) {
      try {
        $param = $_POST;
        $grade_id = $param['grade_id'];
        $stud_name = $param['stud_name'];
        $result = Model\xovGradeDivisionStud::getStudSumNotMovedByName($grade_id, $stud_name);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function studmove() {
    Model\xonLogin::check(self::role_name, function ($user) {
      try {
        $param = $_POST;
        $user_id = $user['unionId'];

        $cls_id = $param['cls_id'];
        $grade_stud_uid = $param['grade_stud_uid'];
        Model\xonStudMove::addStud($user_id, $grade_stud_uid, $cls_id);
        $result = Model\xovGradeDivisionStud::getStudSumMovingByRequestClassId($cls_id);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function studlocal() {
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

  /**
   * 本班调动中的学生
   */
  public function classmove() {
    Model\xonLogin::check(self::role_name, function ($user) {
      try {
        $param = $_POST;
        $cls_id = $param['cls_id'];
        $studmoves = Model\xovGradeDivisionStud::getStudSumMovingByRequestClassId($cls_id);
        $studmoveds = Model\xovGradeDivisionStud::getStudSumMovedSuccessByRequestClassId($cls_id);
        $result = compact('studmoves', 'studmoveds');

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function classmoving() {
    Model\xonLogin::check(self::role_name, function ($user) {
      try {
        $param = $_POST;
        $cls_id = $param['cls_id'];
        $result = Model\xovGradeDivisionStud::getStudSumMovingByRequestClassId($cls_id);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function classmoved() {
    Model\xonLogin::check(self::role_name, function ($user) {
      try {
        $param = $_POST;
        $cls_id = $param['cls_id'];
        $result = Model\xovGradeDivisionStud::getStudSumMovedSuccessByRequestClassId($cls_id);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function studremove() {
    Model\xonLogin::check(self::role_name, function ($user) {
      try {
        $param = $_POST;
        $grade_stud_uid = $param['grade_stud_uid'];
        $result = Model\xonStudMove::removeStud($grade_stud_uid);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function exqrcode() {
    Model\xonLogin::check(self::role_name, function ($user) {
      try {
        $param = $_POST;
        $grade_stud_uid = $param['grade_stud_uid'];
        $student = Model\xovGradeDivisionStud::getStudSumMovingByGradeStudUid($grade_stud_uid);
        $qrcode_data = Model\x5on::getQrcodeBase64($grade_stud_uid);
        $result = compact('student', 'qrcode_data');

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function studexchange() {
    Model\xonLogin::check(self::role_name, function ($user) {
      try {
        $param = $_POST;
        $move_grade_stud_uid = $param['move_grade_stud_uid'];
        $exchange_grade_stud_uid = $param['exchange_grade_stud_uid'];
        $request_cls_id = Model\xonStudMove::exchangeStud($move_grade_stud_uid, $exchange_grade_stud_uid);

        $studmoves = Model\xovGradeDivisionStud::getStudSumMovingByRequestClassId($request_cls_id);
        $studmoveds = Model\xovGradeDivisionStud::getStudSumMovedSuccessByRequestClassId($request_cls_id);
        $result = compact('studmoves', 'studmoveds');

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function scanmove() {
    Model\xonLogin::check(self::role_name, function ($user) {
      try {
        $param = $_POST;
        $move_grade_stud_uid = $param['move_grade_stud_uid'];
        $godown = $param['godown'];
        $samesex = $param['samesex'];
        $user_id = $user['unionId'];
        // 调动学生的原始资料
        $grade_stud = Model\xovGradeDivisionStud::getStudSumMovingByUid($move_grade_stud_uid);
        // 是否在分管班级列表
        Model\xovClass::checkClassIdMyDivision($user_id, $grade_stud->grade_id, $grade_stud->cls_id);
        // 查询交换学生数据
        $section = Model\xonDivisionSet::getSectionByGradeId($grade_stud->grade_id);
        $result = Model\xovGradeDivisionStud::getStudSumNotMovedByValue($grade_stud->request_cls_id, $grade_stud->value, $section, $godown, $samesex, $grade_stud->stud_sex_num);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }


}
