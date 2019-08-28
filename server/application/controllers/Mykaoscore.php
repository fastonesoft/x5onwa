<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mvv;
use QCloud_WeApp_SDK\Model;

class Mykaoscore extends CI_Controller
{
    /**
     * 分班成绩
     */
    const role_name = 'mykaoscore';

    public function index()
    {
        Mvv\mvvLogin::check(self::role_name, function ($user) {
            try {
                $result = Mvv\mvvMyKaoScore::grades($user->unionId);

                $this->json(['code' => 0, 'data' => $result]);
            } catch (Exception $e) {
                $this->json(['code' => 1, 'data' => $e->getMessage()]);
            }
        }, function ($error) {
            $this->json($error);
        });
    }

    /**
     * 分班考试表
     */
    public function kaos()
    {
        Mvv\mvvLogin::check(self::role_name, function ($user) {
            try {
                $param = $_POST;
                $grade_id = $param['grade_id'];
                $result = Mvv\mvvMyKaoScore::kaos($user->unionId, $grade_id);

                $this->json(['code' => 0, 'data' => $result]);
            } catch (Exception $e) {
                $this->json(['code' => 1, 'data' => $e->getMessage()]);
            }
        }, function ($error) {
            $this->json($error);
        });
    }

    public function subs()
    {
        Mvv\mvvLogin::check(self::role_name, function ($user) {
            try {
                $param = $_POST;
                $kao_id = $param['kao_id'];
                $result = Mvv\mvvMyKaoScore::subs($user->unionId, $kao_id);

                $this->json(['code' => 0, 'data' => $result]);
            } catch (Exception $e) {
                $this->json(['code' => 1, 'data' => $e->getMessage()]);
            }
        }, function ($error) {
            $this->json($error);
        });
    }

    /**
     * 考试统计
     */
    public function counts()
    {
        Mvv\mvvLogin::check(self::role_name, function ($user) {
            try {
                $param = $_POST;
                $kao_id = $param['kao_id'];
                $sub_id = $param['sub_id'];
                $grade_id = $param['grade_id'];
                $result = Mvv\mvvMyKaoScore::counts($user->unionId, $grade_id, $kao_id, $sub_id);

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
                $kao_id = $param['kao_id'];
                $sub_id = $param['sub_id'];
                $grade_id = $param['grade_id'];
                $result = Mvv\mvvMyKaoScore::add($user->unionId, $grade_id, $kao_id, $sub_id);

                $this->json(['code' => 0, 'data' => $result]);
            } catch (Exception $e) {
                $this->json(['code' => 1, 'data' => $e->getMessage()]);
            }
        }, function ($error) {
            $this->json($error);
        });
    }

}
