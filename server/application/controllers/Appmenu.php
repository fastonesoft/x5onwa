<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \QCloud_WeApp_SDK\Model;

class Appmenu extends X5Base_Controller
{

    public function user()
    {
        Model\x5on::outCors();
        $this->json(['code' => 0, 'data' => $this->userinfor]);
    }

    public function menus()
    {
        Model\x5on::outCors();
        $this->json(['code' => 0, 'data' => []]);
    }


}
