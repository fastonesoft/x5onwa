<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mvv;
use QCloud_WeApp_SDK\Model;

class Regstud extends CI_Controller
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
        $result = Mvv\mvvRegStud::child_area_reged($user_id);

        $this->json(['code' => 0, 'data' => $result]);
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
        $result = Mvv\mvvRegStud::step($area_id);

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

        $result = Mvv\mvvRegStud::reg($userinfor->unionId, $child_uid, $steps_uid);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  // 报名记录刷新
  public function ref()
  {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        $param = $_POST;
        $stud_reg_uid = $param['uid'];

        $result = Mvv\mvvRegStud::ref($userinfor->unionId, $stud_reg_uid);

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
        $result = Mvv\mvvRegStud::del($user_id, $stud_reg_uid);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

}
