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
        $my_user_id = $user_id;
        $childs = Model\xovUserChilds::getsBy(compact('user_id'));
        $schools = Model\xonSchool::gets();
        // 用户孩子的报名信息
        $studregs = Model\xovUserChildsReg::getsBy(compact('my_user_id'));

        $this->json(['code' => 0, 'data' => compact('childs', 'schools', 'studregs')]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  // 报名注册
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
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        $param = $_POST;
        $stud_reg_uid = $param['uid'];

        // 根据用户及注册编号，确认注册信息
        $user_id = $userinfor->unionId;
        Mvv\mvvStudreg::checked($user_id, $stud_reg_uid);

        $this->json(['code' => 0, 'data' => $stud_reg_uid]);
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
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        $param = $_POST;
        $stud_reg_uid = $param['uid'];

        // 根据用户及注册编号，取消注册信息
        $user_id = $userinfor->unionId;
        Mvv\mvvStudreg::cancel($user_id, $stud_reg_uid);

        $this->json(['code' => 0, 'data' => $stud_reg_uid]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

}
