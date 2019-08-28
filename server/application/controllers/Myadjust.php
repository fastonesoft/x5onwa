<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mvv;
use QCloud_WeApp_SDK\Model;

class Myadjust extends CI_Controller
{
    const role_name = 'myadjust';

    public function index()
    {
        Mvv\mvvLogin::check(self::role_name, function ($user) {
            try {
                $result = Mvv\mvvMyAdjust::grades($user->unionId);

                $this->json(['code' => 0, 'data' => $result]);
            } catch (Exception $e) {
                $this->json(['code' => 1, 'data' => $e->getMessage()]);
            }
        }, function ($error) {
            $this->json($error);
        });
    }

    // 分管班级名条
    public function cls()
    {
        Mvv\mvvLogin::check(self::role_name, function ($user) {
            try {
                $param = $_POST;
                $grade_id = $param['grade_id'];
                $result = Mvv\mvvMyAdjust::cls($user->unionId, $grade_id);

                $this->json(['code' => 0, 'data' => $result]);
            } catch (Exception $e) {
                $this->json(['code' => 1, 'data' => $e->getMessage()]);
            }
        }, function ($error) {
            $this->json($error);
        });
    }

    // 调动过的学生，包括：正在调的、调动成功的
    public function moves()
    {
        Mvv\mvvLogin::check(self::role_name, function ($user) {
            try {
                $param = $_POST;
                $cls_id = $param['cls_id'];
                $result = Mvv\mvvMyAdjust::moves($user->unionId, $cls_id);

                $this->json(['code' => 0, 'data' => $result]);
            } catch (Exception $e) {
                $this->json(['code' => 1, 'data' => $e->getMessage()]);
            }
        }, function ($error) {
            $this->json($error);
        });
    }

    public function local()
    {
        Mvv\mvvLogin::check(self::role_name, function ($user) {
            try {
                $param = $_POST;
                $grade_stud_uid = $param['grade_stud_uid'];

                $result = Mvv\mvvMyAdjust::local($user->unionId, $grade_stud_uid);

                $this->json(['code' => 0, 'data' => $result]);
            } catch (Exception $e) {
                $this->json(['code' => 1, 'data' => $e->getMessage()]);
            }
        }, function ($error) {
            $this->json($error);
        });
    }

    // 调动学生查询
    public function query()
    {
        Mvv\mvvLogin::check(self::role_name, function ($user) {
            try {
                $param = $_POST;
                $grade_id = $param['grade_id'];
                $stud_name = Model\x5on::getLike($param['stud_name']);
                $result = Mvv\mvvMyAdjust::query($user->unionId, $grade_id, $stud_name);

                $this->json(['code' => 0, 'data' => $result]);
            } catch (Exception $e) {
                $this->json(['code' => 1, 'data' => $e->getMessage()]);
            }
        }, function ($error) {
            $this->json($error);
        });
    }

    public function req()
    {
        Mvv\mvvLogin::check(self::role_name, function ($user) {
            try {
                $param = $_POST;
                $grade_stud_uid = $param['grade_stud_uid'];
                $request_cls_id = $param['cls_id'];

                $result = Mvv\mvvMyAdjust::req($user->unionId, $grade_stud_uid, $request_cls_id);

                $this->json(['code' => 0, 'data' => $result]);
            } catch (Exception $e) {
                $this->json(['code' => 1, 'data' => $e->getMessage()]);
            }
        }, function ($error) {
            $this->json($error);
        });
    }

    public function remove()
    {
        Mvv\mvvLogin::check(self::role_name, function ($user) {
            try {
                $param = $_POST;
                $grade_stud_uid = $param['uid'];

                $result = Mvv\mvvMyAdjust::remove($user->unionId, $grade_stud_uid);

                $this->json(['code' => 0, 'data' => $result]);
            } catch (Exception $e) {
                $this->json(['code' => 1, 'data' => $e->getMessage()]);
            }
        }, function ($error) {
            $this->json($error);
        });
    }

    // 本班调出学生查询
    public function out()
    {
        Mvv\mvvLogin::check(self::role_name, function ($user) {
            try {
                $param = $_POST;
                $grade_stud_uid = $param['come_stud_uid'];
                $cls_id = $param['cls_id'];

                $result = Mvv\mvvMyAdjust::out($user->unionId, $grade_stud_uid, $cls_id);

                $this->json(['code' => 0, 'data' => $result]);
            } catch (Exception $e) {
                $this->json(['code' => 1, 'data' => $e->getMessage()]);
            }
        }, function ($error) {
            $this->json($error);
        });
    }

    public function change()
    {
        Mvv\mvvLogin::check(self::role_name, function ($user) {
            try {
                $param = $_POST;
                $come_stud_uid = $param['come_stud_uid'];
                $out_stud_uid = $param['out_stud_uid'];

                $result = Mvv\mvvMyAdjust::change($user->unionId, $come_stud_uid, $out_stud_uid);

                $this->json(['code' => 0, 'data' => $result]);
            } catch (Exception $e) {
                $this->json(['code' => 1, 'data' => $e->getMessage()]);
            }
        }, function ($error) {
            $this->json($error);
        });
    }

}
