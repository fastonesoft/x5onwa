<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mvv;
use QCloud_WeApp_SDK\Model;

class Studinto extends CI_Controller
{
    /**
     * 学生录取
     */
    const role_name = 'studin';

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

}
