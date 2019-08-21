<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \QCloud_WeApp_SDK\Mvv;

class Appmenu extends X5Dev_Controller
{

    public function user()
    {
        $this->json(['code' => 0, 'data' => $this->userinfor]);
    }

    public function menus()
    {
        try {
//            $result = Mvv\mvvAppmenu::menus($this->userinfor->unionId);
            $result = Mvv\mvvAppmenu::menus('o47ZhvxoQA9QOOgDSZ5hGaea4xdI');

            $this->json(['code' => 0, 'data' => $result]);
        } catch (Exception $e) {
            $this->json(['code' => 1, 'data' => $e->getMessage()]);
        }
    }


}
