<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mvv;
use QCloud_WeApp_SDK\Model;

class Usersch extends CI_Controller
{
  /**
   * 教师用户注册
   */
  const role_name = 'usersch';
  public function index()
  {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        // 学校教师列表
        $user_id = $userinfor->unionId;
        $result = Mvv\mvvUserSchool::members($user_id);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function user()
  {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        // 普通用户或者教师
        $param = $_POST;
        $name = $param['name'];
        $result = Mvv\mvvUser::likeUser($name);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function reg()
  {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        // 老师注册
        $param = $_POST;
        $user_uid = $param['user_uid'];
        $result = Mvv\mvvUserSchool::dist($userinfor->unionId, $user_uid);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function member() {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        // 教师列表
        $result = Mvv\mvvUserSchool::members($userinfor->unionId);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function memfind() {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        // 教师查询
        $param = $_POST;
        $name = $param['name'];
        $result = Mvv\mvvUserSchool::memfind($userinfor->unionId, $name);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function del() {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        // 教师删除
        $param = $_POST;
        $user_sch_uid = $param['uid'];
        Mvv\mvvUserSchool::del($userinfor->unionId, $user_sch_uid);

        $this->json(['code' => 0, 'data' => []]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

}