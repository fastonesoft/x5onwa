<?php defined('BASEPATH') OR exit('No direct script access allowed');

use \QCloud_WeApp_SDK\Model;

class X5_Controller extends CI_Controller
{

  // 登录用户信息
  public $userinfor = null;

  public function __construct()
  {
    parent::__construct();

    // 自定义内容
    $this->userinfor = $this->session->userdata(Model\x5on::SESSION_WEB_LOGIN);

    if ($this->userinfor === null) {
      header('location:' . site_url('applogin'));
    }
  }

}
