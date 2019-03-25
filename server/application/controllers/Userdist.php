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
        /**
         * 查询当前用户所能够设置的权限分组
         */
        $groups = Mvv\mvvGroup::groupLess(Model\x5on::GROUP_ADMIN_SCHOOL);
        // 学校管理员管辖的学校列表
        $user_id = $userinfor->unionId;
        $schos = Mvv\mvvUserSchool::schos($user_id);

        $this->json(['code' => 0, 'data' => compact('groups', 'schos')]);
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
        /**
         * 查询所有用户
         */
        $param = $_POST;
        $name = Model\x5on::getLike($param['name']);

        // 用户查找
        $result = Model\xovUser::likes(compact('name'));

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
        /**
         * 添加用户进组
         */
        $param = $_POST;
        $sch_uid = $param['sch_uid'];
        $user_uid = $param['user_uid'];
        $group_uid = $param['group_uid'];
        $user_id = $userinfor->unionId;
        Mvv\mvvUserDist::dists($user_id, $user_uid, $group_uid, $sch_uid);

        $this->json(['code' => 0, 'data' => []]);
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
         * 删除选中用户
         */
        $param = $_POST;
        $user_group_uid = $param['uid'];
        $result = Mvv\mvvRoledist::del($user_group_uid);

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
         * 获取成员列表
         */
        $param = $_POST;
        $sch_uid = $param['sch_uid'];
        $group_uid = $param['group_uid'];
        $user_id = $userinfor->unionId;
        $result = Mvv\mvvUserDist::member($user_id, $group_uid, $sch_uid);

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
         * 获取成员列表
         */
        $param = $_POST;
        $name = $param['name'];
        $sch_uid = $param['sch_uid'];
        $group_uid = $param['group_uid'];
        $user_id = $userinfor->unionId;
        $result = Mvv\mvvUserDist::memfind($user_id, $group_uid, $sch_uid, Model\x5on::getLike($name));

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

}