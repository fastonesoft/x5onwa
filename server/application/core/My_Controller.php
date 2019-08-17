<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller{

  //构造函数：在构造函数中判断用户是否已经登陆，如果登陆，可进入后台控制器，返回跳转到登陆页面
  public function __construct(){
    parent::__construct();
    $this->load->helper("url");
    $this->load->model("user_model");//user_model模型类实例化对象
    $this->cur_user=$this->user_model->is_login();//检测是否登陆，如果登陆，返回登陆用户信息，否则返回false
    if($this->cur_user === false){
      header("location:".site_url("common/login"));
    }else{
      //如果已经登陆，则重新设置cookie的有效期
      $this->input->set_cookie("username",$this->cur_user['username'],60);
      $this->input->set_cookie("password",$this->cur_user['password'],00);
      $this->input->set_cookie("user_id",$this->cur_user['user_id'],60);
    }
  }

}
