<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mvv;

class Login extends CI_Controller {
  public function index() {
    Mvv\mvvLogin::login(function ($userandskey) {
      try {
        $this->json(['code' => 0, 'data' => $userandskey]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }
}
