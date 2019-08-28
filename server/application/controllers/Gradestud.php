<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mvv;
use QCloud_WeApp_SDK\Model;

class Gradestud extends CI_Controller
{
    const role_name = 'students';
    public function index()
    {
        Mvv\mvvLogin::check(self::role_name, function ($user) {
            try {
                $result = Mvv\mvvGradeStud::grades($user->unionId);

                // 年级列表
                $this->json(['code' => 0, 'data' => $result]);
            } catch (Exception $e) {
                $this->json(['code' => 1, 'data' => $e->getMessage()]);
            }
        }, function ($error) {
            $this->json($error);
        });
    }

    public function classes()
    {
        Mvv\mvvLogin::check(self::role_name, function ($user) {
            try {
                $param = $_POST;
                $grade_id = $param['grade_id'];

                // 班级列表、班级学生统计信息
                $result = Mvv\mvvGradeStud::classes($user->unionId, $grade_id);
                $this->json(['code' => 0, 'data' => $result]);
            } catch (Exception $e) {
                $this->json(['code' => 1, 'data' => $e->getMessage()]);
            }
        }, function ($error) {
            $this->json($error);
        });
    }

    public function studcls()
    {
        Mvv\mvvLogin::check(self::role_name, function ($user) {
            try {
                $param = $_POST;
                $cls_id = $param['cls_id'];

                // 班级学生
                $result = Mvv\mvvGradeStud::studcls($user->unionId, $cls_id);
                $this->json(['code' => 0, 'data' => $result]);
            } catch (Exception $e) {
                $this->json(['code' => 1, 'data' => $e->getMessage()]);
            }
        }, function ($error) {
            $this->json($error);
        });
    }

    public function query()
    {
        Mvv\mvvLogin::check(self::role_name, function ($user) {
            try {
                $param = $_POST;
                $grade_id = isset($param['grade_id']) ? $param['grade_id'] : null;
                $cls_id = isset($param['cls_id']) ? $param['cls_id'] : null;
                $stud_name = Model\x5on::getLike($param['stud_name']);

                // 模糊查询学生
                $result = Mvv\mvvGradeStud::query($user->unionId, $grade_id, $cls_id, $stud_name);
                $this->json(['code' => 0, 'data' => $result]);
            } catch (Exception $e) {
                $this->json(['code' => 1, 'data' => $e->getMessage()]);
            }
        }, function ($error) {
            $this->json($error);
        });
    }

    public function cls()
    {
        Mvv\mvvLogin::check(self::role_name, function ($user) {
            try {
                $param = $_POST;
                $grade_id = $param['grade_id'];

                // 班级列表
                $result = Mvv\mvvGradeStud::cls($user->unionId, $grade_id);
                $this->json(['code' => 0, 'data' => $result]);
            } catch (Exception $e) {
                $this->json(['code' => 1, 'data' => $e->getMessage()]);
            }
        }, function ($error) {
            $this->json($error);
        });
    }

    public function type()
    {
        Mvv\mvvLogin::check(self::role_name, function ($user) {
            try {
                // 学生来源
                $result = Mvv\mvvGradeStud::type($user->unionId);
                $this->json(['code' => 0, 'data' => $result]);
            } catch (Exception $e) {
                $this->json(['code' => 1, 'data' => $e->getMessage()]);
            }
        }, function ($error) {
            $this->json($error);
        });
    }

    public function statusin()
    {
        Mvv\mvvLogin::check(self::role_name, function ($user) {
            try {
                // 学籍状态
                $in_sch = 1;
                $result = Mvv\mvvGradeStud::status($user->unionId, $in_sch);
                $this->json(['code' => 0, 'data' => $result]);
            } catch (Exception $e) {
                $this->json(['code' => 1, 'data' => $e->getMessage()]);
            }
        }, function ($error) {
            $this->json($error);
        });
    }

    public function auth()
    {
        Mvv\mvvLogin::check(self::role_name, function ($user) {
            try {
                // 是否指标生
                $result = Mvv\mvvGradeStud::auth($user->unionId);
                $this->json(['code' => 0, 'data' => $result]);
            } catch (Exception $e) {
                $this->json(['code' => 1, 'data' => $e->getMessage()]);
            }
        }, function ($error) {
            $this->json($error);
        });
    }

