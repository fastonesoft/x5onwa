<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mysql\Mysql as DB;
use QCloud_WeApp_SDK\Model;

class Roledist extends CI_Controller
{
  /**
   * 权限分配
   *
   */
  public function index()
  {
    Model\xonLogin::check(function ($user) {
      // 分组列表
      $result = DB::select('xonGroup', ['id', 'name'], '', 'and', 'order by id');
      // 返回信息
      $this->json(['code' => 0, 'data' => $result]);
    }, function ($error) {
      $this->json($error);
    });
  }
}