<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mvv;
use QCloud_WeApp_SDK\Model;

class Studreg extends CI_Controller
{
  /**
   * 新生注册
   */
  const role_name = 'regstud';
  public function index()
  {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        // 返回报名孩子与学校列表
        $user_id = $userinfor->unionId;
        $my_user_id = $user_id;
        $childs = Model\xovUserChilds::getsBy(compact('user_id'));
        // 地级市开头的形式
        $area_type = 2;
        $areas = Model\xovAreas::getsBy(compact('area_type'));
        // 用户孩子的报名信息
        $studregs = Model\xovUserChildsReg::getsBy(compact('my_user_id'));

        $this->json(['code' => 0, 'data' => compact('childs', 'areas', 'studregs')]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  // 地区学校查询
  public function step()
  {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        $param = $_POST;
        $area_id = $param['area_id'];
        $can_recruit = 1;
        $result = Model\xovSchStep::getsBy(compact('area_id', 'can_recruit'));

        $this->json(['code' => 0, 'data' => $result]);
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
        $steps_uid = $param['steps_uid'];
        $child_uid = $param['child_uid'];

        $result = Mvv\mvvStudreg::reg($userinfor->unionId, $child_uid, $steps_uid);

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

  public function studenroll()
  {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        $param = $_POST;
        $uid = $param['uid'];

        // 根据孩子编号，获取学生相关信息，包括二维码
        $qrcode_data = Model\x5on::getQrcodeBase64($uid);

        // 一、基本信息
        $child = Model\xonChild::checkByUid($uid);
        $child_id = $child->id;

        // 二、用户孩子"已确认"的报名信息
        $my_user_id = $userinfor->unionId;
        $confirmed = 1;
        $studregs = Model\xovUserChildsReg::getsBy(compact('my_user_id', 'confirmed'));

        // 三、录取信息
        $students = Model\xovStudent::getsBy(compact('child_id'));

        $this->json(['code' => 0, 'data' => compact('qrcode_data', 'child', 'students', 'studregs')]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }



}
