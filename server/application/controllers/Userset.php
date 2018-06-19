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
      $result = DB::select('xonUserKey', ['*'], compact('fixed'));
      // 添加出错标志
      $result = Model\x5on::addError($result);
      // 返回信息
      $this->json(['code' => 0, 'data' => $result]);
    }, function ($error) {
      $this->json($error);
    });
  }
}