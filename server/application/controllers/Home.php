<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \QCloud_WeApp_SDK\Model;
use \QCloud_WeApp_SDK\Mvv;

class Home extends CI_Controller
{

  /**
   * Index Page for this controller.
   *
   * Maps to the following URL
   *    http://example.com/index.php/welcome
   *  - or -
   *    http://example.com/index.php/welcome/index
   *  - or -
   * Since this controller is set as the default controller in
   * config/routes.php, it's displayed at http://example.com/
   *
   * So any other public methods not prefixed with an underscore will
   * map to /index.php/welcome/<method_name>
   * @see https://codeigniter.com/user_guide/general/urls.html
   */
  public function index()
  {
    Mvv\mvvWebLogin::login_ci($this, function () {
      // 跳转首页
      $this->load->view('home.html');
    }, function () {
      $this->load->view('weixin_login');
    });
  }

  public function logout()
  {
    try {
      $this->session->sess_destroy();

      $this->json(['code' => 0, 'data' => '已退出登录！']);
    } catch (Exception $e) {
      $this->json(['code' => 1, 'data' => $e->getMessage()]);
    }
  }
}
