<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mvv;
use QCloud_WeApp_SDK\Model;

class Userchilds extends CI_Controller
{
  const role_name = 'userchilds';

  public function index()
  {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        // 孩子列表
        $user_id = $userinfor->unionId;
        $result = Model\xovUserChilds::getsBy(compact('user_id'));

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function relation()
  {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        // 关系表
        $result = Model\xonRelation::gets();

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
        $param = $_POST;
        $idc = $param['idc'];
        $name = $param['name'];
        $relation_id = $param['relation_id'];
        $user_id = $userinfor->unionId;

        // 新的孩子信息，直接添加
        // 根据身份证号确认是否为新的孩子信息
        $child = Model\xonChild::add($idc, $name);
        $child_id = $child->id;

        // 添加亲子关系
        Model\xonUserChilds::add($user_id, $child_id, $relation_id);




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

  public function parent()
  {
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
