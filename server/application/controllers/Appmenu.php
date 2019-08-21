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
        try {
            $result = $this->db->get('xonEdu');
            $this->json(['code' => 0, 'data' => $result]);
        } catch (Exception $e) {
            $this->json(['code' => 1, 'data' => $e->getMessage()]);
        }
    }

    public function tables()
    {
        try {
            $result = $this->x5db->x5gets('xonEdu1');
            $this->json(['code' => 0, 'data' => $result]);
        } catch (Exception $e) {
            $this->json(['code' => 1, 'data' => $e->getMessage()]);
        }
    }


}
