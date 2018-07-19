<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Model;

class Schoolformvalue extends CI_Controller {
  const role_name = 'regstud';

  public function update() {
    Model\xonLogin::check(self::role_name, function ($user) {
      try {
        $param = $_POST;
        $user_id = $user['unionId'];
        $form_id = $param['form_id'];

        // 检测上传的值，是否满足要求
        foreach ($param as $key => $value) {
          if ($key !== 'form_id') {
            // 检测
            $key_id = Model\xonSchoolFormKey::checkKeyValue($form_id, $key, $value);
            // 保存
            Model\xonSchoolFormValue::saveKeyValue($user_id, $form_id, $key_id, $value);
          }
        }
        // 变更已提交状态
        $uid = Model\xonSchoolFormSet::saveSchoolFormSet($user_id, $form_id, 1);
        $qrcode_data = Model\x5on::getQrcodeBase64($uid);
        // 返回刷新数据
        $user_forms = Model\xonSchoolFormKey::listKeysByFormId($user_id, $form_id);
        $result = compact('user_forms', 'qrcode_data');

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }
}
