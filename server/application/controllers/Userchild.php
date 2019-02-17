<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mvv;
use QCloud_WeApp_SDK\Model;

class Userchild extends CI_Controller {
  const role_name = 'userchilds';

  public function index() {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      // 孩子列表
      $result = Model\xonParentChilds::
      $this->json(['code' => 0, 'data' => $userinfor]);
    }, function ($error) {
      $this->json($error);
    });
  }

  public function relation() {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      // 关系表
      $result = Model\xonRelation::gets();

      $this->json(['code' => 0, 'data' => $result]);
    }, function ($error) {
      $this->json($error);
    });
  }

  public function index1() {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      // 孩子信息

      // 返回信息
      $this->json(['code' => 0, 'data' => $userinfor]);
    }, function ($error) {
      $this->json($error);
    });
  }

  public function update () {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        // 获取参数
        $param = $_POST;
        $idc = $param['idc'];
        $name = $param['name'];
        $relation_id = $param['relation_id'];
        $user_id = $user['unionId'];

        // 注册学生，返回值不空，说明出错
        $result = Model\xonChild::insert($idc, $idc, $name);
        if ( $result !== NULL ) {

        }

// todo: 检查一一点点


        // 注册关系
        $result = Model\xonParentChilds::myrelation($user_id, $idc, $relation_id);
        if ($result !== NULL) {
          return $this->json(['code' => 1, 'data' => $result['message']]);
        }

        // 添加家长权限
        Model\xonRoleGroup::add($user_id, Model\x5on::GROUP_STUDENT_PARENT);

        // 刷新孩子列表
        $result = Model\xonParentChilds::mychilds($user_id);

        // 返回信息
        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        return $this->json(['code' => 1, 'data' => $e->getmessage()]);
      }

    }, function ($error) {
      $this->json($error);
    });
  }

  public function parent() {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      // 查询用户列表
      $user_id = $user['unionId'];
      $result = Model\xonParentChilds::mychilds($user_id);
      // 返回信息
      $this->json(['code' => 0, 'data' => $result]);
    }, function ($error) {
      $this->json($error);
    });
  }
}
