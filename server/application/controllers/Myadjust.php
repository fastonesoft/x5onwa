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
        $kao_stud_id = $param['kao_stud_id'];
        $result = Model\xonStudMove::removeStud($kao_stud_id);

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
        $kao_stud_id = $param['kao_stud_id'];
        $student = Model\xovGradeDivisionStud::getStudSumMovingByKaoStudId($kao_stud_id);
        $qrcode_data = Model\x5on::getQrcodeBase64($kao_stud_id);
        $result = compact('student', 'qrcode_data');

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }
}
