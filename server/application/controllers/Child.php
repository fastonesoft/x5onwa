<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Model;

class Child extends CI_Controller {
  public function index() {
    Model\xonLogin::check(function ($user) {
      // 孩子信息

      // 返回信息
      $this->json(['code' => 0, 'data' => $user]);
    }, function ($error) {
      $this->json($error);
    });
  }

  public function update () {
    Model\xonLogin::check(function ($user) {
      // 获取参数
      $param = $_POST;
      $id = $param['idc'];
      $idc = $id;
      $name = $param['name'];
      $relation_id = $param['relation_id'];

      // 注册学生
      $result = Model\xonChild::insert($id, $idc, $name);
      if ( $result !== NULL ) {
        $this->json(['code' => -1, 'data' => $result['message']]);
        return;
      }

      // 注册关系

      // 返回信息
      $this->json(['code' => 0, 'data' => $user]);
    }, function ($error) {
      $this->json($error);
    });
  }
}
