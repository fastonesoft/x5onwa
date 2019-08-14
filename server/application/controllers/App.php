<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mvv;
use QCloud_WeApp_SDK\Model;

class App extends CI_Controller {
  /**
   * 应用首页
   */
  public function index() {
    $ddd = $this->session->userdata();
    $this->json(['code' => 1, 'data' => $ddd]);
  }
}
