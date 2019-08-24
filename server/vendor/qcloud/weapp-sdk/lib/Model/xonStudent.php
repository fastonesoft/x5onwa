<?php
namespace QCloud_WeApp_SDK\Model;

class xonStudent extends cAppinfo
{
  protected static $tableName = 'xonStudent';
  protected static $tableTitle = '录取学生';

  public static function addStudIn($id, $child_id, $sch_id, $steps_id, $come_auth) {
      $uid = x5on::getUid();
      $come_date = date('Y-m-d');

      self::insert(compact('id', 'uid', 'child_id', 'sch_id', 'steps_id', 'come_auth', 'come_date'));
  }




  // 可以要修改 或 废弃
  public static function add ($child_id, $step_id, $come_date) {
    // 检测当前年级对应学校
    $step = xonStep::checkById($step_id);
    $sch_id = $step->sch_id;

    // 检查学生身份证记录是否存在
    // 已经存在，不添加，直接返回
    $res = self::getBy(compact('child_id', 'sch_id'));
    if ($res !== null) return $res->id;

    // 不存在，则添加
    // 流水号宽度
    $sn_width = 4;
    // 读取最大编号
    $max = self::max('id', compact('step_id'));
    if ($max === null) {
      $sn = 0;
    } else {
      $sn = (int)substr($max, - $sn_width);
    }
    $sn++;
    $id = $step_id . substr('0000' . $sn, - $sn_width);
    $uid = x5on::getUid();
    // 添加
    self::insert(compact('id', 'uid', 'child_id', 'step_id', 'come_date'));
    // 返回编号
    return $id;
  }



// 以下内容要移到 mvv 中去
  public static function checkStudentEnter ($child_id, $sch_id) {
    $res = self::getBy(compact('child_id', 'sch_id'));
    if ($res !== null) {
      $entered = true;
      $sch_name = $res->sch_name;
      $step_name = $res->step_name;
      $stud_name = $res->stud_name;
      $stud_id = $res->id;
      $enter_id = substr($stud_id, -4);
      return compact('entered', 'sch_name', 'step_name', 'stud_name', 'stud_id', 'enter_id');
    } else {
      return false;
    }
  }



}
