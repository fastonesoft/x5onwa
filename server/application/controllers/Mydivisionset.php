<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mvv;
use QCloud_WeApp_SDK\Model;

class Mydivisionset extends CI_Controller {
  const role_name = 'mydivisionset';

  public function index() {
    Mvv\mvvLogin::check(self::role_name, function ($user) {
      try {
        $grades = Model\xovGradeCurrent::gets();
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

  public function data() {
    Mvv\mvvLogin::check(self::role_name, function ($user) {
      try {
        $param = $_POST;
        $grade_id = $param['grade_id'];
        $result = Model\xonDivisionSet::getRowByGradeId($grade_id);

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
    Mvv\mvvLogin::check(self::role_name, function ($user) {
      try {
        $param = $_POST;
        $grade_id = $param['grade_id'];
        $section = $param['section'];
        $limit_num = $param['limit_num'];
        $samesex = $param['samesex'];
        $godown = $param['godown'];
        $finished = $param['finished'];

        $samesex = $samesex === 'true' ? 1 : 0;
        $godown = $godown === 'true' ? 1 : 0;
        $finished = $finished === 'true' ? 1 : 0;



        $result = Model\xonDivisionSet::update($grade_id, $section, $limit_num, $samesex, $godown, $finished);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }
}
