<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mvv;
use QCloud_WeApp_SDK\Model;

class Mykaodivi extends CI_Controller
{
    /**
     * 分班考试
     */
    const role_name = 'mykaodivi';

    public function index()
    {
        Mvv\mvvLogin::check(self::role_name, function ($user) {
            try {
                $result = Mvv\mvvMyKaoDivi::grades($user->unionId);

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
                $result = Mvv\mvvMyKaoDivi::kaos($user->unionId, $grade_id);

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
                $grade_id = $param['grade_id'];
                $result = Mvv\mvvMyKaoDivi::counts($user->unionId, $grade_id, $kao_id);

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
                $grade_id = $param['grade_id'];
                $result = Mvv\mvvMyKaoDivi::add($user->unionId, $grade_id, $kao_id);

                $this->json(['code' => 0, 'data' => $result]);
            } catch (Exception $e) {
                $this->json(['code' => 1, 'data' => $e->getMessage()]);
            }
        }, function ($error) {
            $this->json($error);
        });
    }

}
