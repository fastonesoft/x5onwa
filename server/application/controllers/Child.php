<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Model;

class Child extends CI_Controller {
  const role_name = 'userchilds';
  public function index() {
    Model\xonLogin::check(self::role_name, function ($user) {
      // 孩子信息

      // 返回信息
      $this->json(['code' => 0, 'data' => $user]);
    }, function ($error) {
      $this->json($error);
    });
  }

  public function update () {
    Model\xonLogin::check(self::role_name, function ($user) {
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
}
