<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mvv;
use QCloud_WeApp_SDK\Model;

class App extends CI_Controller {
  /**
   * 应用首页
   */
  public function index() {
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Allow-Origin: http://localhost:8080');

    $ddd = APPPATH;
    $this->json(['code' => 1, 'data' => $ddd]);
  }
}
