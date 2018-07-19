<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Model;

class Data extends CI_Controller {
  const role_name = 'test';
  public function index() {
//    Model\xonLogin::check(self::role_name, function ($user) {
//      // 正文内容
//      // 返回信息
//      $this->json(['code' => 0, 'data' => $user]);
//    }, function ($error) {
//      $this->json($error);
//    });

//    $value = 'asdfasdfasf';					//二维码内容
//    $errorCorrectionLevel = 'H';	//容错级别
//    $matrixPointSize = 10;			//生成图片大小
//    //生成二维码图片
//
//    $qr = Model\QRcode::png($value, false, $errorCorrectionLevel, $matrixPointSize, 2);
//     echo $qr;
//

//    $result = Model\xonStudReg::regCheck('o47ZhvzWPWSNS26vG_45Fuz5JMZk');
//    var_dump($result);
//
//


    // 增加权限检测
    $user_id = 'o47ZhvzWPWSNS26vG_45Fuz5JMZk';
    $result = Model\xonStudReg::regCheck($user_id);
    // 正文内容
    $this->json(['code' => 0, 'data' => $result]);
}

}
