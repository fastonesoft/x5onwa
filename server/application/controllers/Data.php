<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \QCloud_WeApp_SDK\Auth\LoginService as LoginService;
use QCloud_WeApp_SDK\Constants as Constants;
use QCloud_WeApp_SDK\Mysql\Mysql as DB;

class Data extends CI_Controller {
    public function index() {
        // $result = LoginService::check();
        // 临时行为


        for ($i=0; $i<100; $i++) {
          $uid = bin2hex(openssl_random_pseudo_bytes(16));
          $name = bin2hex(openssl_random_pseudo_bytes(16));

          $res = DB::row('xonTest', ['*'], compact('uid'));
          if ($res === NULL) {
              DB::insert('xonTest', compact('uid', 'name'));
          } else {
              DB::update(
                  'xonTest',
                  compact('uid', 'name'),
                  compact('uid')
              );
          }
        }

        $res = DB::select('xonTest', ['*']);

        $this->json([
          'code' => -1,
          'data' => $res
        ]);
    }
}
