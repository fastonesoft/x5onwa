<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Auth\LoginService as LoginService;
use QCloud_WeApp_SDK\Constants as Constants;
use QCloud_WeApp_SDK\Mysql\Mysql as DB;
use QCloud_WeApp_SDK\Model;

class Schcode extends CI_Controller {
  public function index() {
    $result = LoginService::check();
    // 权限判断
    // TODO
    if ($result['loginState'] === Constants::S_AUTH) {
      // 获取参数
      $param = $_POST;
      if (count($param) == 5) {
        // 分段参数
        $howMany = $param['howMany'];
        $paraTotal = $param['paraTotal'];
        $paraBit = $param['paraBit'];
        $paraOrd = $param['paraOrd'];
        $paraPrev = $param['paraPrev'];
        // 生成数据
      } else {
        // 流水参数
        $howMany = $param['howMany'];
        $orderBit = $param['orderBit'];
        $orderPrev = $param['orderPrev'];
        // 生成数据
      }
      // 处理数据
      // 返回信息
      $this->json([
        'code' => 0,
        'data' => $howMany
      ]);
    } else {
      $this->json([
        'code' => -1,
        'data' => []
      ]);
    }
  }
}