    public function add()
    {
        Mvv\mvvLogin::check(self::role_name, function ($user) {
            try {
                $param = $_POST;
                $cls_id = $param['cls_id'];
                $grade_id = $param['grade_id'];
                $stud_idc = $param['stud_idc'];
                $stud_name = $param['stud_name'];
                $come_date = date('Y-m-d');
                $type_id = $param['type_id'];
                $status_id = $param['status_id'];
                $stud_auth = $param['stud_auth'];
                // 添加年度学生
                $result = Mvv\mvvGradeStud::addNoExam($user->unionId, $grade_id, $cls_id, $stud_name, $stud_idc, $type_id, $status_id, $stud_auth, $come_date);
                $this->json(['code' => 0, 'data' => $result]);
            } catch (Exception $e) {
                $this->json(['code' => 1, 'data' => $e->getMessage()]);
            }
        }, function ($error) {
            $this->json($error);
        });
    }

    public function edit()
    {
        Mvv\mvvLogin::check(self::role_name, function ($user) {
            try {
                $param = $_POST;
                $grade_stud_uid = $param['uid'];
                $cls_id = $param['cls_id'];
                $type_id = $param['type_id'];
                $status_id = $param['status_id'];
                $stud_auth = $param['stud_auth'];
                // 年度学生修改
                $result = Mvv\mvvGradeStud::edit($user->unionId, $grade_stud_uid, $cls_id, $type_id, $status_id, $stud_auth);
                $this->json(['code' => 0, 'data' => $result]);
            } catch (Exception $e) {
                $this->json(['code' => 1, 'data' => $e->getMessage()]);
            }
        }, function ($error) {
            $this->json($error);
        });
    }

    public function temp()
    {
        Mvv\mvvLogin::check(self::role_name, function ($user) {
            try {
                $param = $_POST;
                $grade_stud_uid = $param['uid'];
                //
                $result = Mvv\mvvGradeStud::temp($user->unionId, $grade_stud_uid);
                $this->json(['code' => 0, 'data' => $result]);
            } catch (Exception $e) {
                $this->json(['code' => 1, 'data' => $e->getMessage()]);
            }
        }, function ($error) {
            $this->json($error);
        });
    }

    public function backck()
    {
        Mvv\mvvLogin::check(self::role_name, function ($user) {
            try {
                $param = $_POST;
                $grade_stud_uid = $param['uid'];

                // 年度学生回校检测
                $result = Mvv\mvvGradeStud::backck($user->unionId, $grade_stud_uid);
                $this->json(['code' => 0, 'data' => $result]);
            } catch (Exception $e) {
                $this->json(['code' => 1, 'data' => $e->getMessage()]);
            }
        }, function ($error) {
            $this->json($error);
        });
    }

    public function back()
    {
        Mvv\mvvLogin::check(self::role_name, function ($user) {
            try {
                $param = $_POST;
                $grade_stud_uid = $param['uid'];
                $cls_id = $param['cls_id'];
                $status_id = $param['status_id'];
                // 年度学生回校
                $result = Mvv\mvvGradeStud::back($user->unionId, $grade_stud_uid, $cls_id, $status_id);
                $this->json(['code' => 0, 'data' => $result]);
            } catch (Exception $e) {
                $this->json(['code' => 1, 'data' => $e->getMessage()]);
            }
        }, function ($error) {
            $this->json($error);
        });
    }

    public function backref()
    {
        Mvv\mvvLogin::check(self::role_name, function ($user) {
            try {
                $param = $_POST;
                $grade_id = $param['grade_id'];
                // 年度学生回校
                $result = Mvv\mvvGradeStud::backref($user->unionId, $grade_id);
                $this->json(['code' => 0, 'data' => $result]);
            } catch (Exception $e) {
                $this->json(['code' => 1, 'data' => $e->getMessage()]);
            }
        }, function ($error) {
            $this->json($error);
        });
    }

}
