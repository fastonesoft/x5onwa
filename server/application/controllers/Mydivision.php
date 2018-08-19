<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Model;

class Mydivision extends CI_Controller {
  const role_name = 'mydivision';


  public function index() {
    Model\xonLogin::check(self::role_name, function ($user) {
      try {
        $grades = Model\xovGradeCurrent::getRows();
        $result = compact('grades');
        // 正文
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
        $grade_id = $param['grade_id'];
        $result = Model\xovClass::getRows4Division($grade_id);

        // 正文
        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function teachs() {
    Model\xonLogin::check(self::role_name, function ($user) {
      try {
        $param = $_POST;
        $user_name = $param["user_name"];
        $division_user_id = $user['unionId'];
        $sch_id = Model\xovSchoolTeach::getUserSchoolId($division_user_id);
        $result = Model\xonGradeDivision::getSchoolTeach($sch_id, $user_name);
        // 正文
        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function update() {
    Model\xonLogin::check(self::role_name, function ($user) {
      try {
        $param = $_POST;

        $user_id = $param['user_id'];
        $cls_ids = $param['cls_ids'];
        $grade_id = Model\xonGradeDivision::setDivision($user_id, $cls_ids);
        $result = Model\xovClass::getRows4Divisioned($grade_id);

        // 正文
        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function classed() {
    Model\xonLogin::check(self::role_name, function ($user) {
      try {
        $param = $_POST;
        $grade_id = $param['grade_id'];
        $result = Model\xovClass::getRows4Divisioned($grade_id);

        // 正文
        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function remove() {
    Model\xonLogin::check(self::role_name, function ($user) {
      try {
        $param = $_POST;
        $uid = $param['uid'];
        $grade_id = Model\xonGradeDivision::removeDivision($uid);
        $result = Model\xovClass::getRows4Division($grade_id);

        // 正文
        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

}
