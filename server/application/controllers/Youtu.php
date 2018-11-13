<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Youtuyun\Youtu as you;

class Youtu extends CI_Controller {
  public function index() {
    try {
      $param = $_POST;
      $url = $param['url'];
      $result = you::generalocrurl($url);
      $this->json(['code' => 0, 'data' => $result]);
    } catch (Exception $e) {
      $this->json(['code' => 1, 'data' => $e->getMessage()]);
    }
  }
}
