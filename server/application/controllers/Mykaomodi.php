<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mvv;
use QCloud_WeApp_SDK\Model;

class Mykaomodi extends CI_Controller
{
    const role_name = 'mykaomodi';
    public function index()
    {
        Mvv\mvvLogin::check(self::role_name, function ($user) {
            try {
                $result = Mvv\mvvMyKaoModi::grades($user->unionId);

                // 年级列表
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
                $stud_name = Model\x5on::getLike($param['stud_name']);

                // 模糊查询学生
                $result = Mvv\mvvMyKaoModi::query($user->unionId, $grade_id, $stud_name);
                $this->json(['code' => 0, 'data' => $result]);
            } catch (Exception $e) {
                $this->json(['code' => 1, 'data' => $e->getMessage()]);
            }
        }, function ($error) {
            $this->json($error);
        });
    }

    public function update()
    {
        Mvv\mvvLogin::check(self::role_name, function ($user) {
            try {
                $param = $_POST;
                $kao_stud_id = $param['kao_stud_id'];
                $value = $param['value'];
                // 年度学生修改
                $result = Mvv\mvvMyKaoModi::update($user->unionId, $kao_stud_id, $value);
                $this->json(['code' => 0, 'data' => $result]);
            } catch (Exception $e) {
                $this->json(['code' => 1, 'data' => $e->getMessage()]);
            }
        }, function ($error) {
            $this->json($error);
        });
    }


}
