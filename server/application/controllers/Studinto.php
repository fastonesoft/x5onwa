<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mvv;
use QCloud_WeApp_SDK\Model;

class Studinto extends CI_Controller
{
    /**
     * 学生分级
     */
    const role_name = 'studinto';
    public function index()
    {
        Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
            try {
                // 当前可录取年级
                $result = Mvv\mvvStudInto::steps($userinfor->unionId);

                $this->json(['code' => 0, 'data' => $result]);
            } catch (Exception $e) {
                $this->json(['code' => 1, 'data' => $e->getMessage()]);
            }
        }, function ($error) {
            $this->json($error);
        });
    }

    public function count()
    {
        Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
            try {
                // 未分级学生统计
                $param = $_POST;
                $steps_id = $param['steps_id'];

                $result = Mvv\mvvStudInto::count($userinfor->unionId, $steps_id);

                $this->json(['code' => 0, 'data' => $result]);
            } catch (Exception $e) {
                $this->json(['code' => 1, 'data' => $e->getMessage()]);
            }
        }, function ($error) {
            $this->json($error);
        });
    }

    public function enter()
    {
        Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
            try {
                // 学生分级
                $param = $_POST;
                $steps_id = $param['steps_id'];
                $cls_id = $param['cls_id'];

                $result = Mvv\mvvStudInto::enter($userinfor->unionId, $steps_id, $cls_id);

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
        Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
            try {
                // 学生分级
                $param = $_POST;
                $steps_id = $param['steps_id'];
                $stud_name = Model\x5on::getLike($param['stud_name']);

                $result = Mvv\mvvStudInto::query($userinfor->unionId, $steps_id, $stud_name);

                $this->json(['code' => 0, 'data' => $result]);
            } catch (Exception $e) {
                $this->json(['code' => 1, 'data' => $e->getMessage()]);
            }
        }, function ($error) {
            $this->json($error);
        });
    }

    public function out()
    {
        Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
            try {
                // 年级学生删除
                $param = $_POST;
                $steps_id = $param['steps_id'];
                $grade_stud_uids_string = $param['uids'];

                $result = Mvv\mvvStudInto::out($userinfor->unionId, $steps_id, $grade_stud_uids_string);

                $this->json(['code' => 0, 'data' => $result]);
            } catch (Exception $e) {
                $this->json(['code' => 1, 'data' => $e->getMessage()]);
            }
        }, function ($error) {
            $this->json($error);
        });
    }

}
