<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Auth\LoginService as LoginService;
use QCloud_WeApp_SDK\Constants as Constants;

class Login extends CI_Controller {
    public function index() {
        $result = LoginService::login();

        if ($result['loginState'] === Constants::S_AUTH) {
            $this->json([
                'code' => 0,
                'data' => $result['userinfo']
            ]);

            // 登录完毕，检测用户是否保存
            $user = $result['userinfo'];
            // 
            $uid = $user['unionId'];
            $name = $user->nickName;
            $fixed = false;
            $create_time = date('Y-m-d H:i:s');
            $last_visit_time = date('Y-m-d H:i:s');
            $res = DB::row('xonUser', ['*'], compact('uid'));
            if ($res === NULL) {
                DB::insert('xonUser', compact('uuid', 'skey', 'create_time', 'last_visit_time', 'open_id', 'session_key', 'user_info'));
            } else {
                DB::update(
                    'cSessionInfo',
                    compact('uuid', 'skey', 'last_visit_time', 'session_key', 'user_info'),
                    compact('open_id')
                );
            }


        } else {
            $this->json([
                'code' => -1,
                'error' => $result['error']
            ]);
        }
    }
}
