<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mvv;
use QCloud_WeApp_SDK\Model;

class App extends CI_Controller {
  /**
   * 应用首页
   */
  public function index() {
    $se = $this->session->userdata(Model\x5on::SESSION_WEB_LOGIN);
    $this->json(['code' => 0, 'data' => $se]);
  }
}
