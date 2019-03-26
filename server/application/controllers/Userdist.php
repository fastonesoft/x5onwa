<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mvv;
use QCloud_WeApp_SDK\Model;

class Userdist extends CI_Controller
{
  /**
   * 教师权限分配
   */
  const role_name = 'userdist';
  public function index() {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        // 查询当前用户所能够设置的权限分组
        $result = Mvv\mvvGroup::groupLess(Model\x5on::GROUP_ADMIN_SCHOOL);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function user() {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        // 教师查找
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

  public function add() {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        // 添加教师进组
        $param = $_POST;
        $user_uid = $param['user_uid'];
        $group_uid = $param['group_uid'];
        $result = Mvv\mvvUserSchoolGroup::dist($userinfor->unionId, $user_uid, $group_uid);

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
        // 删除教师
        $param = $_POST;
        $user_sch_group_uid = $param['user_sch_group_uid'];
        $result = Mvv\mvvUserSchoolGroup::del($userinfor->unionId, $user_sch_group_uid);

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
        // 获取成员列表
        $param = $_POST;
        $group_uid = $param['group_uid'];
        $result = Mvv\mvvUserSchoolGroup::members($userinfor->unionId, $group_uid);

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
        // 成员查询
        $param = $_POST;
        $name = $param['name'];
        $group_uid = $param['group_uid'];
        $result = Mvv\mvvUserSchoolGroup::memfind($userinfor->unionId, $group_uid, $name);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

}