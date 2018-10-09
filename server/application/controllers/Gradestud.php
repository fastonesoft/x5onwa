<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Model;

class Gradestud extends CI_Controller {
  const role_name = 'students';

  public function index() {
    Model\xonLogin::check(self::role_name, function ($user) {
      try {

        $this->json(['code' => 0, 'data' => $user]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function grade() {
    Model\xonLogin::check(self::role_name, function ($user) {
      try {
        $result = Model\xovGradeCurrent::gets();
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

        $result = Model\xonClass::getsBy(compact('grade_id'));
        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function query() {
    Model\xonLogin::check(self::role_name, function ($user) {
      try {
        $param = $_POST;
        $grade_id = $param['grade_id'];
        $cls_id = $param['cls_id'];
        $stud_name = Model\x5on::getLike($param['stud_name']);

        if ($grade_id && $cls_id) {
          $result = Model\xovStudent::likes(compact('grade_id', 'cls_id'), compact('stud_name'));
        }

        $result = Model\xovStudent::likes(compact('stud_name'));

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }
}
