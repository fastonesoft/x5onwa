<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Model;
use \QCloud_WeApp_SDK\Mvv;

class Gradestud extends CI_Controller {
  const role_name = 'students';

  public function index() {
    Model\xonLogin::check(self::role_name, function ($user) {
      try {
        // 未完成

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
        $result = Mvv\mvvGradeStud::grades();

        // 年级列表
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
        $grade_id = $param['grade_id'] === 'null' ? null : $param['grade_id'];

        // 班级列表
        $result = Mvv\mvvGradeStud::classes($grade_id);
        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function studcls() {
    Model\xonLogin::check(self::role_name, function ($user) {
      try {
        $param = $_POST;
        $grade_id = $param['grade_id'] === 'null' ? null : $param['grade_id'];
        $cls_id = $param['cls_id'] === 'null' ? null : $param['cls_id'];

        // 班级学生
        $result = Mvv\mvvGradeStud::studCls($grade_id, $cls_id);
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
        $grade_id = $param['grade_id'] === 'null' ? null : $param['grade_id'];
        $cls_id = $param['cls_id'] === 'null' ? null : $param['cls_id'];
        $stud_name = $param['stud_name'];
        $stud_name = Model\x5on::getLike($stud_name);

        // 模糊查询学生姓名
        $result = Mvv\mvvGradeStud::query($grade_id, $cls_id, $stud_name);
        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function type() {
    Model\xonLogin::check(self::role_name, function ($user) {
      try {
        $param = $_POST;

        // 学生来源
        $result = Mvv\mvvGradeStud::type();
        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function status() {
    Model\xonLogin::check(self::role_name, function ($user) {
      try {
        $param = $_POST;

        // 学籍状态
        $in_sch = 1;
        $result = Mvv\mvvGradeStud::status($in_sch);
        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }


  public function uid() {
    Model\xonLogin::check(self::role_name, function ($user) {
      try {
        $param = $_POST;
        $uid = $param['uid'];

        // 根据序号查询学生信息
        $result = Mvv\mvvGradeStud::studByUid($uid);
        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function add() {
    Model\xonLogin::check(self::role_name, function ($user) {
      try {
        $param = $_POST;
        $cls_id = $param['cls_id'];
        $grade_id = $param['grade_id'];
        $stud_idc = $param['stud_idc'];
        $stud_name = $param['stud_name'];
        $come_date = $param['come_date'];
        $stud_type_id = $param['stud_type_id'];
        $stud_status_id = $param['stud_status_id'];
        $stud_auth = $param['stud_auth'] === 'true' ? 1 : 0;

        // 添加学生
        $result = Mvv\mvvGradeStud::addNoExam($grade_id, $cls_id, $stud_name, $stud_idc, $stud_type_id, $stud_status_id, $stud_auth, $come_date);
        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function move() {
    Model\xonLogin::check(self::role_name, function ($user) {
      try {
        $param = $_POST;
        $uid = $param['uid'];
        $cls_id = $param['cls_id'];

        // 学生班级调动
        $result = Mvv\mvvGradeStud::studMove($uid, $cls_id);
        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function modi() {
    Model\xonLogin::check(self::role_name, function ($user) {
      try {
        $param = $_POST;
        $uid = $param['uid'];
        $stud_idc = $param['stud_idc'];
        $stud_name = $param['stud_name'];

        //
        $result = Mvv\mvvGradeStud::studModi($uid, $stud_idc, $stud_name);
        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function auth() {
    Model\xonLogin::check(self::role_name, function ($user) {
      try {
        $param = $_POST;
        $uid = $param['uid'];
        $stud_auth = $param['stud_auth'] === 'true' ? 1 : 0;

        //
        $result = Mvv\mvvGradeStud::studAuth($uid, $stud_auth);
        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function come() {
    Model\xonLogin::check(self::role_name, function ($user) {
      try {
        $param = $_POST;
        $cls_id = $param['cls_id'];
        $grade_id = $param['grade_id'];
        $stud_idc = $param['stud_idc'];
        $stud_name = $param['stud_name'];
        $come_date = $param['come_date'];
        $stud_type_id = $param['stud_type_id'];
        $stud_status_id = $param['stud_status_id'];
        $stud_trans_name = $param['stud_trans_name'];
        $stud_auth = $param['stud_auth'] === 'true' ? 1 : 0;

        //
        $result = Mvv\mvvGradeStud::addNoExam($grade_id, $cls_id, $stud_name, $stud_idc, $stud_type_id, $stud_status_id, $stud_auth, $come_date);
        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function repet() {
    Model\xonLogin::check(self::role_name, function ($user) {
      try {
        $param = $_POST;
        $cls_id = $param['cls_id'];
        $grade_id = $param['grade_id'];
        $stud_idc = $param['stud_idc'];
        $stud_name = $param['stud_name'];
        $come_date = $param['come_date'];
        $stud_type_id = $param['stud_type_id'];
        $stud_status_id = $param['stud_status_id'];
        $stud_auth = $param['stud_auth'] === 'true' ? 1 : 0;

        //
        $result = Mvv\mvvGradeStud::addNoExam($grade_id, $cls_id, $stud_name, $stud_idc, $stud_type_id, $stud_status_id, $stud_auth, $come_date);
        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function read() {
    Model\xonLogin::check(self::role_name, function ($user) {
      try {
        $param = $_POST;
        $cls_id = $param['cls_id'];
        $grade_id = $param['grade_id'];
        $stud_idc = $param['stud_idc'];
        $stud_name = $param['stud_name'];
        $come_date = $param['come_date'];
        $stud_type_id = $param['stud_type_id'];
        $stud_status_id = $param['stud_status_id'];
        $stud_auth = $param['stud_auth'] === 'true' ? 1 : 0;

        //
        $result = Mvv\mvvGradeStud::addNoExam($grade_id, $cls_id, $stud_name, $stud_idc, $stud_type_id, $stud_status_id, $stud_auth, $come_date);
        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

}
