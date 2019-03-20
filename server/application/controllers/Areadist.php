<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mvv;
use QCloud_WeApp_SDK\Model;

class Areadist extends CI_Controller
{
  /**
   * 地区分配
   */
  const role_name = 'areadist';

  public function index()
  {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        // 地区、地区分配用户查询
        $param = $_POST;
        $area_type = $param['area_type'];
        $result = Mvv\mvvArea::refresh($area_type);

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
        $area_uid = $param['area_uid'];
        $area_type = $param['area_type'];

        // 地区分配、添加用户进组
        Mvv\mvvArea::dist($user_uid, $area_uid);
        $result = Mvv\mvvArea::refresh($area_type);

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
        $id = $param['id'];
        $name = $param['name'];
        $area_type = $param['area_type'];

        // 地区添加
        Model\xonArea::add($id, $name);
        $result = Mvv\mvvArea::refresh($area_type);

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
        $area_type = $param['area_type'];

        // 地区分配用户删除
        Mvv\mvvArea::del($uid);
        $result = Mvv\mvvArea::refresh($area_type);

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
        $area_type = $param['area_type'];
        $user_name = Model\x5on::getLike($param['name']);

        // 地区分配查询
        $result = Model\xovAreasDist::likes(compact('area_type', 'user_name'));

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

}
