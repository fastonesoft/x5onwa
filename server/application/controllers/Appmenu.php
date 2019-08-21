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
        $result = $this->gets('xonEdu');

        $this->json(['code' => 0, 'data' => compact('result')]);
    }

    public function tables() {

        $this->json(['code' => 0, 'data' => $result]);
    }


}
