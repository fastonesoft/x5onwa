<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Model;

class Appformkey extends CI_Controller {
  const role_name = 'schcode';
  public function index() {
    Model\xonLogin::check(self::role_name, function ($user) {
      $param = $_POST;
      $sch_id = $param['sch_id'];
      $form_id = $param['form_id'];
      $result = Model\xonAppFormKey::getKeysByFormId($sch_id, $form_id);
      // 正文内容
      $this->json(['code' => 0, 'data' => $result]);
    }, function ($error) {
      $this->json($error);
    });
  }

  public function update() {
    Model\xonLogin::check(self::role_name, function ($user) {
      try {
        $param = $_POST;
        $sch_id = $param['sch_id'];
        $form_id = $param['form_id'];

        // 检测上传的值，是否满足要求
        foreach ($param as $key => $value) {
          if ($key !== 'sch_id' and $key !== 'form_id') {
            // 检测
            $key_id = Model\xonAppFormKey::checkFormKeyValue($form_id, $key, $value);
            // 保存
            Model\xonAppFormValue::saveKeyValue($sch_id, $form_id, $key_id, $value);
          }
        }
        // 创建数据
        Model\xonSchoolCode::saveSchoolCode($param);
        // 正文内容
        $this->json(['code' => 0, 'data' => []]);
      }
      catch (Exception $e) {
        // 出错拦截
        $this->json(['code' => 1, 'data' =>  $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }
}
