<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mvv;
use QCloud_WeApp_SDK\Model;

class Studown extends CI_Controller
{
    /**
     * 休学申请
     */
    const role_name = 'studown';

    public function index()
    {
        Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
            try {
                // 当前年度年级
                $result = Mvv\mvvStudown::grades($userinfor->unionId);

                $this->json(['code' => 0, 'data' => $result]);
            } catch (Exception $e) {
                $this->json(['code' => 1, 'data' => $e->getMessage()]);
            }
        }, function ($error) {
            $this->json($error);
        });
    }

    public function down()
    {
        Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
            try {
                // 休学年级
                $param = $_POST;
                $grade_id = $param['grade_id'];

                $result = Mvv\mvvStudown::down($userinfor->unionId, $grade_id);

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
        Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
            try {
                // 休学班级
                $param = $_POST;
                $grade_id = $param['down_id'];

                $result = Mvv\mvvStudown::cls($userinfor->unionId, $grade_id);

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
                // 学生查询
                $param = $_POST;
                $grade_id = $param['grade_id'];
                $stud_name = Model\x5on::getLike($param['stud_name']);

                $result = Mvv\mvvStudown::query($userinfor->unionId, $grade_id, $stud_name);

                $this->json(['code' => 0, 'data' => $result]);
            } catch (Exception $e) {
                $this->json(['code' => 1, 'data' => $e->getMessage()]);
            }
        }, function ($error) {
            $this->json($error);
        });
    }

    public function done()
    {
        Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
            try {
                // 学生查询
                $param = $_POST;
                $grade_id = $param['down_id'];
                $cls_id = $param['cls_id'];
                $grade_stud_uid = $param['stud_uid'];

                $result = Mvv\mvvStudown::done($userinfor->unionId, $grade_id, $cls_id, $grade_stud_uid);

                $this->json(['code' => 0, 'data' => $result]);
            } catch (Exception $e) {
                $this->json(['code' => 1, 'data' => $e->getMessage()]);
            }
        }, function ($error) {
            $this->json($error);
        });
    }

}
