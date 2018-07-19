<?php
namespace QCloud_WeApp_SDK\Model;

use QCloud_WeApp_SDK\Mysql\Mysql as dbs;

class ExamStud {
  public $has_result;
  public $sch_name;
  public $child_name;
  public $form_name;
  public $user_forms;
  public $qrcode_data;

  public function __destruct($uid) {

  }
}