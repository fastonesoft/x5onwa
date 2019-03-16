<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mvv;
use QCloud_WeApp_SDK\Model;

class Userset extends CI_Controller
{
  /**
   * 用户设置
   */
  const role_name = 'userset';

  public function index()
  {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        // 返回用户信息
        $user_id = $userinfor->unionId;
        $result = Model\xonUser::checkById($user_id);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function update()
  {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        $param = $_POST;
        $name = $param['name'];
        $mobil = $param['mobil'];

        // 变更用户信息
        $confirmed = 1;
        $user_id = $userinfor->unionId;
        Mvv\mvvUser::update($user_id, $name, $mobil, $confirmed);

        // 返回用户信息
        $result = Model\xonUser::getById($user_id);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function role()
  {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        // 获取权限列表index当中显示
        $user_id = $userinfor->unionId;
        $myroles = Model\xovUserRole::getsBy(compact('user_id'));

        // 处理权限结果，仅返回用户可选权限列表
        $roles = Model\xonRole::gets();
        $cores = Mvv\mvvRole::sign($roles, $myroles);

        // 获取权限分类
        $types = Model\xonType::gets();

        $this->json(['code' => 0, 'data' => compact('types', 'cores')]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }
}
