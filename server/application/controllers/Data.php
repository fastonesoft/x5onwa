<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \QCloud_WeApp_SDK\Auth\LoginService as LoginService;
use QCloud_WeApp_SDK\Constants as Constants;
use QCloud_WeApp_SDK\Mysql\Mysql as DB;

class Data extends CI_Controller {
    public function index() {
        // $result = LoginService::check();
        // 临时行为


        // 数据添加
//        for ($i=0; $i<100; $i++) {
//          $uid = bin2hex(openssl_random_pseudo_bytes(16));
//          $name = bin2hex(openssl_random_pseudo_bytes(16));
//
//          $res = DB::row('xonTest', ['*'], compact('uid'));
//          if ($res === NULL) {
//              DB::insert('xonTest', compact('uid', 'name'));
//          } else {
//              DB::update(
//                  'xonTest',
//                  compact('uid', 'name'),
//                  compact('uid')
//              );
//          }
//        }
        // 用户数据 测试
//        $uid = bin2hex(openssl_random_pseudo_bytes(16));
//        $name = bin2hex(openssl_random_pseudo_bytes(16));
//        $mobil = null;
//        $fixed = 1;
//        $create_time = date('Y-m-d H:i:s');
//        $last_visit_time = $create_time;
//
//
//        $res = DB::row('xonUser', ['*'], compact('uid'));
//        if ($res === NULL) {
//            DB::insert('xonUser', compact('uid', 'name', 'mobil', 'fixed', 'create_time', 'last_visit_time'));
//        } else {
//            DB::update(
//                'xonUser',
//                compact('name', 'last_visit_time'),
//                compact('uid')
//            );
//        }

        // $uid = bin2hex(openssl_random_pseudo_bytes(16));
        // $group_id = 1;
        // $user_uid = 'asdfasdf';

        // // 只要用户已经有权限组，不再添加
        // $res = DB::row('xonUserGroup', ['*'], compact('user_uid'));
        // if ($res === NULL) {
        //     DB::insert('xonUserGroup', compact('user_uid', 'group_id', 'uid'));
        // }

        // $res = DB::select('xonUserGroup', ['*']);
        // $this->json([
        //   'code' => -1,
        //   'data' => $res
        // ]);

        $this->json([
          'code' => -1,
          'data' => []
        ]);
    }
}
