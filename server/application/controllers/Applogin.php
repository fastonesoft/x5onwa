<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Applogin extends CI_Controller
{
    public function index()
    {
        $this->load->view('weixin_login');
    }

    public function logout()
    {
        $this->session->sess_destroy();
        $this->json(['code' => 0, 'data' => 'logout']);
    }

}
