<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Auth\LoginService as LoginService;
use QCloud_WeApp_SDK\Constants as Constants;
use QCloud_WeApp_SDK\Mysql\Mysql as DB;

class Login extends CI_Controller {
    public function index() {
        $result = LoginService::login();

        if ($result['loginState'] === Constants::S_AUTH) {
     // 登录完毕，检测用户是否保存
            $infor = $result['userinfo'];
            $uid ='$infor->unionId';
            $name = '$infor->nickName';
            $mobil = NULL;
            $fixed = 0;
            $is_teacher = 0;
            $create_time = date('Y-m-d H:i:s');
            $last_visit_time = date('Y-m-d H:i:s');

            $res = DB::row('xonUser', ['*'], compact('uid'));
            if ($res === NULL) {
                DB::insert('xonUser', compact('uid', 'name', 'mobil', 'fixed', 'is_teacher', 'create_time','last_visit_time'));
            } else {
                DB::update(
                    'xonUser',
                    compact('name', 'mobil', 'fixed', 'is_teacher', 'last_visit_time'),
                    compact('uid')
                );
            }


            $this->json([
                'code' => 0,
                'data' => $result['userinfo']
            ]);
            return;
        } else {
            $this->json([
                'code' => -1,
                'error' => $result['error']
            ]);
        }
    }
}
