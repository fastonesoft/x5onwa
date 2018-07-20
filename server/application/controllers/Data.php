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

    // 检测审核人员是否注册学校
    $exam_user_id = 'o47ZhvxoQA9QOOgDSZ5hGaea4xdI';
    $exam_user = Model\xovSchoolTeach::getUserSchool($exam_user_id);
    $exam_sch_id = $exam_user->sch_id;

    // 用户信息
    $param = $_POST;
    //$uid = $param['uid'];
    $uid = '53fbb9ed69facc661cebbb228eb8e521';

    $form_setted = Model\xonSchoolFormSet::getFormSet($uid);
    $user_id = $form_setted->user_id;
    $form_id = $form_setted->form_id;
    $form = Model\xonSchoolForm::getFormById($form_id);
    $sch_id = $form->sch_id;

    if ( $exam_sch_id !== $sch_id ) {
      throw new Exception("用户信息与我校报名要求不符");
    }

    // 返回原二维码
    $qrcode_data = Model\x5on::getQrcodeBase64($uid);
    // 返回刷新数据
    $user_forms = Model\xonSchoolFormKey::listKeysByFormId($user_id, $form_id);
    $result = compact('user_forms', 'qrcode_data');
    var_dump($result);

}

}
