<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mvv;
use QCloud_WeApp_SDK\Model;

class Usereset extends CI_Controller
{
  /**
   * 用户重置
   */
  const role_name = 'usereset';
  public function index()
  {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        /**
         * 用户查询
         * 系统管理员 => 重置所有用户
         */
        $param = $_POST;
        $name = $param['name'];
        $result = Mvv\mvvUsereset::user($userinfor->unionId, Model\x5on::getLike($name));

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
        /**
         * 用户重置
         * 确认状态、是否冻结……
         */
        $param = $_POST;
        $user_uid = $param['uid'];
        $fixed = $param['fixed'];
        $confirmed = $param['confirmed'];
        $result = Mvv\mvvUsereset::update($userinfor->unionId, $user_uid, Model\x5on::getBool($confirmed), Model\x5on::getBool($fixed));

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }


}