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
        /**
         * 用户学校查询
         * 如果是管理员返回[学校列表]
         */
        $user_id = $userinfor->unionId;
        $schos = Mvv\mvvUserSchool::schos($user_id);
        $members =

        $this->json(['code' => 0, 'data' => compact('schos', 'members')]);
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
        /**
         * 不是教师的用户
         * 根据姓名查询出不是教师的用户列表
         */
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
        /**
         * 用户注册学校
         */
        $param = $_POST;
        $sch_uid = $param['sch_uid'];
        $user_uid = $param['user_uid'];
        $result = Mvv\mvvUserSchool::distSchTch($userinfor->unionId, $user_uid, $sch_uid);

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
        /**
         * 注册学校教师列表
         */
        $param = $_POST;
        $sch_uid = $param['sch_uid'];
        $result = Mvv\mvvUserSchool::memberSchTch($userinfor->unionId, $sch_uid);

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
        /**
         * 学校教师查询
         */
        $param = $_POST;
        $name = $param['name'];
        $sch_uid = $param['sch_uid'];
        $result = Mvv\mvvUserSchool::memfindSchTch($userinfor->unionId, $sch_uid, $name);

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
        /**
         * 学校教师删除
         */
        $param = $_POST;
        $sch_uid = $param['sch_uid'];
        $user_uid = $param['user_uid'];
        Mvv\mvvUserSchool::del($userinfor->unionId, $user_uid, $sch_uid);

        $this->json(['code' => 0, 'data' => []]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

}