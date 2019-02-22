<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mvv;
use QCloud_WeApp_SDK\Model;

class Roledist extends CI_Controller
{
  /**
   * 权限分配
   * 根据帐号不同权限，查询不同用户
   * 系统管理员，查询所有用户
   * 学校管理员，查询所在学校用户
   */
  const role_name = 'roledist';
  public function index() {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        /**
         * 查询当前用户所能够设置的权限分组
         */
        $user_id = $userinfor->unionId;
        $result = Mvv\mvvGroup::less($user_id);

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
        /**
         * 本校老师查询
         */
        $param = $_POST;
        $name = $param['name'];
        $user_id = $userinfor->unionId;
        $result = Mvv\mvvRoledist::user($user_id,  Model\x5on::getLike($name));

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function group() {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        /**
         * 获取当前组下用户列表
         */
        $param = $_POST;
        $group_id = $param['group_id'];
        $result = DB::select('xovUserGroup', ['uid', 'user_name', 'nick_name'], compact('group_id'));
        $result = Model\x5on::addIndex($result);

        $result = Mvv\mvvRoledist::group($sch_id, $group_id);


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
        $user_id = $param['user_id'];
        $group_id = $param['group_id'];
        $result = Mvv\mvvRoledist::add($user_id, $group_id);

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
         * 删除选中用户
         */
        $param = $_POST;
        $uid = $param['uid'];
        $result = DB::delete('xonUserGroup', compact('uid'));

        $result = Mvv\mvvRoledist::del($user_id, $group_id);

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
        $uid = $param['uid'];
        $result = DB::delete('xonUserGroup', compact('uid'));

        $result = Mvv\mvvRoledist::member($user_id, $group_id);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }
}