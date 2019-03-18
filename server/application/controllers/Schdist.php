<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mvv;
use QCloud_WeApp_SDK\Model;

class Schdist extends CI_Controller
{
  /**
   * 学校设置
   */
  const role_name = 'schdist';
  public function index()
  {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        // 用户所属集团列表
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

  public function user()
  {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        $param = $_POST;
        $name = Model\x5on::getLike($param['name']);

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

  public function add()
  {
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

  public function dist()
  {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        $param = $_POST;
        $user_uid = $param['user_uid'];
        $schs_uid = $param['schs_uid'];

        // 地区分配、添加用户进组
        $result = Mvv\mvvSchools::dist($user_uid, $schs_uid);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function del()
  {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        $param = $_POST;
        $uid = $param['uid'];

        $result = Mvv\mvvSchools::del($uid);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function sch()
  {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        $param = $_POST;
        $schs_id = $param['schs_id'];

        $schos = Model\xovSchool2Dist::getsBy(compact('schs_id'));
        $members = Model\xovSchoolDist::getsBy(compact('schs_id'));

        $this->json(['code' => 0, 'data' => compact('schos', 'members')]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function member()
  {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        $area_user_id = $userinfor->unionId;
        $result = Model\xovSchoolDist::getsBy(compact('area_user_id'));

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function memfind()
  {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        $param = $_POST;
        $user_name = Model\x5on::getLike($param['name']);

        $area_user_id = $userinfor->unionId;
        $result = Model\xovSchoolsDist::likes(compact('area_user_id', 'user_name'));

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }


}
