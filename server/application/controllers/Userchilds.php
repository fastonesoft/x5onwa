<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mvv;
use QCloud_WeApp_SDK\Model;

class Userchilds extends CI_Controller
{
  /**
   * 用户孩子
   */
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
        // 亲子称谓
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

        // 添加孩子信息
        $child = Model\xonChild::add($idc, $name);
        $child_id = $child->id;

        // 添加亲子关系
        Model\xonUserChilds::add($user_id, $child_id, $relation_id);
        Model\xonUserGroup::add($user_id, Model\x5on::GROUP_STUDENT_PARENT);

        // 刷新孩子列表
        $result = Model\xovUserChilds::getsBy(compact('user_id'));

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getmessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function student() {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        $param = $_POST;
        $uid = $param['uid'];

        // 根据孩子编号，获取学生相关信息，包括二维码
        $qrcode_data = Model\x5on::getQrcodeBase64($uid);

        // 一、基本信息
        $child = Model\xonChild::checkByUid($uid);
        $child_id = $child->id;

        // 二、注册信息
        $students = Model\xovStudent::getsBy(compact('child_id'));

        // 三、年度信息
        $gradestuds = Model\xovGradeStud::getsBy(compact('child_id'));

        $this->json(['code' => 0, 'data' => compact('qrcode_data', 'child', 'students', 'gradestuds')]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }
}
