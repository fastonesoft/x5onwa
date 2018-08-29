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

  // 调动申请的学生二维码
  public function movingqrcode() {
    Model\xonLogin::check(self::role_name, function ($user) {
      try {
        $param = $_POST;
        $user_id = $user['unionId'];
        $grade_stud_uid = $param['grade_stud_uid'];
        $student = Model\xovGradeDivisionStud::getStudSumMovingByGradeStudUid($grade_stud_uid);
        $qrcode_data = Model\x5on::getQrcodeBase64($grade_stud_uid);
        // 查找是否本人分管班级学生
        $exchangestuds = [];
        $value = $student->value;
        $cls_id = $student->cls_id;
        $request_cls_id = $student->request_cls_id;
        $grade_id = $student->grade_id;
        $stud_sex_num = $student->stud_sex_num;
        $class_in_mydivision = Model\xovClass::classIdMyDivision($user_id, $grade_id, $cls_id);
        if ( $class_in_mydivision ) {
          // 查询交换学生数据
          $godown = Model\xonDivisionSet::getGodownByGradeId($grade_id);
          $samesex = Model\xonDivisionSet::getSamesexByGradeId($grade_id);
          $section = Model\xonDivisionSet::getSectionByGradeId($grade_id);
          $limit_num = Model\xonDivisionSet::getLimitnumByGradeId($grade_id);
          $exchangestuds = Model\xovGradeDivisionStud::getStudSumNotMovedByValue($request_cls_id, $value, $section, $godown, $samesex, $stud_sex_num, $limit_num);
        }
        $student = [$student];
        $result = compact('student', 'qrcode_data', 'exchangestuds', 'class_in_mydivision');

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  // 识别交换学生二维码 -> 完成交换
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

  // 本人分管的学生调动 与 交换
  // 与 二维码识别不同，增加自主添加学生studmove记录
  public function studexchangeself() {
    Model\xonLogin::check(self::role_name, function ($user) {
      try {
        $param = $_POST;
        $user_id = $user['unionId'];
        $move_grade_stud_uid = $param['move_grade_stud_uid'];
        $exchange_grade_stud_uid = $param['exchange_grade_stud_uid'];

        $move = Model\xovGradeDivisionStud::getStudSumMovingByGradeStudUid($move_grade_stud_uid);
        $request_cls_id = $move->request_cls_id;
        $exchange_request_cls_id = $move->cls_id;
        // 添加交换学生进调动表
        Model\xonStudMove::addStudExchange($user_id, $exchange_grade_stud_uid, $exchange_request_cls_id, $move_grade_stud_uid);
        // 完成交换
        Model\xonStudMove::exchangeStud($move_grade_stud_uid, $exchange_grade_stud_uid);
        // 返回数据
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

  // 识别调动学生，查询交换学生列表
  public function scanmove() {
    Model\xonLogin::check(self::role_name, function ($user) {
      try {
        $param = $_POST;
        $move_grade_stud_uid = $param['move_grade_stud_uid'];
        $user_id = $user['unionId'];
        // 调动学生的原始资料
        $move = Model\xovGradeDivisionStud::getStudSumMovingByUid($move_grade_stud_uid);
        // 是否在分管班级列表
        Model\xovClass::checkClassIdMyDivision($user_id, $move->grade_id, $move->cls_id);
        // 查询交换学生数据
        $grade_id = $move->grade_id;
        $godown = Model\xonDivisionSet::getGodownByGradeId($grade_id);
        $samesex = Model\xonDivisionSet::getSamesexByGradeId($grade_id);
        $section = Model\xonDivisionSet::getSectionByGradeId($grade_id);
        $limit_num = Model\xonDivisionSet::getLimitnumByGradeId($grade_id);

        $result = Model\xovGradeDivisionStud::getStudSumNotMovedByValue($move->request_cls_id, $move->value, $section, $godown, $samesex, $move->stud_sex_num, $limit_num);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  // 添加交换学生记录，返回交换学生列表
  public function addexchange() {
    Model\xonLogin::check(self::role_name, function ($user) {
      try {
        $param = $_POST;
        $user_id = $user['unionId'];
        $grade_stud_uid = $param['grade_stud_uid'];
        $exchange_grade_stud_uid = $param['exchange_grade_stud_uid'];
        $move_stud = Model\xovGradeDivisionStud::getStudSumMovingByUid($exchange_grade_stud_uid);
        Model\xonStudMove::addStudExchange($user_id, $grade_stud_uid, $move_stud->cls_id, $exchange_grade_stud_uid);

        // 返回交换学生列表，以请求用户为单位
        $result = Model\xovGradeDivisionStud::getStudSumExchangingByUserId($user_id);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  // 查询交换学生信息 并 与之匹配的调动学生信息
  public function queryexchange() {
    Model\xonLogin::check(self::role_name, function ($user) {
      try {
        $param = $_POST;
        $grade_stud_uid = $param['grade_stud_uid'];
        $exchangestud = Model\xovGradeDivisionStud::getStudSumExchangingByGradeStudUid($grade_stud_uid);
        $move_stud_id = $exchangestud->exchange_grade_stud_uid;
        $movestud = Model\xovGradeDivisionStud::getStudSumMovingByGradeStudUid($move_stud_id);

        $qrcode_data = Model\x5on::getQrcodeBase64($grade_stud_uid);

        $movestud = [$movestud];
        $exchangestud = [$exchangestud];
        $result = compact('exchangestud', 'movestud', 'qrcode_data');

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  // 查询交换学生列表
  public function exchangelist() {
    Model\xonLogin::check(self::role_name, function ($user) {
      try {
        $user_id = $user['unionId'];
        $result = Model\xovGradeDivisionStud::getStudSumExchangingByUserId($user_id);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

}
