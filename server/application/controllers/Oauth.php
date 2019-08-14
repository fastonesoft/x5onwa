<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mvv;
use QCloud_WeApp_SDK\Model;

class Oauth extends CI_Controller
{

  public function index()
  {
    $code = $_GET["code"];
    $appid = "wxecca347b5d64f5c3";
    $secret = "46c045d9a492fd5108b37d40a1e295be";
    if (!empty($code))  //有code
    {
      //通过code获得 access_token + openid
      $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$secret&code=$code&grant_type=authorization_code";
      $jsonResult = file_get_contents($url);
      $resultArray = json_decode($jsonResult, true);
      $access_token = $resultArray["access_token"];
      $openid = $resultArray["openid"];

      //通过access_token + openid 获得用户所有信息,结果全部存储在$infoArray里,后面再写自己的代码逻辑
      $infoUrl = "https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid";
      $infoResult = file_get_contents($infoUrl);
      $infoArray = json_decode($infoResult, true);

      // 登录记录
      $this->session->set_userdata(Model\x5on::SESSION_WEB_LOGIN, $infoArray);

      // 跳转首页
      $this->load->helper('url');
      redirect('/app', 'refresh');
    } else {
      $this->json(['code' => 0, 'data' => 0]);
    }
  }

}
