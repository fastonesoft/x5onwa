<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Auth\LoginService as LoginService;
use QCloud_WeApp_SDK\Constants as Constants;
use QCloud_WeApp_SDK\Mysql\Mysql as DB;

class Role extends CI_Controller {
    public function index() {
        $result = LoginService::check();

        if ($result['loginState'] === Constants::S_AUTH) {
            // 返回权限列表
            $res = DB::select('xonRole', ['*']);
            $this->json([
                'code' => 0,
                'data' => $res
            ]);
        } else {
            $this->json([
                'error' => -1,
                'message' => '没有登录，不能访问'
            ]);
        }
    }
}