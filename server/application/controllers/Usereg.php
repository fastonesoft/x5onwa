<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mvv;
use QCloud_WeApp_SDK\Model;

class Usereg extends CI_Controller
{
  /**
   * 教师用户注册
   * 系统管理员，查询所有用户
   * 学校管理员，查询所在学校用户
   */
  const role_name = 'usereg';
  public function index()
  {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        /**
         * 用户学校查询
         * 如果是管理员返回[学校列表]
         * 有学校返回[学校]、没有学校返回[]
         */
        $user_id = $userinfor->unionId;
        $result = Mvv\mvvUsereg::school($user_id);

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
        /**
         * 不是教师的用户
         * 根据姓名查询出不是教师的用户列表
         */
        $param = $_POST;
        $name = $param['name'];
        $result = Mvv\mvvUsereg::user(Model\x5on::getLike($name));

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
         * 根据提交的数据，注册相应的学校
         */
        $param = $_POST;
        $sch_uid = $param['sch_uid'];
        $user_uid = $param['user_uid'];
        $result = Mvv\mvvUsereg::reg($user_uid, $sch_uid);

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
        $result = Mvv\mvvUsereg::member($sch_uid);

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
        $sch_uid = $param['sch_uid'];
        $name = $param['name'];
        $result = Mvv\mvvUsereg::memfind($sch_uid, Model\x5on::getLike($name));

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
        $user_uid = $param['user_uid'];
        $result = Mvv\mvvUsereg::del($user_uid);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

}