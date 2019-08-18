<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Appmenu extends X5Dev_Controller
{

    public function user()
    {
        $this->json(['code' => 0, 'data' => $this->userinfor]);
    }

    public function menus()
    {
        $this->json(['code' => 0, 'data' => []]);
    }


}
