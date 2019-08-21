<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \QCloud_WeApp_SDK\Model;

class X5Base_Controller extends CI_Controller
{

    // 用户信息
    public $userinfor = null;

    public function __construct()
    {
        parent::__construct();

        $this->userinfor = $this->session->userdata(Model\x5on::SESSION_WEB_LOGIN);
    }

}

class X5Dev_Controller extends X5Base_Controller
{

    public function __construct()
    {
        parent::__construct();

        // 开发用
        Model\x5on::outCors();
    }

}

class X5_Controller extends X5Base_Controller
{

    public function __construct()
    {
        parent::__construct();

        if ($this->userinfor === null) {
            header('location:' . site_url('applogin'));
        }
    }

}