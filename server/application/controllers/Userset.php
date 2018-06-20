<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mysql\Mysql as DB;
use QCloud_WeApp_SDK\Model;

class Userset extends CI_Controller {

  /**
   * 获取UserKey列表
   */
  public function index() {
    Model\xonLogin::check(function ($user) {
      // 查询没有禁止的
      $fixed = 0;
      $keys = DB::select('xonUserKey', ['*', 'required as error'], compact('fixed'));
      $user_id = $user['unionId'];
      $values = DB::select('xonUserValue', ['*'], compact('user_id'));

      $result = Model\xonUserset::merge($keys, $values);
      // 返回信息
      $this->json(['code' => 0, 'data' => $result]);
    }, function ($error) {
      $this->json($error);
    });
  }
}