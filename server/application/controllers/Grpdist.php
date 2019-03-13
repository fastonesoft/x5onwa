<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mvv;
use QCloud_WeApp_SDK\Model;

class Grpdist extends CI_Controller {
  /**
   * 集团设置
   */
  const role_name = 'grpdist';
  public function index() {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        // 地区管辖的集团列表
        $user_id = $userinfor->unionId;
        $areas = Model\xovAreasDisted::getsBy(compact('user_id'));
        $members = Model\xovSchoolsDist::getsBy(compact('user_id'));

        $this->json(['code' => 0, 'data' => compact('areas', 'members')]);
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
        $param = $_POST;
        $name =Model\x5on::getLike($param['name']) ;

        // 用户查找
        $result = Model\xovUser::likes(compact('name'));

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
        $param = $_POST;
        $code = $param['code'];
        $name = $param['name'];
        $full_name = $param['full_name'];
        $area_id = $param['area_id'];

        // 集团添加
        $result = Model\xonSchools::add($code, $name, $full_name, $area_id);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function dist() {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        $param = $_POST;
        $user_uid = $param['user_uid'];
        $area_uid = $param['area_uid'];

        // 地区分配、添加用户进组
        $result = Mvv\mvvArea::dist($user_uid, $area_uid);

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
        $param = $_POST;
        $uid = $param['uid'];

        $result = Mvv\mvvArea::del($uid);

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
        $user_id = $userinfor->unionId;
        $result = Model\xovSchoolsDist::getsBy(compact('user_id'));

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

}
