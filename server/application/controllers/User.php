<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \QCloud_WeApp_SDK\Auth\LoginService as LoginService;
use QCloud_WeApp_SDK\Constants as Constants;

class User extends CI_Controller {
    public function index() {
        $result = LoginService::check();

        if ($result['loginState'] === Constants::S_AUTH) {
            $this->json([
                'error' => 0,
                'data' => $result['userinfo']
            ]);
        } else {
            $this->json([
                'error' => -1,
                'data' => []
            ]);
        }
    }
}
