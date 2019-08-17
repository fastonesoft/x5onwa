<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \QCloud_WeApp_SDK\Model;
use \QCloud_WeApp_SDK\Mvv;

class App extends X5_Controller
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
//  public function index()
//  {
//    Mvv\mvvWebLogin::login_ci($this, function ($userinfor) {
//      $this->load->view('index.html');
//    }, function () {
//      $this->load->view('weixin_login');
//    });
//  }
//
//  public function user()
//  {
//    Model\x5on::outCros();
//
//    Mvv\mvvWebLogin::login_ci($this, function ($userinfor) {
//      $this->json(['code' => 1, 'data' => $userinfor]);
//    }, function () {
//      $this->json(['code' => -1, 'data' => '没有登录，无法获取用户信息']);
//    });
//  }
//
//  public function menus() {
//    Model\x5on::outCros();
//
//    Mvv\mvvWebLogin::login_ci($this, function ($userinfor) {
//      $this->json(['code' => 1, 'data' => $userinfor]);
//    }, function () {
//      $this->json(['code' => -1, 'data' =>  '没有登录，无法获取菜单列表']);
//    });
//  }

  public function index()
  {
    $this->load->view('index.html');
  }

  public function test() {
    $query = $this->db->query('select * from xonEdu');
    $res = $query->result_array();
    $this->json(['code' => -1, 'data' =>  $res]);
  }


}
