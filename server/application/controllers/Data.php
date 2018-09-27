<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Model;

try {

  $grade_id = $_GET['id'];
  $finished = Model\xonDivisionSet::getFinishedByGradeId($grade_id);



  if ( ! $finished ) exit('分班未结束');

  $grade_studs = Model\xovGradeDivisionStud::getStudSumRowsByGradeId($grade_id);

  echo $grade_studs;


} catch (Exception $e) {
  exit($e->getMessage());
}

?><!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>分班学生名册</title>
  <style type="text/css">

    ::selection { background-color: #E13300; color: white; }
    ::-moz-selection { background-color: #E13300; color: white; }

    body {
      background-color: #fff;
      margin: 40px;
      font: 13px/20px normal Helvetica, Arial, sans-serif;
      color: #4F5155;
    }

    a {
      color: #003399;
      background-color: transparent;
      font-weight: normal;
      text-decoration: none;
    }

    h1 {
      color: #444;
      background-color: transparent;
      border-bottom: 1px solid #D0D0D0;
      font-size: 19px;
      font-weight: normal;
      margin: 0 0 14px 0;
      padding: 14px 0;
    }

    p.footer {
      text-align: right;
      font-size: 11px;
      border-top: 1px solid #D0D0D0;
      line-height: 32px;
      padding: 0 10px 0 10px;
      margin: 20px 0 0 0;
    }

    .container {
      margin: 10px;
      padding: 10px 20px;
      border: 1px solid #D0D0D0;
      box-shadow: 0 0 8px #D0D0D0;
    }
  </style>
</head>
<body>
<div class="container">
  <h1 style="text-align: center">分班学生名册（新）</h1>
  <table border="1">
    <tr>
      <th>序号</th>
      <th>新班</th>
      <th>姓名</th>
      <th>性别</th>
      <th>原班</th>
      <th>身份证号</th>
      <th>调动标志</th>
    </tr>
    <?php
      $count = 0;
      foreach ($grade_studs as $stud) {
        $count++;

    ?>
    <tr>
      <td><?php echo $count ?></td>
      <td><?php echo $stud->cls_num ?></td>
      <td><?php echo $stud->stud_name ?></td>
      <td><?php echo $stud->stud_sex ?></td>
      <td><?php echo $stud->kao_num ?></td>
      <td><?php echo $stud->stud_idc ?></td>
      <td><?php echo $stud->same_group ?></td>
    </tr>

    <?php

    }
    ?>
  </table>
</div>
</body>
</html>