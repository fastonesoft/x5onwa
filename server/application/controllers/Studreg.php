<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mvv;
use QCloud_WeApp_SDK\Model;

class Studreg extends CI_Controller
{
  const role_name = 'regstud';

  public function index()
  {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        // 返回报名孩子与学校列表
        $user_id = $userinfor->unionId;
        $childs = Model\xovUserChilds::getsBy(compact('user_id'));
        $schools = Model\xonSchool::gets();

        $this->json(['code' => 0, 'data' => compact('childs', 'schools')]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  // 报名
  public function reg()
  {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        $param = $_POST;
        $sch_id = $param['sch_id'];
        $child_id = $param['child_id'];

        // 注册学校相关信息
        $school = Model\xonSchool::checkByIdCustom($sch_id, '没有找到编号对应学校');
        $edu_type_id = $school->edu_type_id;

        $user_id = $userinfor->unionId;
        $result = Model\xonStudReg::add($user_id, $child_id, $sch_id, $edu_type_id);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  // 确认报名
  public function check()
  {
    Mvv\mvvLogin::check(self::role_name, function ($user) {
      try {
        $user_id = $user['unionId'];

        $result = Model\xonStudReg::regCheck($user_id);
        // 正文内容
        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  // 取消报名
  public function cancel()
  {
    Mvv\mvvLogin::check(self::role_name, function ($user) {
      try {
        $user_id = $user['unionId'];
        $param = $_POST;
        $sch_id = $param['sch_id'];
        $child_id = $param['child_id'];
        Model\xonStudReg::regCancel($user_id, $sch_id, $child_id);
        $result = Model\xonStudReg::regCancelData($user_id);
        // 正文内容
        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

}
