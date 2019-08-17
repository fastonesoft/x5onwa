<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mvv;
use QCloud_WeApp_SDK\Model;

class Applogin extends CI_Controller
{
  public function index()
  {
    $this->session->set_userdata(Model\x5on::SESSION_WEB_LOGIN, 'asdfasdfasdfasdf');
//    $this->load->view('weixin_login');
  }

  public function logout() {
    $this->session->sess_destroy();
    redirect('/');
  }

}
